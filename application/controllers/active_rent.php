<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class active_rent extends CI_Controller {

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
        $this->db->from('rental');
        //    $this->db->where($condition);
        //  $this->db->limit(1);
        $this->db->order_by("id", "asc");
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $resultq1 = $query->result_array();
            $data['resultq1'] = $resultq1;


            $data = array(
                'content' => $this->load->view('rental/index', $data, true),
            );
        } else {
            $data = array(
                'content' => $this->load->view('rental/index', '', true),
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

            if (isset($_POST['status'])) {
                $dataInsert = array(
                    'room_id' => $this->input->post('room_id'),
                    'member_id' => $this->input->post('member_id'),
                    'status' => 'เปิดสัญญา',
                    'comment' => $this->input->post('comment'),
                    'updated_at' => DATE_TIME,
                );
            } else {
                $dataInsert = array(
                    'room_id' => $this->input->post('room_id'),
                    'member_id' => $this->input->post('member_id'),
                    'status' => 'ปิดสัญญา',
                    'close_tental_date' => $this->input->post('close_tental_date'),
                    'comment' => $this->input->post('comment'),
                    'updated_at' => DATE_TIME,
                );
            }

            $this->db->where('id', $id);
            if ($this->db->update('rental', $dataInsert)) {

                $this->session->set_flashdata('message_success', 'แก้ไขข้อมูลแล้ว');
                if ($redirect) {
                     redirect('rental/edit/' . $id);
                } else {

                    redirect('rental/edit/' . $id);
                }
            }
        } else {
            $this->db->select('*');
            $this->db->from('rental');
            $this->db->where('id = ' . $id);
            $this->db->limit(1);
            $this->db->order_by("id", "asc");
            $query = $this->db->get();

            if ($query->num_rows() == 1) {

                $row = $query->row_array();


                $data = array(
                    'id' => $row['id'],
                    'room_id' => $row['room_id'] . '|' . $this->_getDataDesc("number_room", "room", "id = " . $row['room_id']),
                    'member_id' => $row['member_id'] . '|' . $this->_getDataDesc("customer_firstname", "member", "id = " . $row['member_id']),
                    'comment' => $row['comment'],
                    'status' => $row['status'],
                     'open_rental_date' => $row['open_rental_date'],
                );


                $data = array(
                    'content' => $this->load->view('rental/edit', $data, true),
                );
                $this->load->view('main_layout', $data);
            } else {
                $data = array(
                    'content' => $this->load->view('rental/index', '', true),
                );
            }
        }
    }

    function _getDataDesc($myID, $table, $myWhere) {

        $sql = "SELECT " . $myID . " FROM " . $table . " WHERE " . $myWhere;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row["$myID"];
        } else {
            return("");
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
                'room_id' => explode('|', $this->input->post('room_id'))[1],
                'member_id' => explode('|', $this->input->post('member_id'))[1],
                //   'deposit' => $this->input->post('deposit'),
                'status' => $this->input->post('status'),
                'comment' => $this->input->post('comment'),
                'created_at' => DATE_TIME,
                'updated_at' => DATE_TIME,
                'open_rental_date' => DATE_TIME,
            );

            if ($this->db->insert('rental', $dataInsert)) {
                $this->session->set_flashdata('message_success', 'เพิ่มข้อมูลแล้ว');
                if ($redirect) {
                    redirect('rental');
                } else {
                    $insert_id = $this->db->insert_id();
                    redirect('rental/edit/' . $insert_id);
                }
            }
        }
        $data = array(
            'content' => $this->load->view('rental/add', '', true),
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
            if ($this->db->update('rental', $dataInsert)) {

                $this->session->set_flashdata('message_success', 'แก้ไขข้อมูลแล้ว');
                if ($redirect) {
                    redirect('rental');
                } else {

                    redirect('rental/edit/' . $this->input->post('id'));
                }
            }
        }
        $data = array(
            'content' => $this->load->view('rental/add', '', true),
        );
        $this->load->view('main_layout', $data);
    }

    public function delete($id = '') {

        if ($this->input->post('btn_submit') == 'ลบที่เลือก') {
            //  $arr = implode('-', $this->input->post('chkbox'));

            foreach ($this->input->post('chkbox') as $ids) {
                $this->db->where('id', $ids);
                $this->db->delete('rental');
            }
            redirect('rental');
        } else {
            if ($this->db->delete('rental', array('id' => $id))) {
                redirect('rental');
            }
        }
    }

}
