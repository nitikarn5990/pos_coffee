<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Damages extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {

        parent::__construct();

        if ($this->session->userdata('is_logged_in') == '') {

            $this->session->set_userdata('url_back', current_url());
            redirect('auth/login');
        }
    }

    public function index($id = '') {


        $result_rental = $this->db->get_where('rental', array('id' => $id))
                ->row_array();



        $res_member = $this->db->get_where('member', array('id' => $result_rental['member_id']))
                ->row_array();
        
        
      
        $dataRes = [

            'result_rental' => $result_rental,
            'res_member' => $res_member
        ];
        if ($result_rental['id'] != '') {

            $data = array(
                'content' => $this->load->view('damages', $dataRes, true),
            );
        } else {
            $data = array(
                'content' => $this->load->view('404', '', true),
            );
        }


        $this->load->view('main_layout', $data);
    }
    public function save(){
     
        
       foreach ($this->input->post('detail') as $key => $value) {
           
       
           $dataInsert = array(
                'rental_id' => $this->input->post('rental_id'),
                'detail' => $value,
      
                'price' => $this->input->post('price')[$key],
     
                'created_at' => DATE_TIME,
                'updated_at' => DATE_TIME,
          
            );

            if ($this->db->insert('damages', $dataInsert)) {
                 redirect(base_url('damages/index/'.$this->input->post('rental_id')));
              
            }
       }
     
    }
    public function delete($rental_id ='',$id = ''){
     
        
        if ($id != '') {
           
            if($this->db->delete('damages', array('id' => $id))){
                redirect(base_url('damages/index/'.$rental_id));
            }
            
        }
     
    }

}
