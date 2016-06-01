<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

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
        if ($this->session->userdata('position') != 'ผู้ดูแลระบบ') {
            redirect('404');
        }
    }

    public function index() {


        //$condition = "username =" . "'" . $data['username'] . "' AND " . "password =" . "'" . $data['password'] . "'";

        $this->db->select('*');
        $this->db->from('menu');
        //    $this->db->where($condition);
        //  $this->db->limit(1);
        $this->db->order_by("id", "asc");
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $resultq1 = $query->result_array();
            $data['resultq1'] = $resultq1;


            $data = array(
                'content' => $this->load->view('menu/index', $data, true),
            );
        } else {
            $data = array(
                'content' => $this->load->view('menu/index', '', true),
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
                    'product' => $this->input->post('product'),
                    'category_id' => $this->input->post('category_id'),
                    'hot' => $this->input->post('hot'),
                    'iced' => $this->input->post('iced'),
                    'smoothie' => $this->input->post('smoothie'),
                    //  'status' => $this->input->post('status'),
                    'created_at' => DATE_TIME,
                    'updated_at' => DATE_TIME,
                );

                $this->db->where('id', $id);
                if ($this->db->update('menu', $dataInsert)) {

                    $this->session->set_flashdata('message_success', 'แก้ไขข้อมูลแล้ว');
                    if ($redirect) {
                        redirect('menu');
                    } else {

                        redirect('menu/edit/' . $id);
                    }
                }
            
        } else {
            $this->db->select('*');
            $this->db->from('menu');
            $this->db->where('id = ' . $id);
            $this->db->limit(1);
            $this->db->order_by("id", "asc");
            $query = $this->db->get();

            if ($query->num_rows() == 1) {

                $row = $query->row_array();

                $dataEdit = array(
                    'id' => $row['id'],
                    'res_menu' => $row,
                    'res_category' => $this->get_category()
                );


                $data = array(
                    'content' => $this->load->view('menu/edit', $dataEdit, true),
                );
                $this->load->view('main_layout', $data);
            } else {
                $data = array(
                    'content' => $this->load->view('menu/index', '', true),
                );
            }
        }
    }

    public function check_duplicate($coffee_name) {

        $this->db->select('*');
        $this->db->from('menu');
        $this->db->where("product = '" . $coffee_name . "'");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {

            return false;
        } else {

            return true;
        }
    }

    public function add() {


        if ($this->input->post('btn_submit') == 'บันทึก' || $this->input->post('btn_submit') == 'บันทึกและแก้ไขต่อ') {
            if ($this->input->post('btn_submit') == 'บันทึก') {
                $redirect = true;
            } else {
                $redirect = false;
            }

            if ($this->check_duplicate($this->input->post('product'))) {

                $dataInsert = array(
                    'product' => $this->input->post('product'),
                    'category_id' => $this->input->post('category_id'),
                    'hot' => $this->input->post('hot'),
                    'iced' => $this->input->post('iced'),
                    'smoothie' => $this->input->post('smoothie'),
                    // 'status' => $this->input->post('status'),
                    'created_at' => DATE_TIME,
                    'updated_at' => DATE_TIME,
                );

                if ($this->db->insert('menu', $dataInsert)) {
                    $this->session->set_flashdata('message_success', 'เพิ่มข้อมูลแล้ว');
                    if ($redirect) {
                        redirect('menu');
                    } else {
                        $insert_id = $this->db->insert_id();
                        redirect('menu/edit/' . $insert_id);
                    }
                }
            } else {
                $this->session->set_flashdata('message_error', 'สินค้านี้มีในระบบแล้ว');

                redirect('menu/add');
            }
        } else {


            $this->db->select('*');
            $this->db->from('menu');
            $this->db->order_by("id", "asc");
            $query = $this->db->get();
            if ($query->num_rows() > 0) {

                $resultq1 = $query->result_array();
                $data_q['resultq1'] = $resultq1;
                $data_q['res_category'] = $this->get_category();


                $data = array(
                    'content' => $this->load->view('menu/add', $data_q, true),
                );
                $this->load->view('main_layout', $data);
            } else {
                $data = array(
                    'content' => $this->load->view('menu/add', '', true),
                );
                $this->load->view('main_layout', $data);
            }
        }
    }

    public function get_category() {

        $this->db->select('*');
        $this->db->from('category');
        $this->db->where("status = 'ใช้งาน'");
        $this->db->order_by("id", "asc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {

            $resultq1 = $query->result_array();
            return $resultq1;
        } else {
            $resultq1 = $query->result_array();
            return $resultq1;
        }
    }

    public function delete($id = '') {

        if ($this->input->post('btn_submit') == 'ลบที่เลือก') {
            //  $arr = implode('-', $this->input->post('chkbox'));

            foreach ($this->input->post('chkbox') as $ids) {
                $this->db->where('id', $ids);
                $this->db->delete('menu');
            }
            $this->session->set_flashdata('message_success', 'ลบข้อมูลแล้ว');
            redirect('menu');
        } else {

            if ($this->db->delete('menu', array('id' => $id))) {
                $this->session->set_flashdata('message_success', 'ลบข้อมูลแล้ว');
                redirect('menu');
            }
        }
    }

}
