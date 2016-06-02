<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class administrator extends CI_Controller {

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
        $this->db->from('users');
        //  $this->db->where("deleted_at = '0000-00-00 00:00:00'");
        //  $this->db->limit(1);
        $this->db->where("group = 'admin'");
        $this->db->order_by("id", "asc");
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $resultq1 = $query->result_array();
            $data['resultq1'] = $resultq1;

            $data = array(
                'content' => $this->load->view('administrator/index', $data, true),
            );
        } else {
            $data = array(
                'content' => $this->load->view('administrator/index', '', true),
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

            $dataUpdate = array(
                'name' => trim($this->input->post('name')),
                'password' => encode_login(trim($this->input->post('password'))),
                'position' => $this->input->post('position'),
                 'tel' => $this->input->post('tel'),
                  'address' => $this->input->post('address'),
                'updated_at' => DATE_TIME,
            );

            if ($_FILES['image']['name'] != '') {


                $datetime_file = DATE_TIME_FILE;

                $array = explode('.', $_FILES['image']['name']);
                $extension = $array[1];
                //upload image
                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['file_name'] = $datetime_file . '.' . $extension;

                $field_name = "image";
                $this->load->library('upload', $config);
                if ($this->upload->do_upload($field_name)) {
                    $dataUpdate = array('image' => $config['file_name']);
                }
            }
            // end upload image



            if ($this->db->update('users', $dataUpdate, 'id = ' . $id)) {

                $this->session->set_flashdata('message_success', 'แก้ไขข้อมูลแล้ว');

                if ($redirect) {

                    redirect('administrator');
                    die();
                } else {
                    redirect('administrator/edit/' . $id);
                    die();
                }
            }
        } else {

            $this->db->select('*');
            $this->db->from('users');
            $this->db->where('id = ' . $id);
            //   $this->db->limit(1);
            //   $this->db->order_by("id", "asc");
            $query = $this->db->get();

            if ($query->num_rows() == 1) {

                $res_users = $query->row_array();

                $dataEdit = array(
                    'res_users' => $res_users
                );

                $data = array(
                    'content' => $this->load->view('administrator/edit', $dataEdit, true),
                );

                $this->load->view('main_layout', $data);
            } else {

                $data = array(
                    'content' => $this->load->view('administrator/edit', '', true),
                );

                $this->load->view('main_layout', $data);
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

            $cnt = $this->db->get_where('users', array('username' => trim($this->input->post('username'))))->num_rows();

            if ($cnt > 0) { //username ซ้ำ
                $this->session->set_flashdata('message_error', 'มีผู้ใช้ Username นี้แล้ว');
                redirect('administrator/add');
                die();
            } else {


                $dataInsert = array(
                    'username' => trim($this->input->post('username')),
                    'password' => encode_login(trim($this->input->post('password'))),
                    'name' => $this->input->post('name'),
                    'tel' => $this->input->post('tel'),
                    'address' => $this->input->post('address'),
                    'position' => $this->input->post('position'),
                    // 'status' => $this->input->post('status'),
                    'created_at' => DATE_TIME,
                    'updated_at' => DATE_TIME,
                );



                if ($this->db->insert('users', $dataInsert)) {

                    $insert_id = $this->db->insert_id();
                    //upload image
                    if ($_FILES['image']['name'] != '') {
                        $datetime_file = DATE_TIME_FILE;

                        $array = explode('.', $_FILES['image']['name']);
                        $extension = $array[1];
                        //upload image
                        $config['upload_path'] = './uploads/';
                        $config['allowed_types'] = 'gif|jpg|png|jpeg';
                        $config['file_name'] = $datetime_file . '.' . $extension;

                        $field_name = "image";
                        $this->load->library('upload', $config);
                        if ($this->upload->do_upload($field_name)) {
                            $arrData = array('image' => $config['file_name']);
                              if ($this->db->update('users', $arrData, 'id = ' . $insert_id)) {
                                  
                              }
                        }
                    }

                    // end upload image

                    $this->session->set_flashdata('message_success', 'เพิ่มข้อมูลแล้ว');
                    if ($redirect) {
                        redirect('administrator');
                        die();
                    } else {
                        redirect('administrator/edit/' .$insert_id);
                        die();
                    }
                }
            }
        } else {

            $data = array(
                'content' => $this->load->view('administrator/add', '', true),
            );
            $this->load->view('main_layout', $data);
        }
    }

    public function repassword() {


        if ($this->input->post('btn_submit') == 'บันทึก' || $this->input->post('btn_submit') == 'บันทึกและแก้ไขต่อ') {


            $cnt = $this->db->get_where('users', array('id' => $this->session->userdata('member_id'), 'password' => encode_login(trim($this->input->post('old_password')))))
                    ->num_rows();


            //เช็คถ้าใส่รหัสผ่านเดิมไม่ตรง
            if ($cnt == 0) {
                $this->session->set_flashdata('message_error', 'รหัสผ่านเดิมไม่ถูกต้องต้อง');
                redirect('administrator/repassword');
                die();
            } else {
                if ($this->db->update('users', array('password' => encode_login(trim($this->input->post('new_password_confirm')))), 'id = ' . $this->session->userdata('member_id'))) {
                    $this->session->set_flashdata('message_success', 'แก้ไขรหัสผ่านแล้ว');
                    redirect('administrator/repassword');
                    die();
                }
            }


            $data = array(
                'content' => $this->load->view('administrator/repassword', '', true),
            );
            $this->load->view('main_layout', $data);
        } else {

            $data = array(
                'content' => $this->load->view('administrator/repassword', '', true),
            );

            $this->load->view('main_layout', $data);
        }
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



        if ($id != '') {
            //  if ($this->db->update('rental', [ 'deleted_at' => DATE_TIME, 'status' => 'ลบ'], "id = " . $id)) {
            $this->db->delete('users', "id = " . $id);

            //  $room_id = $this->db->get_where('rental', array('id' => $id))->row_array()['room_id'];
            //  $this->db->update('room', [ 'status' => 'ว่าง'], "id = " . $room_id);

            $this->session->set_flashdata('message_success', 'ลบข้อมูลแล้ว');
            redirect('administrator');
            // }
        }
    }

}
