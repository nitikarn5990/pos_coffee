<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pos extends CI_Controller {

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

        redirect('pos/tables');
    }

    public function _getMenuType($_type) {
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

    public function _getMenuTypeEng($_type) {
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

    public function _new_order($table_number = '') {

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
                        'menu_type' => $this->_getMenuType($this->input->post('menu_type')[$key]),
                        'qty' => $qty,
                        'price' => $price,
                        'created_at' => DATE_TIME,
                        'updated_at' => DATE_TIME,
                    );

                    if ($this->db->insert('active_order_detail', $arrOrderDetail)) {
                        
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

    public function _check_item_duplicate($active_order_id = '', $menu_id = '', $menu_type = '') {
        //check ซ้ำรายการ ให้ update จำนวน
        $this->db->select('*');
        $this->db->from('active_order_detail');
        $this->db->where("active_order_id  = " . $active_order_id);
        $this->db->where("menu_id  = " . $menu_id);
        $this->db->where("menu_type  = '" . $menu_type . "'");
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            //update
            return 'update';
        } else {
            return 'new';
        }
    }

    public function _update_order($active_order_id = '') {

        if ($active_order_id != '') {

            $this->db->trans_begin();

            foreach ($this->input->post('menu_id') as $key => $value) {

                $qty = $this->input->post('menu_qty')[$key];
                $price = $this->input->post('menu_price')[$key];
                $menu_type = $this->_getMenuType($this->input->post('menu_type')[$key]);

                if ($this->_check_item_duplicate($active_order_id, $value, $menu_type) == 'update') {
                    echo 'update';

                    $condition = array(
                        'active_order_id' => $active_order_id,
                        'menu_id' => $value,
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
                        'menu_type' => $menu_type,
                        'qty' => $qty,
                        'price' => $price,
                        'created_at' => DATE_TIME,
                        'updated_at' => DATE_TIME,
                    );

                    if ($this->db->insert('active_order_detail', $arrOrderDetail)) {
                        
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

    public function move_table() {

        $old_table = $this->input->post('old_table');
        $new_table = $this->input->post('new_table');

        if ($old_table != '' && $new_table != '') {
            $seat_number = $this->db->get_where('seat', array('id' => 1))->row_array()['seat_number'];
            if ($new_table > $seat_number) {
                redirect('pos/tables');
                die();
            }

            $this->db->trans_begin();


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

      public function buy_back_home($id = '') {

        if ($this->input->post('btn_submit') == 'add_queue') {
            //มีการสั่ง order
            //เช็ค 
           
          //  $table_num = $this->input->post('tables_number');
            $this->db->select('*');
            $this->db->from('active_order');
            $this->db->where("tables_number = " . $table_num);
            $this->db->where("paid_date = '0000-00-00 00:00:00'");
            $query = $this->db->get();
            
            if ($query->num_rows() == 1) {
                //update
                $active_order_id = $query->row_array()['id'];

                $this->_update_order($active_order_id);
                 die();
            } else {

                //add new
                $this->_new_order($table_num);
                 die();
            }
           
        } else {
            // ถ้าไม่ได้สั่ง
            //มีการเลือกโต๊ะ
            if ($this->input->post('buy_back_home') != '') {
           
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
                  //  $data['tables_number'] = $this->input->post('tables_number');



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

        $this->load->view('main_layout', $data);
    }

    public function tables($id = '') {

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
                //update

                $active_order_id = $query->row_array()['id'];

                $this->_update_order($active_order_id);
                 die();
            } else {

                //add new
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

    public function ajax_get_catelog_child() {


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

    public function ajax_sum_main_table() {


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

    public function ajax_sum_detail_table() {

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

    public function _get_numrows_order_detail($active_order_id = '') {
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

    public function get_list_order_menu($active_order_id = '', $tables_number = '', $created_at = '') {

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
                $total_price = $total_price + ( $row['price'] * $row['qty'] );
                $arr[] = array(
                    'active_order_id' => $row['active_order_id'],
                    'menu_id' => $row['menu_id'],
                    'tables_number' => $tables_number,
                    'num_rows' => $this->_get_numrows_order_detail($active_order_id),
                    'created_at' => $created_at,
                    'product' => $this->db->get_where('menu', array('id' => $row['menu_id']))->row_array()['product'],
                    'menu_type' => $this->_getMenuTypeEng($row['menu_type']),
                    'menu_type_eng' => $row['menu_type'],
                    'qty' => ($row['sum_qty']),
                    'price' => ($row['price']),
                     'status' => ($row['status']),
                    'total_price' => $this->get_total_price($active_order_id),
                    'total_qty' => $this->get_total_qty($active_order_id),
                    'last_update' => $this->get_last_update($active_order_id)
                );
            }
            //   $arr[] = [ 'total_qty' =>  $total_qty ];
            // $arr[] = ['total_price' =>  $total_price];



            return $arr;
        } else {
            return '';
        }
    }

    public function ajax_remove_items() {

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
       public function ajax_clear_table() {

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
    
    public function ajax_edit_items() {

        $this->db->trans_begin();
        //  $arr = implode('-', $this->input->post('chkbox'));

        $active_order_id = $this->input->get('active_order_id');
        $menu_id = $this->input->get('menu_id');
        $menu_type = $this->input->get('menu_type');
        $qty = $this->input->get('qty');

        $this->db->where('active_order_id', $active_order_id);
        $this->db->where('menu_id', $menu_id);
        $this->db->where('menu_type', $menu_type);
        $this->db->update('active_order_detail',array('qty' => $qty, 'updated_at' => DATE_TIME));
        //check rollback
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo 'edit error';
        } else {
            $this->db->trans_complete();
            echo 'edit success';
        }

    }
        public function ajax_pay_cash() {

        $this->db->trans_begin();
        //  $arr = implode('-', $this->input->post('chkbox'));
        
        
        
        $tables_number = $this->input->get('tables_number');
        
        $order_id = $this->db->get_where('active_order', array('tables_number' => $tables_number ,'paid_date' =>  '0000-00-00 00:00:00'))->row_array()['id'];
        
     

        $this->db->where('tables_number', $tables_number);
        $this->db->where('paid_date', '0000-00-00 00:00:00');
     
        $this->db->update('active_order',array('paid_date' => DATE_TIME, 'updated_at' => DATE_TIME, 'cashier_id' => $this->session->userdata('users_id')));
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



    public function get_total_price_order($order_id = '', $tables_number = '') {

        $total = 0;

        $this->db->select('*');
        $this->db->from('active_order_detail');
        $this->db->where("active_order_id = " . $order_id);

        $query = $this->db->get();


        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $total = $total + ($row['qty'] * $row['price']);
            }
            $arr = array(
                'tables_number' => $tables_number,
                'total' => $total
            );
            return $arr;
        } else {
            return '';
        }
    }

    public function get_last_update($active_order_id = '') {



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

    public function get_total_price($active_order_id = '') {

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

    public function get_total_qty($active_order_id = '') {

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

    public function buy_back_homes($id = '') {
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

    public function edit($id) {

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

    public function add() {


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

    public function delete($id = '') {

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

}
