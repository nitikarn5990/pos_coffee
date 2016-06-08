<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pos extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *        http://example.com/index.php/welcome
     *    - or -
     *        http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct()
    {

        parent::__construct();


        if ($this->session->userdata('is_logged_in') == '') {

            $this->session->set_userdata('url_back', current_url());
            redirect('auth/login');
        }
    }

    public function index()
    {

        redirect('pos/tables');
    }

    public function _getMenuType($_type)
    {
        if ($_type == 'ร้อน') {
            return 'hot';
        }
        if ($_type == 'เย็น') {
            return 'iced';
        }
        if ($_type == 'ปั่น') {
            return 'smoothie';
        }
    }

    public function _getMenuTypeEng($_type)
    {
        if ($_type == 'hot') {
            return 'ร้อน';
        }
        if ($_type == 'iced') {
            return 'เย็น';
        }
        if ($_type == 'smoothie') {
            return 'ปั่น';
        }
    }

    public function _new_order($table_number = '')
    {

        // print_r($this->input->post('topping_id'));
        // die();


        if ($table_number != '') {
//add new
            $this->db->trans_begin();

            $arrOrder = array(
                'tables_number' => $table_number,
                'users_id' => $this->session->userdata('users_id'),
                'created_at' => DATE_TIME,
                'updated_at' => DATE_TIME,
            );
            if ($this->db->insert('active_order', $arrOrder)) {
                $insert_id = $this->db->insert_id();
                foreach ($this->input->post('menu_id') as $key => $value) {

                    $qty = $this->input->post('menu_qty')[$key];
                    $price = $this->input->post('menu_price')[$key];

//  $total = $price * $qty;

                    $arrOrderDetail = array(
                        'active_order_id' => $insert_id,
                        'menu_id' => $value,
                        'menu_name' => $this->_get_menu_name($value),
                        'menu_type' => $this->_getMenuType($this->input->post('menu_type')[$key]),
                        'qty' => $qty,
                        'price' => $price,
                        'created_at' => DATE_TIME,
                        'updated_at' => DATE_TIME,
                    );

                    if ($this->db->insert('active_order_detail', $arrOrderDetail)) {

                        //add to topping table
                        $active_order_detail_id = $this->db->insert_id();
                        if ($this->input->post('topping_id')[$key] != 0) {

                            $arrToppingID = explode(',', $this->input->post('topping_id')[$key]);
                            foreach ($arrToppingID as $i => $v) {
                                $arrOrderDetailTopping = array(
                                    'active_order_detail_id' => $active_order_detail_id,
                                    'topping' => $this->db->get_where('topping', array('id' => $v))
                                        ->row_array()['topping_name'],
                                    'price' => $this->db->get_where('topping', array('id' => $v))
                                        ->row_array()['price'],
                                    'created_at' => DATE_TIME,
                                    'updated_at' => DATE_TIME,
                                );

                                $this->db->insert('active_order_detail_topping', $arrOrderDetailTopping);
                            }
                        }
                    }
                }
            }

//check rollback
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_complete();
            }


            redirect('pos/tables');
            die();
        }
    }

    public function _get_menu_name($menu_id)
    {

        $this->db->select('*');
        $this->db->from('menu');
        $this->db->where("id = " . $menu_id);
        $this->db->limit(1);
        // $this->db->order_by("id", "asc");
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $row = $query->row_array();
            return $row['product'];
        } else {
            return '';
        }
    }

    public function _new_order_backhome()
    {


//add new
        $this->db->trans_begin();

        $arrOrder = array(
            'tables_number' => 0, //กลับบ้านจะเป็น 0
            'users_id' => $this->session->userdata('users_id'),
            'created_at' => DATE_TIME,
            'updated_at' => DATE_TIME,
        );
        if ($this->db->insert('active_order', $arrOrder)) {
            $insert_id = $this->db->insert_id();
            foreach ($this->input->post('menu_id') as $key => $value) {

                $qty = $this->input->post('menu_qty')[$key];
                $price = $this->input->post('menu_price')[$key];

                $arrOrderDetail = array(
                    'active_order_id' => $insert_id,
                    'menu_id' => $value,
                    'menu_name' => $this->_get_menu_name($value),
                    'menu_type' => $this->_getMenuType($this->input->post('menu_type')[$key]),
                    'qty' => $qty,
                    'price' => $price,
                    'created_at' => DATE_TIME,
                    'updated_at' => DATE_TIME,
                );

                $this->db->insert('active_order_detail', $arrOrderDetail);
            }
        }

//check rollback
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_complete();
        }


        redirect('pos/buy_back_home');
        die();
    }

    protected $active_order_detail_id = '';

    public function _check_item_duplicate($active_order_id = '', $menu_id = '', $menu_type = '')
    {
//check ซ้ำรายการ ให้ update จำนวน
        $this->db->select('*');
        $this->db->from('active_order_detail');
        $this->db->where("active_order_id  = " . $active_order_id);
        $this->db->where("menu_id  = " . $menu_id);
        $this->db->where("menu_type  = '" . $menu_type . "'");

        $query = $this->db->get();
        $res = $query->result_array();


        if ($query->num_rows() > 0) {

            foreach ($res as $row) {

                $this->db->select('*');
                $this->db->from('active_order_detail_topping');
                $this->db->where("active_order_detail_id  = " . $row['id']);
                $query2 = $this->db->get();
                if ($query2->num_rows() > 0) {

//ถ้าไม่มี topping ให้ UPDATE จำนวน

                    return 'new';

                } else {

                    return  $row['id'];;

                }
            }

           // return 'update';


        } else {
            //ถ้าไม่มีให้เพิ่ม New
            return 'new';
        }
    }


    public function _update_order_backhome($active_order_id = '')
    {

        if ($active_order_id != '') {

            $this->db->trans_begin();

            foreach ($this->input->post('menu_id') as $key => $value) {

                $qty = $this->input->post('menu_qty')[$key];
                $price = $this->input->post('menu_price')[$key];
                $menu_type = $this->_getMenuType($this->input->post('menu_type')[$key]);

                if ($this->_check_item_duplicate($active_order_id, $value, $menu_type) == 'update') {
// echo 'update';

                    $condition = array(
                        'active_order_id' => $active_order_id,
                        'menu_id' => $value,
                        'menu_name' => $this->_get_menu_name($value),
                        'menu_type' => $menu_type
                    );
                    $now_qty = $this->db->get_where('active_order_detail', $condition)
                        ->row_array()['qty'];

//update จำนวน
                    $this->db->where('active_order_id', $active_order_id);
                    $this->db->where('menu_id', $value);
                    $this->db->where('menu_type', $menu_type);
                    $this->db->update('active_order_detail', ['qty' => $qty + $now_qty, 'updated_at' => DATE_TIME]);
                } else {
//new
                    $arrOrderDetail = array(
                        'active_order_id' => $active_order_id,
                        'menu_id' => $value,
                        'menu_name' => $this->_get_menu_name($value),
                        'menu_type' => $menu_type,
                        'qty' => $qty,
                        'price' => $price,
                        'created_at' => DATE_TIME,
                        'updated_at' => DATE_TIME,
                    );

                    $this->db->insert('active_order_detail', $arrOrderDetail);
                }
            }
//check rollback
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_complete();
            }
            redirect('pos/buy_back_home');
            die();
        }
    }


    public function _update_order($active_order_id = '')
    {

        if ($active_order_id != '') {

            //   $this->db->trans_begin();

            foreach ($this->input->post('menu_id') as $key => $value) {

                $qty = $this->input->post('menu_qty')[$key];
                $price = $this->input->post('menu_price')[$key];
                $menu_type = $this->_getMenuType($this->input->post('menu_type')[$key]);


                //ถ้ามีเลือก topping ให้ add new row ใหม่
                if ($this->input->post('topping_id')[$key] != 0) {


                    $arrOrderDetail = array(
                        'active_order_id' => $active_order_id,
                        'menu_id' => $value,
                        'menu_name' => $this->_get_menu_name($value),
                        'menu_type' => $menu_type,
                        'qty' => $qty,
                        'price' => $price,
                        'created_at' => DATE_TIME,
                        'updated_at' => DATE_TIME,
                    );


                    if ($this->db->insert('active_order_detail', $arrOrderDetail)) {

                        //add to topping table
                        $active_order_detail_id = $this->db->insert_id();
                        if ($this->input->post('topping_id')[$key] != 0) {

                            $arrToppingID = explode(',', $this->input->post('topping_id')[$key]);
                            foreach ($arrToppingID as $i => $v) {
                                $arrOrderDetailTopping = array(
                                    'active_order_detail_id' => $active_order_detail_id,
                                    'topping' => $this->db->get_where('topping', array('id' => $v))
                                        ->row_array()['topping_name'],
                                    'price' => $this->db->get_where('topping', array('id' => $v))
                                        ->row_array()['price'],
                                    'created_at' => DATE_TIME,
                                    'updated_at' => DATE_TIME,
                                );

                                $this->db->insert('active_order_detail_topping', $arrOrderDetailTopping);
                            }
                        }
                    }

                } else {

                    //ถ้าไม่มี topping
                    $order_detail_id =  $this->_check_item_duplicate($active_order_id, $value, $menu_type);
                    if ($order_detail_id != 'new') {
                        // echo 'update';

                        $condition = array(
                            'id' => $order_detail_id,
                          //  'menu_id' => $value,
                         //   'menu_name' => $this->_get_menu_name($value),
                         //   'menu_type' => $menu_type
                        );
                        $now_qty = $this->db->get_where('active_order_detail', $condition)
                            ->row_array()['qty'];

//update จำนวน
                        $this->db->where('id', $order_detail_id);
                      //  $this->db->where('menu_id', $value);
                       // $this->db->where('menu_type', $menu_type);
                        $this->db->update('active_order_detail', ['qty' => $qty + $now_qty, 'updated_at' => DATE_TIME]);


                        //  print_r($this->db->last_query());
                        // die();
                        //add to topping table
                       // $active_order_detail_id = $this->active_order_detail_id;
//                        if ($this->input->post('topping_id')[$key] != 0) {
//
//                            $arrToppingID = explode(',', $this->input->post('topping_id')[$key]);
//                            foreach ($arrToppingID as $i => $v) {
//                                $arrOrderDetailTopping = array(
//                                    'active_order_detail_id' => $active_order_detail_id,
//                                    'topping' => $this->db->get_where('topping', array('id' => $v))
//                                        ->row_array()['topping_name'],
//                                    'price' => $this->db->get_where('topping', array('id' => $v))
//                                        ->row_array()['price'],
//                                    'created_at' => DATE_TIME,
//                                    'updated_at' => DATE_TIME,
//                                );
//
//                                $this->db->insert('active_order_detail_topping', $arrOrderDetailTopping);
//                            }
//                        }
                       // $this->active_order_detail_id = '';
                        //
                    } else {
//new
                        $arrOrderDetail = array(
                            'active_order_id' => $active_order_id,
                            'menu_id' => $value,
                            'menu_name' => $this->_get_menu_name($value),
                            'menu_type' => $menu_type,
                            'qty' => $qty,
                            'price' => $price,
                            'created_at' => DATE_TIME,
                            'updated_at' => DATE_TIME,
                        );


                        if ($this->db->insert('active_order_detail', $arrOrderDetail)) {

                            //add to topping table
                            $active_order_detail_id = $this->db->insert_id();
                            if ($this->input->post('topping_id')[$key] != 0) {

                                $arrToppingID = explode(',', $this->input->post('topping_id')[$key]);
                                foreach ($arrToppingID as $i => $v) {
                                    $arrOrderDetailTopping = array(
                                        'active_order_detail_id' => $active_order_detail_id,
                                        'topping' => $this->db->get_where('topping', array('id' => $v))
                                            ->row_array()['topping_name'],
                                        'price' => $this->db->get_where('topping', array('id' => $v))
                                            ->row_array()['price'],
                                        'created_at' => DATE_TIME,
                                        'updated_at' => DATE_TIME,
                                    );

                                    $this->db->insert('active_order_detail_topping', $arrOrderDetailTopping);
                                }
                            }
                        }
                    }
                }


            }
//check rollback
//            if ($this->db->trans_status() === FALSE) {
//                $this->db->trans_rollback();
//            } else {
//                $this->db->trans_complete();
//            }
            redirect('pos/tables');
            die();
        }
    }

    public function move_table()
    {

        $this->db->trans_begin();

        $old_table = $this->input->post('old_table');
        $new_table = $this->input->post('new_table');

        if ($old_table != '' && $new_table != '') {
            $seat_number = $this->db->get_where('seat', array('id' => 1))->row_array()['seat_number'];
            if ($new_table > $seat_number) {
                redirect('pos/tables');
                die();
            }

//check โต๊ะที่จะย้ายต้องปิด order ไปแล้ว
            $this->db->select('*');
            $this->db->from('active_order');
            $this->db->where("tables_number = " . $new_table);
            $this->db->where("paid_date = '0000-00-00 00:00:00'");
            $query = $this->db->get();
            if ($query->num_rows() == 0) {

                $this->db->update('active_order', ['tables_number' => $new_table], "paid_date = '0000-00-00 00:00:00' AND tables_number = " . $old_table);
            }

            //check rollback
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_complete();
            }

            redirect('pos/tables');
        } else {
            redirect('pos/tables');
            die();
        }
    }

    public function buy_back_home($id = '')
    {
        if ($this->session->userdata('position') != 'พนักงานเสิร์ฟ' &&
            $this->session->userdata('position') != 'แคชเชียร์' &&
            $this->session->userdata('position') != 'ผู้ดูแลระบบ'
        ) {
            redirect('404');
        }

        //Check new order back home
        if ($this->input->post('btn_submit') == 'add_queue') {


            $active_order_id = $this->input->post('active_order_id');

            if ($active_order_id != '') {
//update item same order
                $this->_update_order_backhome($active_order_id);
                die();
            } else {

//add new item same order
                $this->_new_order_backhome();
                die();
            }
        } else {

//มีการสั่งเพิ่ม update order
            if ($this->input->post('active_order_id_selected_detail') != '') {


                $this->db->select('*');
                $this->db->from('category');
//    $this->db->where($condition);
//  $this->db->limit(1);
                $this->db->order_by("id", "asc");
                $query = $this->db->get();

                if ($query->num_rows() > 0) {

                    $resultq1 = $query->result_array();
                    $data['resultq1'] = $resultq1;
                    $data['pos'] = 'buy_back_home';
                    $data['active_order_id'] = $this->input->post('active_order_id_selected_detail');


                    $data = array(
                        'content' => $this->load->view('pos/choose_menu_backhome', $data, true),
                    );
                } else {
                    $data = array(
                        'content' => $this->load->view('pos/choose_menu_backhome', '', true),
                    );
                }
            } else {


//ลูกค้าคนใหม่สั่ง New order
                if ($this->input->post('buy_back_home') == 'new_to_go') {

                    $this->db->select('*');
                    $this->db->from('category');
//    $this->db->where($condition);
//  $this->db->limit(1);
                    $this->db->order_by("id", "asc");
                    $query = $this->db->get();

                    if ($query->num_rows() > 0) {

                        $resultq1 = $query->result_array();
                        $data['resultq1'] = $resultq1;
                        $data['pos'] = 'buy_back_home';
                        $data['active_order_id'] = '';


                        $data = array(
                            'content' => $this->load->view('pos/choose_menu_backhome', $data, true),
                        );
                    } else {
                        $data = array(
                            'content' => $this->load->view('pos/choose_menu_backhome', '', true),
                        );
                    }
                } else {

//แสดงหน้าเริ่มต้น
                    $this->db->select('*');
                    $this->db->from('category');
//    $this->db->where($condition);
//  $this->db->limit(1);
                    $this->db->order_by("id", "asc");
                    $query = $this->db->get();

                    if ($query->num_rows() > 0) {

                        $resultq1 = $query->result_array();
                        $data['resultq1'] = $resultq1;
                        $data['pos'] = 'buy_back_home';


                        $data = array(
                            'content' => $this->load->view('pos/index', $data, true),
                        );
                    } else {
                        $data = array(
                            'content' => $this->load->view('pos/index', '', true),
                        );
                    }
                }
            }
        }

        $this->load->view('main_layout', $data);
    }

    public function barista($id = '')
    {


        if ($this->session->userdata('position') != 'คนชงกาแฟ' && $this->session->userdata('position') != 'ผู้ดูแลระบบ') {
            redirect('404');
        }

        if ($this->input->post('btn_submit') == 'add_queue') {


            $active_order_id = $this->input->post('active_order_id');

            if ($active_order_id != '') {
//update item same order
                $this->_update_order_backhome($active_order_id);
                die();
            } else {

//add new item same order
                $this->_new_order_backhome();
                die();
            }
        } else {

//มีการสั่งเพิ่ม update order
            if ($this->input->post('active_order_id_selected_detail') != '') {


                $this->db->select('*');
                $this->db->from('category');
//    $this->db->where($condition);
//  $this->db->limit(1);
                $this->db->order_by("id", "asc");
                $query = $this->db->get();

                if ($query->num_rows() > 0) {

                    $resultq1 = $query->result_array();
                    $data['resultq1'] = $resultq1;
                    $data['pos'] = 'buy_back_home';
                    $data['active_order_id'] = $this->input->post('active_order_id_selected_detail');


                    $data = array(
                        'content' => $this->load->view('pos/choose_menu_backhome', $data, true),
                    );
                } else {
                    $data = array(
                        'content' => $this->load->view('pos/choose_menu_backhome', '', true),
                    );
                }
            } else {


//ลูกค้าคนใหม่สั่ง New order
                if ($this->input->post('buy_back_home') == 'new_to_go') {

                    $this->db->select('*');
                    $this->db->from('category');
//    $this->db->where($condition);
//  $this->db->limit(1);
                    $this->db->order_by("id", "asc");
                    $query = $this->db->get();

                    if ($query->num_rows() > 0) {

                        $resultq1 = $query->result_array();
                        $data['resultq1'] = $resultq1;
                        $data['pos'] = 'barista';
                        $data['active_order_id'] = '';


                        $data = array(
                            'content' => $this->load->view('pos/choose_menu_backhome', $data, true),
                        );
                    } else {
                        $data = array(
                            'content' => $this->load->view('pos/choose_menu_backhome', '', true),
                        );
                    }
                } else {


//แสดงหน้าเริ่มต้น
                    $this->db->select('*');
                    $this->db->from('category');
//    $this->db->where($condition);
//  $this->db->limit(1);
                    $this->db->order_by("id", "asc");
                    $query = $this->db->get();

                    if ($query->num_rows() > 0) {

                        $resultq1 = $query->result_array();
                        $data['resultq1'] = $resultq1;
                        $data['pos'] = 'barista';


                        $data = array(
                            'content' => $this->load->view('pos/index', $data, true),
                        );
                    } else {
                        $data = array(
                            'content' => $this->load->view('pos/index', '', true),
                        );
                    }
                }
            }
        }

        $this->load->view('main_layout', $data);
    }

    public function tables($id = '')
    {

        if ($this->session->userdata('position') != 'พนักงานเสิร์ฟ' && $this->session->userdata('position') != 'แคชเชียร์' && $this->session->userdata('position') != 'ผู้ดูแลระบบ') {
            redirect('404');
        }

//กินร้าน

        if ($this->input->post('btn_submit') == 'add_to_table') {
//มีการสั่ง order
//เช็ค 

            $table_num = $this->input->post('tables_number');
            $this->db->select('*');
            $this->db->from('active_order');
            $this->db->where("tables_number = " . $table_num);
            $this->db->where("paid_date = '0000-00-00 00:00:00'");
            $query = $this->db->get();
            if ($query->num_rows() == 1) {

//update  ถ้ามี order ให้ update
                //Table เดิมสั่งเพิ่ม
                $active_order_id = $query->row_array()['id'];

                $this->_update_order($active_order_id);
                die();
            } else {

//add new order (open new table)
                $this->_new_order($table_num);
                die();
            }
        } else {

            if ($this->input->post('tables_number') != '') {

                $this->db->select('*');
                $this->db->from('category');
//    $this->db->where($condition);
//  $this->db->limit(1);
                $this->db->order_by("id", "asc");
                $query = $this->db->get();

                if ($query->num_rows() > 0) {

                    $resultq1 = $query->result_array();
                    $data['resultq1'] = $resultq1;
                    $data['pos'] = 'tables';
                    $data['tables_number'] = $this->input->post('tables_number');


                    $data = array(
                        'content' => $this->load->view('pos/choose_menu', $data, true),
                    );
                } else {
                    $data = array(
                        'content' => $this->load->view('pos/choose_menu', '', true),
                    );
                }
            } else {


                $this->db->select('*');
                $this->db->from('category');
//    $this->db->where($condition);
//  $this->db->limit(1);
                $this->db->order_by("id", "asc");
                $query = $this->db->get();

                if ($query->num_rows() > 0) {

                    $resultq1 = $query->result_array();
                    $data['resultq1'] = $resultq1;
                    $data['pos'] = 'tables';


                    $data = array(
                        'content' => $this->load->view('pos/index', $data, true),
                    );
                } else {
                    $data = array(
                        'content' => $this->load->view('pos/index', '', true),
                    );
                }
            }
        }

        $this->load->view('main_layout', $data);
    }

    public function ajax_get_catelog_child()
    {


        if ($this->input->get('category_id') != '') {

            $category_id = $this->input->get('category_id');

            $category_name = $this->db->get_where('category', array('id' => $category_id))->row_array()['category_name'];

            $this->db->select('*');
            $this->db->from('menu');
            $this->db->where('category_id = ' . $category_id);
            $this->db->order_by("product", "asc");
            $query = $this->db->get();

            $data['category_name'] = $category_name;


            $res_menu = $query->result_array();
            $data['res_menu'] = $res_menu;

            $data = array(
                'content' => $this->load->view('pos/ajax_get_catelog_child', $data, true),
            );
        } else {

        }
        echo $data['content'];
    }

    public function ajax_sum_main_table()
    {


        $this->db->select("*");
        $this->db->from("active_order");
        $this->db->where("paid_date = '0000-00-00 00:00:00'");
// $this->db->order_by("product", "asc");
        $query = $this->db->get();

//  $arr = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {

                $arr[] = $this->get_total_price_order($row['id'], $row['tables_number']);
            }
            echo json_encode($arr);
        } else {
            $arr = array();
            echo json_encode($arr);
        }
    }

    public function get_total_price_order($order_id = '', $tables_number = '')
    {

        $total = 0;

        $this->db->select('*');
        $this->db->from('active_order_detail');
        $this->db->where("active_order_id = " . $order_id);

        $query = $this->db->get();

        $qty = 0;
        $finished_qty = 0;
        $count_status = 0;
        $status = '0';

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $total = $total + ($row['qty'] * $row['price']);
                $qty = $qty + $row['qty'];
                $finished_qty = $finished_qty + $row['finished_qty'];

                if ($row['status'] == 'กำลังทำ') {
                    $count_status = $count_status + 1;
                }
            }
            if ($qty > $finished_qty) {
//ยังไม่เสร็จ
                $status = '0';
            } else {
//เสร็จหมด
                $status = '1';
            }
            $arr = array(
                'active_order_id' => $order_id,
                'tables_number' => $tables_number,
                'total' => $total,
                'num_rows' => $this->_get_main_numrows($order_id),
                'last_update' => $this->get_last_update($order_id),
                'created_at' => $row['created_at'],
                'total_qty' => $qty,
                'status' => $status
            );
            return $arr;
        } else {
            $arr = array(
                'active_order_id' => $order_id,
                'tables_number' => $tables_number,
                'total' => 0,
                'num_rows' => 0,
                'last_update' => '0000-00-00 00:00:00',
                'created_at' => '0000-00-00 00:00:00',
                'total_qty' => 0,
                'status' => $status
            );
            return $arr;
        }
    }

    public function ajax_sum_main_table_backhome()
    {


        $this->db->select("*");
        $this->db->from("active_order");
        $this->db->where("tables_number = 0");
        $this->db->where("paid_date = '0000-00-00 00:00:00'");
        $this->db->order_by("id", "asc");
        $query = $this->db->get();

//  $arr = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {

                $arr[] = $this->get_total_price_order($row['id'], $row['tables_number']);
            }

            echo json_encode($arr);
            die();
        } else {
            $arr = array();
            echo json_encode($arr);
        }
    }

    public function ajax_sum_main_table_barista()
    {

        $this->db->select("*");
        $this->db->from("active_order");
//  $this->db->where("tables_number = 0");
// $this->db->where("paid_date = '0000-00-00 00:00:00'");
        $this->db->order_by("id", "asc");
        $query = $this->db->get();

//  $arr = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {

                $arr[] = $this->get_total_price_order($row['id'], $row['tables_number']);
            }

            echo json_encode($arr);
            die();
        } else {
            $arr = array();
            echo json_encode($arr);
        }
    }

    public function ajax_sum_detail_table()
    {

        $tables_number = $this->input->get('tables_number');

        $this->db->select("*");
        $this->db->from("active_order");
        $this->db->where("paid_date = '0000-00-00 00:00:00'");
        $this->db->where("tables_number = " . $tables_number);
// $this->db->order_by("product", "asc");
        $query = $this->db->get();

//  $arr = array();
        if ($query->num_rows() > 0) {

            $row = $query->row_array();
            $active_order_id = $row['id'];
            $tables_number = $row['tables_number'];
            $created_at = $row['created_at'];

            $arr = $this->get_list_order_menu($active_order_id, $tables_number, $created_at);

            echo json_encode($arr);

        } else {

            $arr = array();
            echo json_encode($arr);

        }
    }

    public function ajax_sum_detail_table_backhome()
    {

        $active_order_id_selected = $this->input->get('active_order_id_selected');

        $this->db->select("*");
        $this->db->from("active_order");
//   $this->db->where("paid_date = '0000-00-00 00:00:00'");
        $this->db->where("id = " . $active_order_id_selected);
// $this->db->order_by("product", "asc");
        $query = $this->db->get();

//  $arr = array();
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            $active_order_id = $row['id'];
            $tables_number = $row['tables_number'];
            $created_at = $row['created_at'];

            $arr = $this->get_list_order_menu($active_order_id, $tables_number, $created_at);

            echo json_encode($arr);
        } else {
            $arr = array();
            echo json_encode($arr);
        }
    }

    public function get_list_order_menu($active_order_id = '', $tables_number = '', $created_at = '')
    {

        $total_price = 0;
        $total_qty = 0;
        //    $this->db->select('*,SUM(qty) AS sum_qty');
        $this->db->select('*');
        $this->db->from('active_order_detail');
        $this->db->where("active_order_id = " . $active_order_id);
        //  $this->db->group_by('menu_id');
        //  $this->db->group_by('menu_type');


        $query = $this->db->get();


        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $total_qty = $total_qty + $row['qty'];
                $total_price = $total_price + ($row['price'] * $row['qty']);
                $arr[] = array(
                    'id' => $row['id'],
                    'active_order_id' => $row['active_order_id'],
                    'menu_id' => $row['menu_id'],
                    'tables_number' => $tables_number,
                    'num_rows' => $this->_get_numrows_order_detail($active_order_id),
                    'created_at' => $created_at,
                    'product' => $this->db->get_where('menu', array('id' => $row['menu_id']))->row_array()['product'],
                    'menu_type' => $this->_getMenuTypeEng($row['menu_type']),
                    'menu_type_eng' => $row['menu_type'],
                    'qty' => ($row['qty']),
                    'finished_qty' => $row['finished_qty'],
                    'price' => ($row['price']),
                    'status' => ($row['status']),
                    'total_price' => $this->get_total_price($active_order_id),
                    'total_qty' => $this->get_total_qty($active_order_id),
                    'last_update' => $this->get_last_update($active_order_id),
                    'topping_list' => $this->get_topping_order_detail($row['id']),
                );
            }
