<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class report extends CI_Controller {

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

    public function index() {

     
        redirect('report/sales');
    }


    public function sales() {


        if ($this->input->post('btn_submit') == 'ค้นหา') {

            
        
            if ($this->input->post('report_type') == 'ยอดขาย') {


                $this->db->select("DATE_FORMAT(active_order.created_at, '%Y-%m-%d') AS formatted_date ,active_order.created_at, SUM(active_order_detail.qty * active_order_detail.price ) as total ");
                $this->db->from('active_order');
                $this->db->where('paid_date !=', '0000-00-00 00:00:00');
                $this->db->join('active_order_detail', 'active_order.id = active_order_detail.active_order_id');

                //  $this->db->join('member', 'active_rent.member_id = member.id');
                $start_date = trim($this->input->post('date_start'));
                $end_date = trim($this->input->post('date_end'));

                if (trim($start_date) != '' && trim($end_date) != '') {

                    $this->db->where('active_order.created_at BETWEEN "' . $start_date . '" and "' . $end_date . '"');
                    $this->db->group_by('DATE(active_order.created_at)');

                    // echo $this->db->get_compiled_select();
                    // die();
                    $query = $this->db->get();
                    //   print_r($query->result_array());
                    //    die();

                    $dataView = [
                        'res_active_order_sales' => $query->result_array(),
                        'type' => 'ยอดขาย'
                            //'result_active_payment' => $result_active_payment
                    ];

                    $data = array(
                        'content' => $this->load->view('report/sales', $dataView, true),
                    );
                    $this->load->view('main_layout', $data);
                } else {
                    redirect('report/sales');
                }
            }
            if ($this->input->post('report_type') == 'สินค้า') {


                $this->db->select("active_order_detail.*,SUM(active_order_detail.qty * active_order_detail.price) as total_price");
                $this->db->select("SUM(active_order_detail.qty) as total_qty");
                $this->db->select("menu.product");
                $this->db->from('active_order');
                $this->db->where('paid_date !=', '0000-00-00 00:00:00');
                $this->db->join('active_order_detail', 'active_order.id = active_order_detail.active_order_id');
                $this->db->join('menu', 'active_order_detail.menu_id = menu.id');

                //  $this->db->join('member', 'active_rent.member_id = member.id');
                $start_date = trim($this->input->post('date_start'));
                $end_date = trim($this->input->post('date_end'));

                if (trim($start_date) != '' && trim($end_date) != '') {

                    $this->db->where('active_order.created_at BETWEEN "' . $start_date . '" and "' . $end_date . '"');
                    $this->db->group_by('active_order_detail.menu_id');
                    $this->db->group_by('active_order_detail.menu_type');
                    $this->db->order_by('active_order_detail.menu_id', 'ASC');
                    $this->db->order_by('active_order_detail.menu_type', 'ASC');

                    // echo $this->db->get_compiled_select();
                    // die();
                    $query = $this->db->get();
                    //  print_r($query->result_array());
                    //  die();

                    $dataView = [
                        'res_active_order_sales' => $query->result_array(),
                        'type' => 'สินค้า'
                            //'result_active_payment' => $result_active_payment
                    ];

                    $data = array(
                        'content' => $this->load->view('report/sales', $dataView, true),
                    );
                    $this->load->view('main_layout', $data);
                } else {
                    redirect('report/sales');
                }
            }
        } else {



            $this->db->select("DATE_FORMAT(active_order.created_at, '%Y-%m-%d') AS formatted_date ,active_order.created_at, SUM(active_order_detail.qty * active_order_detail.price ) as total ");
            $this->db->from('active_order');
            $this->db->where('paid_date !=', '0000-00-00 00:00:00');
            $this->db->join('active_order_detail', 'active_order.id = active_order_detail.active_order_id');
            $this->db->group_by('DATE(active_order.created_at)');

            $query = $this->db->get();

            $dataView = [
                'res_active_order_sales' => $query->result_array(),
                'type' => ''
            ];

            $data = array(
                'content' => $this->load->view('report/sales', $dataView, true),
            );
            $this->load->view('main_layout', $data);
        }
    }

   

}
