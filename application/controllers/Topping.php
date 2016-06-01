<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Topping extends CI_Controller {

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


        $this->db->select('*');
        $this->db->from('topping');
        //    $this->db->where($condition);
        //  $this->db->limit(1);
        $this->db->order_by("id", "asc");
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $resultq1 = $query->result_array();
            $data['resultq1'] = $resultq1;


            $data = array(
                'content' => $this->load->view('topping/index', $data, true),
            );
        } else {
            $data = array(
                'content' => $this->load->view('topping/index', '', true),
            );
        }

        $this->load->view('main_layout', $data);
    }

    public function check_duplicate($name) {

        $this->db->select('*');
        $this->db->from('topping');
        $this->db->where("topping_name = '" . $name . "'");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {

            return false;
        } else {

            return true;
        }
    }

    public function edit($id) {

        if ($this->input->post('btn_submit') == 'บันทึก' || $this->input->post('btn_submit') == 'บันทึกและแก้ไขต่อ') {

            if ($this->input->post('btn_submit') == 'บันทึก') {
                $redirect = true;
            } else {
                $redirect = false;
            }

            $dataInsert = array(
                'topping_name' => $this->input->post('topping_name'),
                'price' => $this->input->post('price'),
                'updated_at' => DATE_TIME,
            );

            $this->db->where('id', $id);
            if ($this->db->update('topping', $dataInsert)) {

                $this->session->set_flashdata('message_success', 'แก้ไขข้อมูลแล้ว');
                if ($redirect) {
                    redirect('topping');
                } else {

                    redirect('topping/edit/' . $id);
                }
            }
        } else {
            $this->db->select('*');
            $this->db->from('topping');
            $this->db->where('id = ' . $id);
            $this->db->limit(1);
            $this->db->order_by("id", "asc");
            $query = $this->db->get();

            if ($query->num_rows() == 1) {

                $row = $query->row_array();

                $dataEdit = array(
                    'id' => $row['id'],
                    'res_topping' => $row,
                );


                $data = array(
                    'content' => $this->load->view('topping/edit', $dataEdit, true),
                );
                $this->load->view('main_layout', $data);
            } else {
                $data = array(
                    'content' => $this->load->view('topping/index', '', true),
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

            if ($this->check_duplicate($this->input->post('topping_name'))) {
                $dataInsert = array(
                    'topping_name' => $this->input->post('topping_name'),
                    'price' => $this->input->post('price'),
                    'created_at' => DATE_TIME,
                    'updated_at' => DATE_TIME,
                );

                if ($this->db->insert('topping', $dataInsert)) {
                    $this->session->set_flashdata('message_success', 'เพิ่มข้อมูลแล้ว');
                    if ($redirect) {
                        redirect('topping');
                    } else {
                        $insert_id = $this->db->insert_id();
                        redirect('topping/edit/' . $insert_id);
                    }
                }
            } else {
                $this->session->set_flashdata('message_error', 'ไม่ข้อมูลนี้อยู่แล้ว');
                redirect('topping/add');
            }
        } else {

            //Option ภายในห้อง
            $this->db->select('*');
            $this->db->from('topping');
            $this->db->order_by("id", "asc");
            $query = $this->db->get();
            if ($query->num_rows() > 0) {

                $resultq1 = $query->result_array();
                $data_q['resultq1'] = $resultq1;


                $data = array(
                    'content' => $this->load->view('topping/add', $data_q, true),
                );
                $this->load->view('main_layout', $data);
            } else {
                $data = array(
                    'content' => $this->load->view('topping/add', '', true),
                );
                $this->load->view('main_layout', $data);
            }
        }
    }

    public function delete($id = '') {

        if ($this->input->post('btn_submit') == 'ลบที่เลือก') {
            //  $arr = implode('-', $this->input->post('chkbox'));

            foreach ($this->input->post('chkbox') as $ids) {
                $this->db->where('id', $ids);
                $this->db->delete('topping');
            }
            $this->session->set_flashdata('message_success', 'ลบข้อมูลแล้ว');
            redirect('topping');
        } else {

            if ($this->db->delete('topping', array('id' => $id))) {
                $this->session->set_flashdata('message_success', 'ลบข้อมูลแล้ว');
                redirect('topping');
            }
        }
    }

}