//   $arr[] = [ 'total_qty' =>  $total_qty ];
// $arr[] = ['total_price' =>  $total_price];


            return $arr;
        } else {
            return '';
        }
    }

    public function get_list_order_menu2($active_order_id = '', $tables_number = '', $created_at = '')
    {

        $total_price = 0;
        $total_qty = 0;
        $this->db->select('*,SUM(qty) AS sum_qty');
        $this->db->from('active_order_detail');
        $this->db->where("active_order_id = " . $active_order_id);
        $this->db->group_by('menu_id');
        $this->db->group_by('menu_type');


        $query = $this->db->get();


        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $total_qty = $total_qty + $row['qty'];
                $total_price = $total_price + ($row['price'] * $row['qty']);
                $arr[] = array(
                    'id' => $row['id'],
                    'active_order_id' => $row['active_order_id'],
                    'menu_id' => $row['menu_id'],
                    'tables_number' => $tables_number,
                    'num_rows' => $this->_get_numrows_order_detail($active_order_id),
                    'created_at' => $created_at,
                    'product' => $this->db->get_where('menu', array('id' => $row['menu_id']))->row_array()['product'],
                    'menu_type' => $this->_getMenuTypeEng($row['menu_type']),
                    'menu_type_eng' => $row['menu_type'],
                    'qty' => ($row['sum_qty']),
                    'finished_qty' => $row['finished_qty'],
                    'price' => ($row['price']),
                    'status' => ($row['status']),
                    'total_price' => $this->get_total_price($active_order_id),
                    'total_qty' => $this->get_total_qty($active_order_id),
                    'last_update' => $this->get_last_update($active_order_id),
                    'topping_list' => $this->get_topping_order_detail($row['id']),
                );
            }
