<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {

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

        //$condition = "username =" . "'" . $data['username'] . "' AND " . "password =" . "'" . $data['password'] . "'";

        $this->db->select('*');
        $this->db->from('member');
        //    $this->db->where($condition);
        //  $this->db->limit(1);
        $this->db->order_by("id", "asc");
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
//
            // $row = $query->row_array();

            $resultq1 = $query->result_array();
            $data['resultq1'] = $resultq1;



            $data = array(
                'content' => $this->load->view('member/index', $data, true),
            );
        } else {
            $data = array(
                'content' => $this->load->view('member/index', '', true),
            );
        }

        $this->load->view('main_layout', $data);
    }

    public function member_list() {



        $this->db->select('*');
        $this->db->from('member');
        //    $this->db->where($condition);
        //  $this->db->limit(1);
        $this->db->order_by("id", "asc");
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
//
            // $row = $query->row_array();
           
            $resultq1 = $query->result_array();
           
           
         
           
             $data['resultq1'] = $resultq1;
         

            //  $data = array(
            $this->load->view('member_list', $data);
            // );
        } else {
            $data = array(
                'content' => $this->load->view('member_list', '', true),
            );
        }

        // $this->load->view('main_layout', $data);
    }

    public function edit($id) {

        //$condition = "username =" . "'" . $data['username'] . "' AND " . "password =" . "'" . $data['password'] . "'";



        $this->db->select('*');
        $this->db->from('member');
        $this->db->where('id = ' . $id);
        $this->db->limit(1);
        $this->db->order_by("id", "asc");
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
//
            // $row = $query->row_array();

            $row = $query->row_array();

            $data = array(
                'id' => $row['id'],
                'customer_firstname' => $row['customer_firstname'],
                'customer_lastname' => $row['customer_lastname'],
                'customer_address' => $row['customer_address'],
                'customer_tel' => $row['customer_tel'],
                'province' => $row['province'],
                'zipcode' => $row['zipcode'],
            );


            $data = array(
                'content' => $this->load->view('member/edit', $data, true),
            );
            $this->load->view('main_layout', $data);
        } else {
            $data = array(
                'content' => $this->load->view('member/index', '', true),
            );
        }
    }

    public function add() {

//
//         $en = $this->encrypt->encode($msg);
//        $de = $this->encrypt->decode($en);
//        
//       echo $de;
//       die();

        if ($this->input->post('btn_submit') == 'บันทึก' || $this->input->post('btn_submit') == 'บันทึกและแก้ไขต่อ') {
            if ($this->input->post('btn_submit') == 'บันทึก') {
                $redirect = true;
            } else {
                $redirect = false;
            }

            $dataInsert = array(
                'customer_firstname' => $this->input->post('customer_firstname'),
                'customer_lastname' => $this->input->post('customer_lastname'),
                'customer_address' => $this->input->post('customer_address'),
                'customer_tel' => $this->input->post('customer_tel'),
                'province' => $this->input->post('province'),
                'zipcode' => $this->input->post('zipcode'),
                'created_at' => DATE_TIME,
                'updated_at' => DATE_TIME,
            );

            if ($this->db->insert('member', $dataInsert)) {
                $this->session->set_flashdata('message_success', 'เพิ่มข้อมูลแล้ว');
                if ($redirect) {
                    redirect('member');
                } else {
                    $insert_id = $this->db->insert_id();
                    redirect('member/edit/' . $insert_id);
                }
            }
        }
        $data = array(
            'content' => $this->load->view('member/add', '', true),
        );
        $this->load->view('main_layout', $data);
    }

    public function update() {

        if ($this->input->post('btn_submit') == 'บันทึก' || $this->input->post('btn_submit') == 'บันทึกและแก้ไขต่อ') {

            if ($this->input->post('btn_submit') == 'บันทึก') {
                $redirect = true;
            } else {
                $redirect = false;
            }

            $dataInsert = array(
                'customer_firstname' => $this->input->post('customer_firstname'),
                'customer_lastname' => $this->input->post('customer_lastname'),
                'customer_address' => $this->input->post('customer_address'),
                'customer_tel' => $this->input->post('customer_tel'),
                'province' => $this->input->post('province'),
                'zipcode' => $this->input->post('zipcode'),
                // 'created_at' => DATE_TIME,
                'updated_at' => DATE_TIME,
            );

            $this->db->where('id', $this->input->post('id'));
            if ($this->db->update('member', $dataInsert)) {

                $this->session->set_flashdata('message_success', 'แก้ไขข้อมูลแล้ว');
                if ($redirect) {
                    redirect('member');
                } else {

                    redirect('member/edit/' . $this->input->post('id'));
                }
            }
        }
        $data = array(
            'content' => $this->load->view('member/add', '', true),
        );
        $this->load->view('main_layout', $data);
    }

    public function delete($id = '') {

        if ($this->input->post('btn_submit') == 'ลบที่เลือก') {
            //  $arr = implode('-', $this->input->post('chkbox'));

            foreach ($this->input->post('chkbox') as $ids) {
                $this->db->where('id', $ids);
                $this->db->delete('member');
            }
            redirect('member');
        } else {
            if ($this->db->delete('member', array('id' => $id))) {
                redirect('member');
            }
        }
    }

}
