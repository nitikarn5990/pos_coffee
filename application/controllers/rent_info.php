<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class rent_info extends CI_Controller {

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
        $this->db->where("status = 'เปิดสัญญา'");
        //  $this->db->limit(1);
        $this->db->order_by("id", "asc");
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $resultq1 = $query->result_array();
            $data['resultq1'] = $resultq1;


            $data = array(
                'content' => $this->load->view('rent_info/index', $data, true),
            );
        } else {
            $data = array(
                'content' => $this->load->view('rent_info/index', '', true),
            );
        }

        $this->load->view('main_layout', $data);
    }

    public function edit($id, $active_rent_id = '') {


        if ($active_rent_id == '') {
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
                        redirect('rent_info/edit/' . $id);
                    } else {

                        redirect('rent_info/edit/' . $id);
                    }
                }
            } else {
                //แสดงรายการ
                $this->db->select('*');
                $this->db->from('rental');
                $this->db->where('id = ' . $id);
                $this->db->where("deleted_at = '0000-00-00 00:00:00'");
                $this->db->limit(1);
                $this->db->order_by("id", "asc");
                $query = $this->db->get();

                if ($query->num_rows() == 1) {

                    $row = $query->row_array();

                    $result = $this->db->order_by('pay_monthly', 'DESC')->get_where('active_rent', array('rental_id' => $row['id']))
                            ->result_array();

                    $active_rent_min_id = $this->db->select_min('id')->order_by('pay_monthly', 'DESC')->get_where('active_rent', array('rental_id' => $row['id']))
                                    ->row_array()['id'];


                    $result_active_payment = $this->db->order_by('id', 'DESC')->get_where('active_payment', array('active_rent_id' => $row['id']))
                            ->result_array();

                    $result_active_rent = $this->db->get_where('active_rent', array('rental_id' => $row['id']))
                            ->row_array();

                    $result_active_rent_last_count = $this->db->get_where('active_rent', array('rental_id' => $id, 'pay_monthly' => Add_month('-1', $result_active_rent['pay_monthly'])))
                            ->num_rows();
                    //   if($result_active_rent_last_count == 0){
                    //  $result_active_rent_last = $this->db->get_where('active_rent', array('rental_id' => $id, 'pay_monthly' =>$result_active_rent['pay_monthly'] ))
                    //  ->row_array();
                    // }else{
                    // $result_active_rent_last = $this->db->get_where('active_rent', array('rental_id' => $id, 'pay_monthly' => Add_month('-1', $result_active_rent['pay_monthly']) ))
                    //    ->row_array();
                    //}
                    // print_r($result);
                    //  die();


                    $data = array(
                        'id' => $row['id'],
                        'active_rent_id' => $active_rent_id,
                        'room_id' => $row['room_id'] . '|' . $this->_getDataDesc("number_room", "room", "id = " . $row['room_id']),
                        'member_id' => $row['member_id'] . '|' . $this->_getDataDesc("customer_firstname", "member", "id = " . $row['member_id']),
                        'comment' => $row['comment'],
                        'status' => $row['status'],
                        'open_rental_date' => $row['open_rental_date'],
                        'close_rental_date' => $row['close_rental_date'],
                        'member_name' => $this->db->get_where('member', array('id' => $row['member_id']))->row_array()['customer_firstname'] . ' ' . $this->db->get_where('member', array('id' => $row['member_id']))->row_array()['customer_lastname'],
                        'tel' => $this->db->get_where('member', array('id' => $row['member_id']))->row_array()['customer_tel'],
                        'result' => $result,
                        'result_active_rent' => $result_active_rent,
                        //  'result_active_rent_last' => $result_active_rent_last,
                        //  'result_active_rent_last_count' => $result_active_rent_last_count,
                        'active_rent_min_id' => $active_rent_min_id,
                    );

                    //  print_r($result_active_rent);
                    //   die();

                    $data = array(
                        'content' => $this->load->view('rent_info/edit', $data, true),
                    );

                    $this->load->view('main_layout', $data);
                } else {
                    $data = array(
                        'content' => $this->load->view('rent_info/index', '', true),
                    );
                    $this->load->view('main_layout', $data);
                }
            }
        } else {




            $result_active_rent = $this->db->get_where('active_rent', array('id' => $active_rent_id))
                    ->row_array();



            //หาเลขมิเตอร์เดือนก่อนหน้า 
            $result_active_rent_last_count = $this->db->get_where('active_rent', array('rental_id' => $result_active_rent['rental_id'], 'pay_monthly' => Add_month('-1', $result_active_rent['pay_monthly'])))
                    ->num_rows();
            if ($result_active_rent_last_count > 0) {
                $result_active_rent_last = $this->db->get_where('active_rent', array('rental_id' => $result_active_rent['rental_id'], 'pay_monthly' => Add_month('-1', $result_active_rent['pay_monthly'])))
                        ->row_array();
            } else {
                $result_active_rent_last = $this->db->get_where('active_rent', array('rental_id' => $result_active_rent['rental_id'], 'pay_monthly' => $result_active_rent['pay_monthly']))
                        ->row_array();
            }



            $result_active_payment = $this->db->get_where('active_payment', array('active_rent_id' => $active_rent_id))
                    ->result_array();


            $result_room = $this->db->get_where('room', array('id' => $result_active_rent['room_id']))
                    ->row_array();

            $result_active_rent2 = $this->db->order_by('pay_monthly', 'DESC')->get_where('active_rent', array('rental_id' => $result_active_rent['rental_id']))
                    ->row_array();

            $rental_id = $result_active_rent['rental_id'];
            $result_active_rent2 = $result_active_rent2['pay_monthly'];
            $month_next_pay = Date("Y-m", strtotime("$result_active_rent2 +1 Month"));


            $result_rental = $this->db->get_where('rental', array('id' => $rental_id))
                    ->row_array();
            $result_member = $this->db->get_where('member', array('id' => $result_rental['member_id']))
                    ->row_array();


            $result_active_rent_next_month = $this->db->get_where('active_rent', array('id' => $result_active_rent['id_next_month']))
                    ->row_array();

            $active_rent_min_id = $this->db->select_min('id')->order_by('pay_monthly', 'DESC')->get_where('active_rent', array('rental_id' => $result_active_rent['rental_id']))
                            ->row_array()['id'];



            $dataForAdd = [
                // 'deposit' => $this->db->get_where('deposit', array('id' => 1))->row_array()['price'],
                'id' => $id,
                'result_member' => $result_member,
                'result_rental' => $result_rental,
                'result_active_rent' => $result_active_rent,
                'result_room' => $result_room,
                'month_next_pay' => $month_next_pay,
                'result_active_payment' => $result_active_payment,
                'result_active_rent_next_month' => $result_active_rent_next_month,
                'active_rent_min_id' => $active_rent_min_id,
                'result_active_rent_last' => $result_active_rent_last,
                'result_active_rent_last_count' => $result_active_rent_last_count,
                'active_rent_id' => $active_rent_id
            ];
            $data = array(
                'content' => $this->load->view('rent_info/paid', $dataForAdd, true),
            );

            //  echo $data['content'];
            // die();
            $this->load->view('main_layout', $data);

            //    $this->load->view('main_layout', $data);
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
                'room_id' => explode('|', $this->input->post('room_id'))[0],
                'member_id' => explode('|', $this->input->post('member_id'))[0],
                //'deposit' => $this->input->post('deposit'),     
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
                    'member_id' => $member_id,
                    'meter_electric' => $this->db->get_where('room', array('id' => $room_id))->row_array()['meter_electric'],
                    'meter_water' => $this->db->get_where('room', array('id' => $room_id))->row_array()['meter_water'],
                    'deposit' => $this->db->get_where('deposit', array('id' => 1))->row_array()['price'],
                    'price_per_month' => $this->db->get_where('room', array('id' => $room_id))->row_array()['price_per_month'],
                    'created_at' => DATE_TIME,
                    'updated_at' => DATE_TIME,
                    'internet' => $internet,
                    'comment' => $this->input->post('comment'),
                ];

                if ($this->db->insert('active_rent', $datas)) {

                    $this->db->where('id', $room_id);
                    // Update สถานะห้อง
                    if ($this->db->update('room', ['status' => 'มีการเช่า'])) {
                        if ($redirect) {
                            redirect('rent_info');
                        } else {

                            redirect('rent_info/edit/' . $insert_id);
                        }
                    }
                }
            }
        } else {

            $dataForAdd = [
                "deposit" => $this->db->get_where('deposit', array('id' => 1))->row_array()['price'],
            ];
            $data = array(
                'content' => $this->load->view('rent_info/add', $dataForAdd, true),
            );
        }


        $this->load->view('main_layout', $data);
    }

    public function add_new($rental_id = '') {

        if ($this->input->post('btn_submit') == 'บันทึก' || $this->input->post('btn_submit') == 'บันทึกและแก้ไขต่อ') {


            if ($this->input->post('btn_submit') == 'บันทึก') {

                $redirect = true;
            } else {

                $redirect = false;
            }


            //   $this->session->set_flashdata('message_success', 'เพิ่มข้อมูลแล้ว');


            $rental_id = $this->input->post('rental_id');
            $room_id = $this->input->post('room_id');
            $member_id = $this->input->post('member_id');
            $internet = $this->input->post('internet');
            $price_per_month = $this->input->post('price_per_month');
            $pay_monthly = $this->input->post('pay_monthly');

            $datas = [
                'rental_id' => $rental_id,
                'member_id' => $member_id,
                'room_id' => $room_id,
                'pay_monthly' => $pay_monthly,
                //  'meter_electric_last' => $this->db->get_where('room', array('id' => $room_id))->row_array()['meter_electric'],
                //  'meter_water_last' => $this->db->get_where('room', array('id' => $room_id))->row_array()['meter_water'],
                'price_per_month' => $price_per_month,
                'created_at' => DATE_TIME,
                'updated_at' => DATE_TIME,
                'internet' => $internet,
                'comment' => $this->input->post('comment'),
            ];

            if ($this->db->insert('active_rent', $datas)) {

                $active_rent_insert_id = $this->db->insert_id();
                //เพิ่มประวัติการชำระเงิน 
                $this->db->insert('active_payment', array('active_rent_id' => $active_rent_insert_id, 'total_paid' => $this->input->post('receive_money')));

                $active_rent_insert_id = $this->db->insert_id();
                $this->db->where('id', $room_id);
                // Update สถานะห้อง
                if ($this->db->update('room', ['status' => 'มีการเช่า'])) {


                    redirect('rent_info/edit/' . $rental_id);
                }
            }
        } else {
            if ($rental_id != '') {

                $result_rental = $this->db->get_where('rental', array('id' => $rental_id))
                        ->row_array();
                $result_member = $this->db->get_where('member', array('id' => $result_rental['member_id']))
                        ->row_array();
                $result_room = $this->db->get_where('room', array('id' => $result_rental['room_id']))
                        ->row_array();

                //หาเดือนสุดท้ายที่เช่า
                $this->db->select('*');
                $this->db->from('active_rent');
                //  $this->db->where("deleted_at = '0000-00-00 00:00:00'");
                $this->db->where("rental_id = " . $rental_id);
                $this->db->limit(1);
                $this->db->order_by("id", "desc");
                $query = $this->db->get();

                // print_r($query->row_array());
                // die();
                if ($query->num_rows() > 0) {

                    $result_active_rent = $query->row_array();
                    $rent_next_month = Add_month("+1", $result_active_rent['pay_monthly']);
                } else {
                    $rent_next_month = '';
                }


                $dataForAdd = [
                    'id' => $rental_id,
                    "deposit" => $this->db->get_where('deposit', array('id' => 1))->row_array()['price'],
                    'result_rental' => $result_rental,
                    'result_member' => $result_member,
                    'result_room' => $result_room,
                    'rent_next_month' => $rent_next_month
                ];
                $data = array(
                    'content' => $this->load->view('rent_info/add_new', $dataForAdd, true),
                );
            }
        }


        $this->load->view('main_layout', $data);
    }

    public function paid($active_rent_id = '') {

        $result_active_rent = $this->db->get_where('active_rent', array('id' => $active_rent_id))
                ->row_array();

        // $price_per_month_internet =  $result_active_rent['internet'] +  $result_active_rent['price_per_month'];



        $result_active_payment = $this->db->get_where('active_payment', array('active_rent_id' => $active_rent_id))
                ->result_array();



        $result_room = $this->db->get_where('room', array('id' => $result_active_rent['room_id']))
                ->row_array();

        $result_active_rent2 = $this->db->order_by('pay_monthly', 'DESC')->get_where('active_rent', array('rental_id' => $result_active_rent['rental_id']))
                ->row_array();

        $rental_id = $result_active_rent['rental_id'];
        $result_active_rent2 = $result_active_rent2['pay_monthly'];
        $month_next_pay = Date("Y-m", strtotime("$result_active_rent2 +1 Month"));


        $result_active_rent_next_month = $this->db->get_where('active_rent', array('id' => $result_active_rent['id_next_month']))
                ->row_array();

        $active_rent_min_id = $this->db->select_min('id')->order_by('pay_monthly', 'DESC')->get_where('active_rent', array('rental_id' => $result_active_rent['rental_id']))
                        ->row_array()['id'];



        $dataForAdd = [
            // 'deposit' => $this->db->get_where('deposit', array('id' => 1))->row_array()['price'],
            'id' => $row['id'],
            'result_active_rent' => $result_active_rent,
            'result_room' => $result_room,
            'month_next_pay' => $month_next_pay,
            'result_active_payment' => $result_active_payment,
            'result_active_rent_next_month' => $result_active_rent_next_month,
            'active_rent_min_id' => $active_rent_min_id,
        ];
        $data = array(
            'content' => $this->load->view('rent_info/paid', $dataForAdd, true),
        );

        //  echo $data['content'];
        // die();
        $this->load->view('main_layout', $data);

        //    $this->load->view('main_layout', $data);
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
                    redirect('rent_info');
                } else {

                    redirect('rent_info/edit/' . $this->input->post('id'));
                }
            }
        }
        $data = array(
            'content' => $this->load->view('rent_info/add', '', true),
        );
        $this->load->view('main_layout', $data);
    }

    public function update_meter() {

        //อัพเดรตมีเตอร์ล่าสุด ใช้ในการหาการใช้ค่าไฟฟ้าและค่าน้ำ
        //print_r($_POST);
        // die();

        if ($this->input->post('btn_submit') == 'บันทึก' || $this->input->post('btn_submit') == 'บันทึกและแก้ไขต่อ') {
            //  print_r($this->input->post());
            //  die();
//         Array ( [id] => 69 [rental_id] => 50 [meter_electric_price_per_month_current] => 1500
//             [meter_water_price_per_month_current] => 1600 
//    [water_rate] => 10 [electric_rate] => 8 [btn_submit] => บันทึก [total_pays] => 2500 )
            // $roomID = $this->db->get_where('active_rent', array('id' => $this->input->post('id')))->row_array()['room_id'];

            if ($this->input->post('status_internet') == 'ใช้') {
                $internet = $this->db->get_where('internet', array('id' => 1))->row_array()['price'];
            } else {
                $internet = 0;
            }

            $dataUpdate = array(
                'meter_electric_last' => $this->input->post('meter_electric_price_per_month_current'),
                'meter_water_last' => $this->input->post('meter_water_price_per_month_current'),
                'internet' => $internet,
                'meter_updated_at' => DATE_TIME,
            );



            if ($this->db->update('active_rent', $dataUpdate, "id = " . $this->input->post('id'))) {

                //update last meter
                // $this->db->update('room', array('meter_electric' => $this->input->post('meter_electric_price_per_month_current'), 'meter_water' => $this->input->post('meter_water_price_per_month_current')), "id = " . $roomID);

                $this->session->set_flashdata('message_success', 'บันทึกข้อมูลแล้ว');
                redirect('rent_info/edit/' . $this->input->post('rental_id') . '/' . $this->input->post('id'));
                die();
            }


            //จ่ายค่าห้องเดือนถัดไป
//            if ($this->input->post('status_pay') == 'yes') {
//
//                if ($this->input->post('edit_or_add') == 'add') {
//
//                    $internet = $this->input->post('internet') == 'on' ? $this->db->get_where('internet', array('id' => 1))->row_array()['price'] : 0;
//
//                    $active_rent_current_month = $this->db->get_where('active_rent', array('id' => $this->input->post('id')))->row_array()['pay_monthly'];
//                    $month_next_pay = $this->input->post('month_next_pay');
//
//
//                    $datas = [
//                        'rental_id' => $this->db->get_where('active_rent', array('id' => $this->input->post('id')))->row_array()['rental_id'],
//                        'room_id' => $roomID,
//                        'member_id' => $this->db->get_where('active_rent', array('id' => $this->input->post('id')))->row_array()['member_id'],
//                        'meter_electric' => $this->db->get_where('room', array('id' => $roomID))->row_array()['meter_electric'],
//                        'meter_water' => $this->db->get_where('room', array('id' => $roomID))->row_array()['meter_water'],
//                        //  'deposit' => $this->db->get_where('deposit', array('id' => 1))->row_array()['price'],
//                        'price_per_month' => $this->db->get_where('room', array('id' => $roomID))->row_array()['price_per_month'],
//                        'created_at' => DATE_TIME,
//                        'updated_at' => DATE_TIME,
//                        'internet' => $internet,
//                        'pay_monthly' => $month_next_pay
//                    ];
//
//                    if ($this->db->insert('active_rent', $datas)) {
//
//                        $insert_id = $this->db->insert_id();
//                        $this->db->update('active_rent', ['id_next_month' => $insert_id], "id = " . $this->input->post('id'));
//
//                        $this->db->where('id', $roomID);
//                        // Update สถานะห้อง
//                        if ($this->db->update('room', ['status' => 'มีการเช่า'])) {
//
//                            $this->session->set_flashdata('message_success', 'เพิ่มข้อมูลแล้ว');
//                            redirect('rent_info/edit/' . $this->input->post('rental_id') . '/' . $this->input->post('id'));
//                            die();
//                        }
//                    }
//                }
//                if ($this->input->post('edit_or_add') == 'edit') {
//
//                    $internet = $this->input->post('internet') == 'on' ? $this->db->get_where('internet', array('id' => 1))->row_array()['price'] : 0;
//
//                    $id_next_month = $this->db->get_where('active_rent', array('id' => $this->input->post('id')))->row_array()['id_next_month'];
//                    $this->db->update('active_rent', ['internet' => $internet], "id = " . $id_next_month);
//
//
//                    //update meter last
//
//                    $this->db->update(
//                            'active_rent', [
//                        'meter_electric' => $this->input->post('meter_electric_price_per_month_current'),
//                        'meter_water' => $this->input->post('meter_water_price_per_month_current')
//                            ], "id = " . $id_next_month
//                    );
//
//                    //add รายการชำระเงิน
////                    if ($this->input->post('receive_money') >= $this->input->post('total_pays')) {
////
////                        $this->db->insert('active_payment', ["active_rent_id" => $this->input->post('id'), 'total_paid' => $this->input->post('total_pays'),
////                            'created_at' => DATE_TIME,
////                            'updated_at' => DATE_TIME,]);
////                    } else {
////                        $this->db->insert('active_payment', ["active_rent_id" => $this->input->post('id'), 'total_paid' => $this->input->post('receive_money'),
////                            'created_at' => DATE_TIME,
////                            'updated_at' => DATE_TIME,]);
////                    }
//
//
//                    $this->session->set_flashdata('message_success', 'แก้ไขข้อมูลแล้ว');
//                    redirect('rent_info/edit/' . $this->input->post('rental_id') . '/' . $this->input->post('id'));
//                    die();
//                }
//            } else {
//                redirect('rent_info/edit/' . $this->input->post('rental_id') . '/' . $this->input->post('id'));
//                die();
//            }
        }

//        $data = array(
//            'content' => $this->load->view('rent_info/add', '', true),
//        );
//
//        $this->load->view('main_layout', $data);
    }

    static function _update_room_status($room_id) {
        $this->db->update('room', ['status' => 'ว่าง'], "id = " . $room_id);
    }

    public function delete($id = '') {

        if ($this->input->post('btn_submit') == 'ลบที่เลือก') {

            foreach ($this->input->post('chkbox') as $ids) {
                if ($ids != '') {
                    if ($this->db->update('rental', [ 'deleted_at' => DATE_TIME, 'status' => 'ปิดสัญญา'], "id = " . $ids)) {

                        $room_id = $this->db->get_where('rental', array('id' => $ids))->row_array()['room_id'];
                        $this->_update_room_status($room_id);

                        $this->session->set_flashdata('message_success', 'ลบข้อมูลแล้ว');
                    }
                }
            }

            redirect('rent_info');
        } else {
            if ($id != '') {
                if ($this->db->update('rental', [ 'deleted_at' => DATE_TIME, 'status' => 'ปิดสัญญา'], "id = " . $id)) {

                    $room_id = $this->db->get_where('rental', array('id' => $id))->row_array()['room_id'];
                    $this->_update_room_status($room_id);

                    $this->session->set_flashdata('message_success', 'ลบข้อมูลแล้ว');
                    redirect('rent_info');
                }
            }
        }
    }

    public function delete_active_rent($id = '', $rental_id = '') {

        if ($id != '') {
            $this->db->delete('active_rent', array('id' => $id));
            $this->db->delete('active_payment', array('active_rent_id' => $id));
            $this->session->set_flashdata('message_success', 'ลบข้อมูลแล้ว');
            redirect('rent_info/edit/' . $rental_id);
        }
    }

    public function active_payment_delete($id = '') {
        if ($id != '') {

            // $this->db->delete('active_payment', array('id' => $id));
            $active_rent_id = $this->db->get_where('active_payment', array('id' => $id))
                            ->row_array()['active_rent_id'];

            $this->db->delete('active_payment', array('id' => $id));

            $result_active_rent = $this->db->get_where('active_rent', array('id' => $active_rent_id))
                    ->row_array();

            $result_active_payment = $this->db->get_where('active_payment', array('active_rent_id' => $active_rent_id))
                    ->result_array();

            $id_next_month = $this->db->get_where('active_rent', array('id' => $active_rent_id))
                            ->row_array()['id_next_month'];

            $result_internet = $this->db->get_where('active_rent', array('id' => $id_next_month))
                            ->row_array()['internet'];

            $result_price_per_month = $this->db->get_where('active_rent', array('id' => $id_next_month))
                            ->row_array()['price_per_month'];

            $arrData = [
                'result_active_payment' => $result_active_payment,
                'result_active_rent' => $result_active_rent,
                'result_internet' => $result_internet,
                'result_price_per_month' => $result_price_per_month
            ];

            $data = array(
                'content' => $this->load->view('rent_info/payment_history', $arrData, true),
            );

            echo $data['content'];
        }
    }

    public function active_payment_edit($id = '', $val = '') {

        if ($id != '') {

            // $this->db->delete('active_payment', array('id' => $id));
            $active_rent_id = $this->db->get_where('active_payment', array('id' => $id))
                            ->row_array()['active_rent_id'];

            $this->db->update('active_payment', ['total_paid' => $val], "id = " . $id);

            $result_active_rent = $this->db->get_where('active_rent', array('id' => $active_rent_id))
                    ->row_array();



            $result_active_payment = $this->db->get_where('active_payment', array('active_rent_id' => $active_rent_id))
                    ->result_array();


            $id_next_month = $this->db->get_where('active_rent', array('id' => $active_rent_id))
                            ->row_array()['id_next_month'];

            $result_internet = $this->db->get_where('active_rent', array('id' => $id_next_month))
                            ->row_array()['internet'];
            $result_price_per_month = $this->db->get_where('active_rent', array('id' => $id_next_month))
                            ->row_array()['price_per_month'];

            $arrData = [
                'result_active_payment' => $result_active_payment,
                'result_active_rent' => $result_active_rent,
                'result_internet' => $result_internet,
                'result_price_per_month' => $result_price_per_month,
            ];

            $data = array(
                'content' => $this->load->view('rent_info/payment_history', $arrData, true),
            );

            echo $data['content'];
        }
    }

    public function active_payment_add($id = '', $val = '') {

        if ($id != '') {

            // $this->db->delete('active_payment', array('id' => $id));
            //$active_rent_id = $this->db->get_where('active_payment', array('id' => $id))
            //          ->row_array()['active_rent_id'];

              $result_active_rent = $this->db->get_where('active_rent', array('id' => $id))
                    ->row_array();

            $this->db->insert('active_payment', ['active_rent_id' => $id,'rental_id' => $result_active_rent['rental_id'], 'total_paid' => $val ,'created_at' => DATE_TIME, 'updated_at' => DATE_TIME]);

          
            $result_active_payment = $this->db->get_where('active_payment', array('active_rent_id' => $id))
                    ->result_array();


            $id_next_month = $this->db->get_where('active_rent', array('id' => $id))
                            ->row_array()['id_next_month'];

            $result_internet = $this->db->get_where('active_rent', array('id' => $id_next_month))
                            ->row_array()['internet'];

            $result_price_per_month = $this->db->get_where('active_rent', array('id' => $id_next_month))
                            ->row_array()['price_per_month'];


            $arrData = [
                'result_active_payment' => $result_active_payment,
                'result_active_rent' => $result_active_rent,
                'result_internet' => $result_internet,
                'result_price_per_month' => $result_price_per_month
            ];

            $data = array(
                'content' => $this->load->view('rent_info/payment_history', $arrData, true),
            );

            echo $data['content'];
        }
    }

    public function load_payment($id) {

        if ($id != '') {

            // $this->db->delete('active_payment', array('id' => $id));
            //   $active_rent_id = $this->db->get_where('active_payment', array('id' => $id))
            //      ->row_array()['active_rent_id'];
            //   $this->db->update('active_payment', ['total_paid' => $val], "id = ".$id );

            $result_active_rent = $this->db->get_where('active_rent', array('id' => $id))
                    ->row_array();

            //หาการเช่าเดือนแรก
            $result_active_rent_last_count = $this->db->get_where('active_rent', array('rental_id' => $result_active_rent['rental_id'], 'pay_monthly' => Add_month('-1', $result_active_rent['pay_monthly'])))
                    ->num_rows();

            if ($result_active_rent_last_count > 0) {

                $result_active_rent_last = $this->db->get_where('active_rent', array('rental_id' => $result_active_rent['rental_id'], 'pay_monthly' => Add_month('-1', $result_active_rent['pay_monthly'])))
                        ->row_array();
            } else {
                $result_active_rent_last = $this->db->get_where('active_rent', array('rental_id' => $result_active_rent['rental_id'], 'pay_monthly' => $result_active_rent['pay_monthly']))
                        ->row_array();
            }

            //    $result_active_rent_last = $this->db->get_where('active_rent', array('pay_monthly' => Add_month('-1', $result_active_rent['pay_monthly'])))
            //  ->row_array();

            $result_active_payment = $this->db->get_where('active_payment', array('active_rent_id' => $id))
                    ->result_array();


            $id_next_month = $this->db->get_where('active_rent', array('id' => $id))
                            ->row_array()['id_next_month'];

            $result_internet = $this->db->get_where('active_rent', array('id' => $id_next_month))
                            ->row_array()['internet'];

            $result_price_per_month = $this->db->get_where('active_rent', array('id' => $id_next_month))
                            ->row_array()['price_per_month'];




            $arrData = [
                'result_active_payment' => $result_active_payment,
                'result_active_rent' => $result_active_rent,
                'result_internet' => $result_internet,
                'result_price_per_month' => $result_price_per_month,
                'result_active_rent_last' => $result_active_rent_last,
                'result_active_rent_last_count' => $result_active_rent_last_count,
                'result_active_rent_last' => $result_active_rent_last
            ];

            $data = array(
                'content' => $this->load->view('rent_info/payment_history', $arrData, true),
            );

            echo $data['content'];
        }
    }

}