//   $arr[] = [ 'total_qty' =>  $total_qty ];
// $arr[] = ['total_price' =>  $total_price];


            return $arr;
        } else {
            return '';
        }
    }

    public function _get_numrows_order_detail($active_order_id = '')
    {
        $this->db->select('count(id) AS num_rows');
        $this->db->from('active_order_detail');
        $this->db->where("active_order_id = " . $active_order_id);
        $this->db->group_by('active_order_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row['num_rows'];
        } else {
            return '0';
        }
    }

    public function _get_main_numrows($active_order_id = '')
    {
        $this->db->select('*');
        $this->db->from('active_order');
        $this->db->where("tables_number = 0");
        $this->db->where("paid_date = '0000-00-00 00:00:00'");

        $query = $this->db->get();
        if ($query->num_rows() > 0) {

            return $query->num_rows();
        } else {
            return '0';
        }
    }


    public function get_topping_order_detail($active_order_detail_id)
    {

        $this->db->select('*');
        $this->db->from('active_order_detail_topping');
        $this->db->where("active_order_detail_id = " . $active_order_detail_id);
        $this->db->order_by("topping", "asc");
        $query = $this->db->get();
        // print_r($query->result_array());
        //  die();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {

            return '';
        }

    }

    public function ajax_remove_items()
    {

        $this->db->trans_begin();
//  $arr = implode('-', $this->input->post('chkbox'));

        $active_order_id = $this->input->get('active_order_id');
        $menu_id = $this->input->get('menu_id');
        $menu_type = $this->input->get('menu_type');

        $this->db->where('active_order_id', $active_order_id);
        $this->db->where('menu_id', $menu_id);
        $this->db->where('menu_type', $menu_type);
        $this->db->delete('active_order_detail');
//check rollback
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo 'remove error';
        } else {
            $this->db->trans_complete();
            echo 'remove success';
        }
    }

    public function ajax_clear_table()
    {

        $this->db->trans_begin();
//  $arr = implode('-', $this->input->post('chkbox'));
//   $this->db->get_where('rental', array('id' => $id))->row_array()['room_id'];

        $tables_number = $this->input->get('tables_number');

        $this->db->where('tables_number', $tables_number);
        $this->db->where('paid_date', '0000-00-00 00:00:00');
        $this->db->delete('active_order');

//check rollback
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo 'remove error';
        } else {
            $this->db->trans_complete();
            echo 'remove success';
        }
    }

    public function ajax_clear_backhome()
    {

        $this->db->trans_begin();
//  $arr = implode('-', $this->input->post('chkbox'));
//   $this->db->get_where('rental', array('id' => $id))->row_array()['room_id'];

        $active_order_id_selected = $this->input->get('active_order_id_selected');

        $this->db->where('id', $active_order_id_selected);
        $this->db->where('paid_date', '0000-00-00 00:00:00');
        $this->db->delete('active_order');

//check rollback
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo 'remove error';
        } else {
            $this->db->trans_complete();
            echo 'remove success';
        }
    }

    public function ajax_remove_item()
    {

        $this->db->trans_begin();
//  $arr = implode('-', $this->input->post('chkbox'));
//   $this->db->get_where('rental', array('id' => $id))->row_array()['room_id'];

        $item_id = $this->input->get('item_id');

        $this->db->where('id', $item_id);
        $this->db->delete('active_order_detail');

//check rollback
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo 'remove error';
        } else {
            $this->db->trans_complete();
            echo 'remove success';
        }
    }

    public function ajax_edit_items()
    {

        $this->db->trans_begin();
//  $arr = implode('-', $this->input->post('chkbox'));

        $active_order_detail_id = $this->input->get('active_order_detail_id');
        $active_order_id = $this->input->get('active_order_id');
        $menu_id = $this->input->get('menu_id');
        $menu_type = $this->input->get('menu_type');

        //จำนวนปัจจุบัน
        $current_qty = $this->input->get('current_qty');

        //จำนวนที่ต้องการ เพิ่ม หรือ ลบ เช่น เพิ่ม 1 หรือ ลด (-1)
        $qty = $this->input->get('qty');

        $new_qty = 0;

        if (substr($qty, 1) == '-') {
            $new_qty = $current_qty - $qty;
        } else {
            $new_qty = $current_qty + $qty;
        }

        $this->db->where('id', $active_order_detail_id);
       // $this->db->where('active_order_id', $active_order_id);
       // $this->db->where('menu_id', $menu_id);
       // $this->db->where('menu_type', $menu_type);
        $this->db->update('active_order_detail', array('qty' => $new_qty, 'updated_at' => DATE_TIME));

//check rollback
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo 'edit error';
        } else {
            $this->db->trans_complete();
            echo 'edit success';
        }

    }

    public function ajax_pay_cash()
    {

        $this->db->trans_begin();
//  $arr = implode('-', $this->input->post('chkbox'));


        $tables_number = $this->input->get('tables_number');

        $cash_receive = $this->input->get('cash_receive'); //รับเงินมา

        $order_id = $this->db->get_where('active_order', array('tables_number' => $tables_number, 'paid_date' => '0000-00-00 00:00:00'))->row_array()['id'];


        $this->db->where('tables_number', $tables_number);
        $this->db->where('paid_date', '0000-00-00 00:00:00');

        $this->db->update('active_order', array('cash_receive' => $cash_receive, 'paid_date' => DATE_TIME, 'updated_at' => DATE_TIME, 'cashier_id' => $this->session->userdata('users_id')));
//check rollback
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo 'error';
            $arr = array(
                'status' => 'error',
                'order_id' => $order_id
            );
            echo json_encode($arr);
        } else {
            $this->db->trans_complete();
            $arr = array(
                'status' => 'success',
                'order_id' => $order_id
            );
            echo json_encode($arr);
        }
    }

    public function ajax_check_finished()
    {
//เปลี่ยนสถานะเมื่อทำเสร็จแล้ว
        $this->db->trans_begin();
//  $arr = implode('-', $this->input->post('chkbox'));

        $order_detail_id = $this->input->get('order_detail_id');

        $status = $this->db->get_where('active_order_detail', array('id' => $order_detail_id))->row_array()['status'];
        $qty = $this->db->get_where('active_order_detail', array('id' => $order_detail_id))->row_array()['qty'];
        if ($status == 'ทำเสร็จแล้ว') {
            $_status = 'กำลังทำ';
        } else {
            $_status = 'ทำเสร็จแล้ว';
        }

        $this->db->where('id', $order_detail_id);
        $this->db->update('active_order_detail', array('status' => $_status, 'finished_qty' => $qty, 'updated_at' => DATE_TIME, 'barista_id' => $this->session->userdata('users_id')));

//check rollback
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_complete();
        }
    }

    public function ajax_check_all_finished()
    {
//เปลี่ยนสถานะเมื่อทำเสร็จแล้ว
        $this->db->trans_begin();

        $active_order_id_selected = $this->input->get('active_order_id_selected');

        $this->db->select('*');
        $this->db->from('active_order_detail');
        $this->db->where("active_order_id = " . $active_order_id_selected);
        $query = $this->db->get();


        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $this->db->where('id', $row['id']);
                $this->db->update('active_order_detail', array('finished_qty' => $row['qty'], 'updated_at' => DATE_TIME, 'barista_id' => $this->session->userdata('users_id')));
            }
        }


