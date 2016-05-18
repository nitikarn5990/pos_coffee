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

        // $this->load->view('bill', '', false);
    }

    public function fetch_comments() {


        $this->db->select("*, CONCAT(customer_firstname, ' ', customer_lastname) as full_name");
        $this->db->from('active_rent');
        $this->db->join('room', 'active_rent.room_id = room.id');
        $this->db->join('member', 'active_rent.member_id = member.id');

        $start_date = '2016-08';
        $end_date = '2016-08';

        $this->db->where('pay_monthly BETWEEN "' . $start_date . '" and "' . $end_date . '"');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function unpaid() {


        if ($this->input->post('btn_submit') == 'ค้นหา') {


            $this->db->select("*, active_rent.id , active_rent.rental_id,CONCAT(customer_firstname, ' ', customer_lastname) as full_name");
            $this->db->from('active_rent');
            $this->db->join('room', 'active_rent.room_id = room.id');
            $this->db->join('member', 'active_rent.member_id = member.id');

            if (trim($this->input->post('rental_id')) != '') {
                $this->db->where('rental_id = ' . trim($this->input->post('rental_id')));
            }

            if (trim($this->input->post('customer_firstname')) != '') {

                $this->db->like('customer_firstname ', trim($this->input->post('customer_firstname')));
            }
            if (trim($this->input->post('customer_lastname')) != '') {

                $this->db->like('customer_lastname ', trim($this->input->post('customer_lastname')));
            }
            if (trim($this->input->post('number_room')) != '') {


                $this->db->where("number_room = " . trim($this->input->post('number_room')));
            }
            if (trim($this->input->post('pay_monthly1')) != '' && trim($this->input->post('pay_monthly2')) != '') {

                $start_date = trim($this->input->post('pay_monthly1'));
                $end_date = trim($this->input->post('pay_monthly2'));

                $this->db->where('pay_monthly BETWEEN "' . $start_date . '" and "' . $end_date . '"');
            }


            $query = $this->db->get();
            //print_r($query->result_array());
            // die();



            $dataView = [
                'res_active_rent' => $query->result_array(),
                    //'result_active_payment' => $result_active_payment
            ];

            $data = array(
                'content' => $this->load->view('report/unpaid', $dataView, true),
            );
            $this->load->view('main_layout', $data);
        } else {

            $this->db->select("*, active_rent.id , active_rent.rental_id,CONCAT(customer_firstname, ' ', customer_lastname) as full_name");
            $this->db->from('active_rent');
            $this->db->join('room', 'active_rent.room_id = room.id');
            $this->db->join('member', 'active_rent.member_id = member.id');
            $query = $this->db->get();
            $dataView = [
                'res_active_rent' => $query->result_array(),
                    //'result_active_payment' => $result_active_payment
            ];
            $data = array(
                'content' => $this->load->view('report/unpaid', $dataView, true),
            );
            $this->load->view('main_layout', $data);
        }
    }

     public function income() {


        if ($this->input->post('btn_submit') == 'ค้นหา') {


            $this->db->select("*, active_rent.id , active_rent.rental_id,CONCAT(customer_firstname, ' ', customer_lastname) as full_name");
            $this->db->from('active_rent');
            $this->db->join('room', 'active_rent.room_id = room.id');
            $this->db->join('member', 'active_rent.member_id = member.id');

           
            if (trim($this->input->post('pay_monthly1')) != '' && trim($this->input->post('pay_monthly2')) != '') {

                $start_date = trim($this->input->post('pay_monthly1'));
                $end_date = trim($this->input->post('pay_monthly2'));

                $this->db->where('pay_monthly BETWEEN "' . $start_date . '" and "' . $end_date . '"');
            }


            $query = $this->db->get();
            //print_r($query->result_array());
            // die();



            $dataView = [
                'res_active_rent' => $query->result_array(),
                    //'result_active_payment' => $result_active_payment
            ];

            $data = array(
                'content' => $this->load->view('report/income', $dataView, true),
            );
            $this->load->view('main_layout', $data);
        } else {

            $this->db->select("*, active_rent.id , active_rent.rental_id,CONCAT(customer_firstname, ' ', customer_lastname) as full_name");
            $this->db->from('active_rent');
            $this->db->join('room', 'active_rent.room_id = room.id');
            $this->db->join('member', 'active_rent.member_id = member.id');
            $query = $this->db->get();
            $dataView = [
                'res_active_rent' => $query->result_array(),
                    //'result_active_payment' => $result_active_payment
            ];
            $data = array(
                'content' => $this->load->view('report/income', $dataView, true),
            );
            $this->load->view('main_layout', $data);
        }
    }
    public function bill_end_month($id = '') {



        $res_active_rent = $this->db->get_where('active_rent', array('id' => $id))->row_array();
        $number_room = $this->db->get_where('room', array('id' => $res_active_rent['room_id']))->row_array()['number_room'];

        $res_member = $this->db->get_where('member', array('id' => $res_active_rent['member_id']))->row_array();


        $electric_rate = $this->db->get_where('electric_rate', array('id' => 1))->row_array()['rate_price'];
        $water_rate = $this->db->get_where('water_rate', array('id' => 1))->row_array()['rate_price'];

        $data = [
            'res_active_rent' => $res_active_rent,
            'number_room' => $number_room,
            'monthly' => ShowDateTh($res_active_rent['pay_monthly']),
            'updated_at' => ShowDateThTime(DATE_TIME),
            'res_member' => $res_member,
            'electric_rate' => $electric_rate,
            'water_rate' => $water_rate
        ];

        //บิลเก็บเงินตอนสิ้นเดือน
        $this->load->view('bill_end_month', $data, false);
    }

    public function bill_end_month_receipt($id = '') {
        //พิมพ์ใบเสร็จรับเงิน

        $res_active_rent = $this->db->get_where('active_rent', array('id' => $id))->row_array();



        $number_room = $this->db->get_where('room', array('id' => $res_active_rent['room_id']))->row_array()['number_room'];

        $res_member = $this->db->get_where('member', array('id' => $res_active_rent['member_id']))->row_array();


        $electric_rate = $this->db->get_where('electric_rate', array('id' => 1))->row_array()['rate_price'];
        $water_rate = $this->db->get_where('water_rate', array('id' => 1))->row_array()['rate_price'];

        $data = [
            'res_active_rent' => $res_active_rent,
            'number_room' => $number_room,
            'monthly' => ShowDateTh($res_active_rent['pay_monthly']),
            'updated_at' => ShowDateThTime(DATE_TIME),
            'res_member' => $res_member,
            'electric_rate' => $electric_rate,
            'water_rate' => $water_rate
        ];

        //บิลเก็บเงินตอนสิ้นเดือน
        $this->load->view('bill_end_month_receipt', $data, false);
    }

    public function bill_el_water() {

        //บิลเก็บเงินตอนสิ้นเดือน
        $this->load->view('bill_el_water', '', false);
    }

    public function bill3() {
        $this->load->view('bill', '', false);
    }

    public function bill2() {


        $data = [];

        //load mPDF library
        $this->load->library('m_pdf');

        $html = $this->load->view('bill', $data, true);

        $this->m_pdf->pdf->WriteHTML($html);
        //download it.

        $this->m_pdf->pdf->Output();
    }

}
