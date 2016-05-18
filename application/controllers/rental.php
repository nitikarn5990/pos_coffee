<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class rental extends CI_Controller {

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
        //  $this->db->where("deleted_at = '0000-00-00 00:00:00'");
        //  $this->db->limit(1);
      //  $this->db->where("status = 'ปิดสัญญา'");
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
                    'room_id' => explode('|', $this->input->post('room_id'))[0],
                    'member_id' => explode('|', $this->input->post('member_id'))[0],
                    'status' => 'เปิดสัญญา',
                    'comment' => $this->input->post('comment'),
                    'updated_at' => DATE_TIME,
                );
            } else {
                $dataInsert = array(
                    'room_id' => explode('|', $this->input->post('room_id'))[0],
                    'member_id' => explode('|', $this->input->post('member_id'))[0],
                    'status' => 'ปิดสัญญา',
                    'comment' => $this->input->post('comment'),
                    'close_rental_date' => DATE_TIME,
                    'updated_at' => DATE_TIME,
                );
            }

            //เปลี่ยนสถานะห้องเดิม
            $room_id_old = $this->db->get_where('rental', array('id' => $id))->row_array()['room_id'];
            $this->db->update('room', ['status' => 'ว่าง'], "id = " . $room_id_old);

            $this->db->where('id', $id);
            if ($this->db->update('rental', $dataInsert)) {

                //เปลี่ยนสถานะห้องใหม่
                $this->db->where('id', $dataInsert['room_id']);
                $this->db->update('room', ['status' => $dataInsert['status'] == 'ปิดสัญญา' ? 'ว่าง' : 'มีการเช่า']);

                //

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
                    'member_id' => $row['member_id'] . '|' . $this->_getDataDesc("customer_firstname", "member", "id = " . $row['member_id']) . ' ' . $this->_getDataDesc("customer_lastname", "member", "id = " . $row['member_id']),
                    'comment' => $row['comment'],
                    'status' => $row['status'],
                    'open_rental_date' => $row['open_rental_date'],
                    'close_rental_date' => $row['close_rental_date'],
                );


                $data = array(
                    'content' => $this->load->view('rental/edit', $data, true),
                );

                $this->load->view('main_layout', $data);
            } else {
                $data = array(
                    'content' => $this->load->view('rental/index', '', true),
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
            
           

            $this->form_validation->set_rules('pay_monthly', 'ชำระประจำเดือน', 'required');


            if ($this->form_validation->run() == FALSE) {

                $dataForAdd = [
                    "deposit" => $this->db->get_where('deposit', array('id' => 1))->row_array()['price'],
                ];
                $data = array(
                    'content' => $this->load->view('rental/add', $dataForAdd, true),
                );
                $this->load->view('main_layout', $data);
            } else {
                if ($this->input->post('btn_submit') == 'บันทึก') {

                    $redirect = true;
                } else {

                    $redirect = false;
                }

                $dataInsert = array(
                    'room_id' => explode('|', $this->input->post('room_id'))[0],
                    'member_id' => explode('|', $this->input->post('member_id'))[0],
                   // 'rental_id' => $this->input->post('deposit'),     
                    'status' => 'เปิดสัญญา',
                    'comment' => $this->input->post('comment'),
                    'created_at' => DATE_TIME,
                    'updated_at' => DATE_TIME,
                    'open_rental_date' => DATE_TIME,
                );

                if ($this->db->insert('rental', $dataInsert)) {


                    $this->session->set_flashdata('message_success', 'เพิ่มข้อมูลแล้ว');

                    $insert_id = $this->db->insert_id();

                    $room_id = $dataInsert['room_id'];
                    $member_id = $dataInsert['member_id'];

                    $internet = $this->input->post('internet') == 'on' ? $this->db->get_where('internet', array('id' => 1))->row_array()['price'] : 0;

                    $datas = [
                        'rental_id' => $insert_id,
                        'room_id' => $room_id,
                        'member_id' => $member_id,
                        'meter_electric' => $this->input->post('meter_electric'),
                        'meter_water' => $this->input->post('meter_water'),
                        'deposit' => $this->db->get_where('deposit', array('id' => 1))->row_array()['price'],
                        'price_per_month' => $this->db->get_where('room', array('id' => $room_id))->row_array()['price_per_month'],
                        'created_at' => DATE_TIME,
                        'updated_at' => DATE_TIME,
                        'internet' => $internet,
                        'comment' => $this->input->post('comment'),
                        'pay_monthly' => $this->input->post('pay_monthly'),
                    ];
                   

                    if ($this->db->insert('active_rent', $datas)) {
                        $active_rent_id = $this->db->insert_id();
                        //บันทึกการชำระเงิน
                        $dataPaid = array(
                            'active_rent_id' => $active_rent_id,
                            'rental_id' => $insert_id,
                            'total_paid' => $this->input->post('total_paid'),
                            'created_at' => DATE_TIME,
                            'updated_at' => DATE_TIME,
                        );
                        $this->db->insert('active_payment', $dataPaid);

                        // Update สถานะห้อง 
      
                        
                        $this->db->where('id', $room_id);
                        if ($this->db->update('room', ['status' => 'มีการเช่า'])) {
                            if ($redirect) {
                                redirect('rental');
                            } else {

                                redirect('rental/edit/' . $insert_id);
                            }
                        }
                    }
                }
            }
        } else {

            $dataForAdd = [
                "deposit" => $this->db->get_where('deposit', array('id' => 1))->row_array()['price'],
                "internet" => $this->db->get_where('internet', array('id' => 1))->row_array()['price']
               
            ];
            $data = array(
                'content' => $this->load->view('rental/add', $dataForAdd, true),
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

        if ($this->input->post('btn_submit') == 'ลบที่เลือก') {

            foreach ($this->input->post('chkbox') as $ids) {
                if ($ids != '') {
//                    if ($this->db->update('rental', [ 'deleted_at' => DATE_TIME, 'status' => 'ลบ'], "id = " . $ids)) {
//                        
                    $room_id = $this->db->get_where('rental', array('id' => $ids))->row_array()['room_id'];
                    $this->db->update('room', [ 'status' => 'ว่าง'], "id = " . $room_id);
//                                
//                        $this->session->set_flashdata('message_success', 'ลบข้อมูลแล้ว');
//                    }
                    $this->db->delete('rental', "id = " . $ids);
                    $this->session->set_flashdata('message_success', 'ลบข้อมูลแล้ว');
                }
            }

            redirect('rental');
        } else {
            if ($id != '') {
                //  if ($this->db->update('rental', [ 'deleted_at' => DATE_TIME, 'status' => 'ลบ'], "id = " . $id)) {
                $this->db->delete('rental', "id = " . $id);
                
                $room_id = $this->db->get_where('rental', array('id' => $id))->row_array()['room_id'];
                $this->db->update('room', [ 'status' => 'ว่าง'], "id = " . $room_id);


                $this->session->set_flashdata('message_success', 'ลบข้อมูลแล้ว');
                redirect('rental');
                // }
            }
        }
    }

}