//check rollback
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_complete();
        }
    }

    public function ajax_pay_cash_backhome()
    {

        $this->db->trans_begin();

        $active_order_id = $this->input->get('active_order_id');
        $cash_receive = $this->input->get('cash_receive');

//  $order_id = $this->db->get_where('active_order', array('id' => $active_order_id, 'paid_date' => '0000-00-00 00:00:00'))->row_array()['id'];

        $this->db->where('id', $active_order_id);
        $this->db->where('paid_date', '0000-00-00 00:00:00');
        $this->db->update('active_order', array('cash_receive' => $cash_receive, 'paid_date' => DATE_TIME, 'updated_at' => DATE_TIME, 'cashier_id' => $this->session->userdata('users_id')));
//check rollback
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo 'error';
            $arr = array(
                'status' => 'error',
                'order_id' => $active_order_id
            );
            echo json_encode($arr);
        } else {
            $this->db->trans_complete();
            $arr = array(
                'status' => 'success',
                'order_id' => $active_order_id
            );
            echo json_encode($arr);
        }
    }

    public function get_last_update($active_order_id = '')
    {


        $this->db->select('*');
        $this->db->from('active_order_detail');
        $this->db->where("active_order_id = " . $active_order_id);
        $this->db->limit(1);
        $this->db->order_by("updated_at", "desc");
        $query = $this->db->get();


        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $updated_at = $row['updated_at'];
            }

            return $updated_at;
        } else {
            return '0000-00-00 00:00:00';
        }
    }

    public function get_total_price($active_order_id = '')
    {

        $total = 0;

        $this->db->select('*');
        $this->db->from('active_order_detail');
        $this->db->where("active_order_id = " . $active_order_id);

        $query = $this->db->get();


        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $total = $total + ($row['qty'] * $row['price']);
            }

            return $total;
        } else {
            return '0';
        }
    }

    public function get_total_qty($active_order_id = '')
    {

        $total = 0;

        $this->db->select('*');
        $this->db->from('active_order_detail');
        $this->db->where("active_order_id = " . $active_order_id);

        $query = $this->db->get();


        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $total = $total + ($row['qty']);
            }

            return $total;
        } else {
            return '0';
        }
    }

    public function buy_back_homes($id = '')
    {


//ซื้อกลับบ้าน
        $this->db->select('*');
        $this->db->from('category');
//    $this->db->where($condition);
//  $this->db->limit(1);
        $this->db->order_by("id", "asc");
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $resultq1 = $query->result_array();
            $data['resultq1'] = $resultq1;
            $data['pos'] = 'buy_back_home';


            $data = array(
                'content' => $this->load->view('pos/index', $data, true),
            );
        } else {
            $data = array(
                'content' => $this->load->view('pos/index', '', true),
            );
        }

        $this->load->view('main_layout', $data);
    }

    public function edit($id)
    {

        if ($this->input->post('btn_submit') == 'บันทึก' || $this->input->post('btn_submit') == 'บันทึกและแก้ไขต่อ') {

            if ($this->input->post('btn_submit') == 'บันทึก') {
                $redirect = true;
            } else {
                $redirect = false;
            }

            $dataInsert = array(
                'category_name' => $this->input->post('category_name'),
                'status' => $this->input->post('status'),
                'created_at' => DATE_TIME,
                'updated_at' => DATE_TIME,
            );

            $this->db->where('id', $id);
            if ($this->db->update('category', $dataInsert)) {

                $this->session->set_flashdata('message_success', 'แก้ไขข้อมูลแล้ว');
                if ($redirect) {
                    redirect('category');
                } else {

                    redirect('pos/edit/' . $id);
                }
            }
        } else {
            $this->db->select('*');
            $this->db->from('category');
            $this->db->where('id = ' . $id);
            $this->db->limit(1);
            $this->db->order_by("id", "asc");
            $query = $this->db->get();

            if ($query->num_rows() == 1) {

                $row = $query->row_array();

                $dataEdit = array(
                    'id' => $row['id'],
                    'res_category' => $row,
                );


                $data = array(
                    'content' => $this->load->view('pos/edit', $dataEdit, true),
                );
                $this->load->view('main_layout', $data);
            } else {
                $data = array(
                    'content' => $this->load->view('pos/index', '', true),
                );
            }
        }
    }

    public function add()
    {


        if ($this->input->post('btn_submit') == 'บันทึก' || $this->input->post('btn_submit') == 'บันทึกและแก้ไขต่อ') {
            if ($this->input->post('btn_submit') == 'บันทึก') {
                $redirect = true;
            } else {
                $redirect = false;
            }


            $dataInsert = array(
                'category_name' => $this->input->post('category_name'),
                'status' => $this->input->post('status'),
                'created_at' => DATE_TIME,
                'updated_at' => DATE_TIME,
            );

            if ($this->db->insert('category', $dataInsert)) {
                $this->session->set_flashdata('message_success', 'เพิ่มข้อมูลแล้ว');
                if ($redirect) {
                    redirect('category');
                } else {
                    $insert_id = $this->db->insert_id();
                    redirect('pos/edit/' . $insert_id);
                }
            }
        } else {

//Option ภายในห้อง
            $this->db->select('*');
            $this->db->from('category');
            $this->db->order_by("id", "asc");
            $query = $this->db->get();
            if ($query->num_rows() > 0) {

                $resultq1 = $query->result_array();
                $data_q['resultq1'] = $resultq1;


                $data = array(
                    'content' => $this->load->view('pos/add', $data_q, true),
                );
                $this->load->view('main_layout', $data);
            } else {
                $data = array(
                    'content' => $this->load->view('pos/add', '', true),
                );
                $this->load->view('main_layout', $data);
            }
        }
    }

    public function delete($id = '')
    {

        if ($this->input->post('btn_submit') == 'ลบที่เลือก') {
//  $arr = implode('-', $this->input->post('chkbox'));

            foreach ($this->input->post('chkbox') as $ids) {
                $this->db->where('id', $ids);
                $this->db->delete('category');
            }
            $this->session->set_flashdata('message_success', 'ลบข้อมูลแล้ว');
            redirect('category');
        } else {

            if ($this->db->delete('category', array('id' => $id))) {
                $this->session->set_flashdata('message_success', 'ลบข้อมูลแล้ว');
                redirect('category');
            }
        }
    }

    public function ajax_get_topping()
    {


//ซื้อกลับบ้าน
        $this->db->select('*');
        $this->db->from('topping');
//    $this->db->where($condition);
//  $this->db->limit(1);
        $this->db->order_by("topping_name", "asc");
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $res = $query->result_array();

            echo json_encode($res);
        } else {
            echo '';
        }
    }

}
