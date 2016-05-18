<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Room extends CI_Controller {

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
        $this->db->from('room');
        //    $this->db->where($condition);
        //  $this->db->limit(1);
        $this->db->order_by("id", "asc");
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $resultq1 = $query->result_array();
            $data['resultq1'] = $resultq1;


            $data = array(
                'content' => $this->load->view('room/index', $data, true),
            );
        } else {
            $data = array(
                'content' => $this->load->view('room/index', '', true),
            );
        }

        $this->load->view('main_layout', $data);
    }

    public function edit($id) {

        if ($this->input->post('btn_submit') == 'บันทึก' || $this->input->post('btn_submit') == 'บันทึกและแก้ไขต่อ') {

            if ($this->input->post('btn_submit') == 'บันทึก') {
                $redirect = true;
            } else {
                $redirect = false;
            }

            $dataInsert = array(
                'number_room' => $this->input->post('number_room'),
                'detail' => $this->input->post('detail'),
              //  'status' => $this->input->post('status'),
                'meter_electric' => $this->input->post('meter_electric'),
                'meter_water' => $this->input->post('meter_water'),
                'price_per_month' => $this->input->post('price_per_month'),
                'updated_at' => DATE_TIME,
            );

            $this->db->where('id', $id);
            if ($this->db->update('room', $dataInsert)) {

                $this->session->set_flashdata('message_success', 'แก้ไขข้อมูลแล้ว');
                if ($redirect) {
                    redirect('room');
                } else {

                    redirect('room/edit/' . $id);
                }
            }
        } else {
            $this->db->select('*');
            $this->db->from('room');
            $this->db->where('id = ' . $id);
            $this->db->limit(1);
            $this->db->order_by("id", "asc");
            $query = $this->db->get();

            if ($query->num_rows() == 1) {

                $row = $query->row_array();

                $data = array(
                    'id' => $row['id'],
                    'number_room' => $row['number_room'],
                    'detail' => $row['detail'],
                    'number_room' => $row['number_room'],
                    'meter_electric' => $row['meter_electric'],
                    'meter_water' => $row['meter_water'],
                    'price_per_month' => $row['price_per_month'],
                  //  'status' => $row['status'],
                );


                $data = array(
                    'content' => $this->load->view('room/edit', $data, true),
                );
                $this->load->view('main_layout', $data);
            } else {
                $data = array(
                    'content' => $this->load->view('room/index', '', true),
                );
            }
        }
    }

    public function add() {


        if ($this->input->post('btn_submit') == 'บันทึก' || $this->input->post('btn_submit') == 'บันทึกและแก้ไขต่อ') {
            if ($this->input->post('btn_submit') == 'บันทึก') {
                $redirect = true;
            } else {
                $redirect = false;
            }
   

            $dataInsert = array(
                'number_room' => $this->input->post('number_room'),
                'detail' => $this->input->post('detail'),
              //  'status' => $this->input->post('status'),
                'meter_electric' => $this->input->post('meter_electric'),
                'meter_water' => $this->input->post('meter_water'),
                'price_per_month' => $this->input->post('price_per_month'),
                'created_at' => DATE_TIME,
                'updated_at' => DATE_TIME,
            );

            if ($this->db->insert('room', $dataInsert)) {
                $this->session->set_flashdata('message_success', 'เพิ่มข้อมูลแล้ว');
                if ($redirect) {
                    redirect('room');
                } else {
                    $insert_id = $this->db->insert_id();
                    redirect('room/edit/' . $insert_id);
                }
            }
        }

        //Option ภายในห้อง
        $this->db->select('*');
        $this->db->from('room_option');
        $this->db->order_by("id", "asc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {

            $resultq1 = $query->result_array();
            $data_q['resultq1'] = $resultq1;


            $data = array(
                'content' => $this->load->view('room/add', $data_q, true),
            );
            $this->load->view('main_layout', $data);
        } else {
            $data = array(
                'content' => $this->load->view('room/add', '', true),
            );
            $this->load->view('main_layout', $data);
        }
    }

    public function room_list() {

        //$condition = "username =" . "'" . $data['username'] . "' AND " . "password =" . "'" . $data['password'] . "'";

        $this->db->select('*');
        $this->db->from('room');
        //    $this->db->where($condition);
        //  $this->db->limit(1);
        $this->db->order_by("id", "asc");
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
//
            // $row = $query->row_array();
            $resultq1 = $query->result_array();
            $data['resultq1'] = $resultq1;
            $data['deposit'] = $this->db->get_where('deposit', array('id' => 1))->row_array()['price'];
         
            //  $data = array(
            $this->load->view('room_list', $data);
            // );
        } else {
            $data = array(
                'content' => $this->load->view('room_list', '', true),
            );
        }

        // $this->load->view('main_layout', $data);
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
            if ($this->db->update('room', $dataInsert)) {

                $this->session->set_flashdata('message_success', 'แก้ไขข้อมูลแล้ว');
                if ($redirect) {
                    redirect('room');
                } else {

                    redirect('room/edit/' . $this->input->post('id'));
                }
            }
        }
        $data = array(
            'content' => $this->load->view('room/add', '', true),
        );
        $this->load->view('main_layout', $data);
    }

    public function delete($id = '') {

        if ($this->input->post('btn_submit') == 'ลบที่เลือก') {
            //  $arr = implode('-', $this->input->post('chkbox'));

            foreach ($this->input->post('chkbox') as $ids) {
                $this->db->where('id', $ids);
                $this->db->delete('room');
            }
            redirect('room');
        } else {
            if ($this->db->delete('room', array('id' => $id))) {
                redirect('room');
            }
        }
    }

}
