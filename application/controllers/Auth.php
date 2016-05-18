<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

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
        // Your own constructor code
    }

    public $data = array();
    public $template = array();

    public function _checkauth() {

        if (($this->session->userdata('is_logged_in') != '')) {
            if ($this->session->userdata('url_back') != '') {
                redirect($this->session->userdata('url_back'));
            } else {
                redirect('home');
            }
        }
    }

    public function login() {

        $this->_checkauth();
        $this->form_validation->set_rules('username', 'Username', 'trim|required', array('required' => '- กรุณาใส่ %s.')
        );
        $this->form_validation->set_rules('password', 'Password', 'trim|required', array('required' => '- กรุณาใส่ %s.')
        );

        if ($this->form_validation->run() == FALSE) {

            $this->load->view('login');
        } else {
            //  $this->load->view('login');
            $data = array(
                'username' => $this->input->post('username'),
                'password' => encode_login(trim($this->input->post('password'))),
            );

            
            $condition = "username =" . "'" . $data['username'] . "' AND " . "password =" . "'" . $data['password'] . "'";

            $this->db->select('*');
            $this->db->from('users');
            $this->db->where($condition);
            $this->db->limit(1);
            $query = $this->db->get();


            if ($query->num_rows() == 1) {

                $row = $query->row_array();


                //  $data['message_display'] = 'Username already exist!';
                // $this->load->view('login', $data);
                $this->session->set_userdata('users_id', $row['id']);
                $this->session->set_userdata('name', $row['name']);
                $this->session->set_userdata('is_logged_in', '1');
                
                $this->session->set_userdata('group', $row['group']);
                $this->session->set_userdata('position', $row['position']);
                
                if ($this->session->userdata('url_back') != '') {
                    redirect($this->session->userdata('url_back'));
                } else {
                    redirect('home');
                }

                //redirect($this->agent->referrer());
                // redirect('member/add');
                // redirect($this->session->flashdata('redirectToCurrent'));
            } else {

                $this->session->set_flashdata('message', '- ไม่มีผู้ใช้งานนี้');
                $this->load->view('login');
            }
        }
    }

    public function logout() {

        $this->session->sess_destroy();
        // echo $this->session->userdata('is_logged_in');
        session_destroy();
        redirect('auth/login');
    }

}
