<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class profile extends CI_Controller {

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
            // redirect('404');
        }
    }

    public function index() {

        //$condition = "username =" . "'" . $data['username'] . "' AND " . "password =" . "'" . $data['password'] . "'";
        redirect('profile/edit');
    }

    public function edit() {

        $users_id = $this->session->userdata('users_id');
        if ($this->input->post('btn_submit') == 'บันทึก' || $this->input->post('btn_submit') == 'บันทึกและแก้ไขต่อ') {

            if ($this->input->post('btn_submit') == 'บันทึก') {

                $redirect = true;
            } else {
                $redirect = false;
            }

            $dataUpdate = array(
                'name' => trim($this->input->post('name')),
                'tel' => trim($this->input->post('tel')),
                'address' => trim($this->input->post('address')),
                'password' => encode_login(trim($this->input->post('password'))),
                //  'status' => $this->input->post('status'),
                'updated_at' => DATE_TIME,
            );
            
            //start upload
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

            
            

            if ($this->db->update('users', $dataUpdate, 'id = ' . $users_id)) {

                $this->session->set_flashdata('message_success', 'แก้ไขข้อมูลแล้ว');



                redirect('profile');
            }
        } else {

            $this->db->select('*');
            $this->db->from('users');
            $this->db->where('id = ' . $users_id);
            //   $this->db->limit(1);
            //   $this->db->order_by("id", "asc");
            $query = $this->db->get();

            if ($query->num_rows() == 1) {

                $res_users = $query->row_array();

                $dataEdit = array(
                    'res_users' => $res_users
                );

                $data = array(
                    'content' => $this->load->view('profile/edit', $dataEdit, true),
                );

                $this->load->view('main_layout', $data);
            } else {

                $data = array(
                    'content' => $this->load->view('profile/edit', '', true),
                );

                $this->load->view('main_layout', $data);
            }
        }
    }

}
