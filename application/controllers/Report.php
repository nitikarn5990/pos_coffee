<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class report extends CI_Controller {

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


        redirect('report/sales');
    }

    public function orders() {

        $this->db->select("*");
        $this->db->from('active_order');
        $this->db->where('paid_date !=', '0000-00-00 00:00:00');
        //   $this->db->join('active_order_detail', 'active_order.id = active_order_detail.active_order_id');
        //  $this->db->join('member', 'active_rent.member_id = member.id');
//        $arrDate = explode(' - ', $this->input->post('reservation'));
//        $arrDateSt = explode('/', $arrDate[0]);
//        $arrDateEnd = explode('/', $arrDate[1]);
//        $start_date = $arrDateSt[2] . '-' . $arrDateSt[0] . '-' . $arrDateSt[1] . ' ' . ' 00:00:00';
//        $end_date = $arrDateEnd[2] . '-' . $arrDateEnd[0] . '-' . $arrDateEnd[1] . ' ' . ' 23:59:59';
        // print_r($start_date);
        // die();
        //  if (trim($start_date) != '' && trim($end_date) != '') {
        //$this->db->where('active_order.created_at BETWEEN "' . $start_date . '" and "' . $end_date . '"');
        //$this->db->group_by('DATE(active_order.created_at)');


        $query = $this->db->get();
        //  print_r($this->db->last_query());
        //  die();
        foreach ($query->result_array() as $row) {
            $type = '';
            if ($row['tables_number'] == 0) {
                $type = 'Table.8';
            } else {
                $type = 'Back home';
            }
            $cashier_name = $this->db->get_where('users', array('id' => $row['cashier_id']))->row_array()['name'];

            $arr2[] = array(
                'cashier' => $cashier_name,
                'id' => $row['id'],
                'created_at' => $row['created_at'],
                'type' => $type
            );
        }
        $arr['data'] = ($arr2);
        //$arr['data'] = $query->result_array();

        echo json_encode($arr);

//        $dataView = [
//            'res_active_order_sales' => $query->result_array(),
//            'type' => 'orders'
//                //'result_active_payment' => $result_active_payment
//        ];
//
//        $data = array(
//            'content' => $this->load->view('report/sales', $dataView, true),
//        );
//        $this->load->view('main_layout', $data);
//        // }
    }

    public function get_total_price($active_order_id = '') {

        $total = 0;

        $this->db->select('*');
        $this->db->from('active_order_detail');
        $this->db->where("active_order_id = " . $active_order_id);

        $query = $this->db->get();


        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $total = $total + ($row['qty'] * ($row['price'] + $this->_get_total_price_topping($row['id'])));
            }

            return $total;
        } else {
            return '0';
        }
    }

    public function _get_total_price_topping($active_order_detail_id = '') {

        $total = 0;

        $this->db->select('*');
        $this->db->from('active_order_detail_topping');
        $this->db->where("active_order_detail_id = " . $active_order_detail_id);

        $query = $this->db->get();


        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $total = $total + $row['price'];
            }

            return $total;
        } else {
            return "0";
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

    public function get_topping_order_detail($active_order_detail_id) {

        $this->db->select('*');
        $this->db->from('active_order_detail_topping');
        $this->db->where("active_order_detail_id = " . $active_order_detail_id);
        $this->db->order_by("id", "asc");
        $query = $this->db->get();
        // print_r($query->result_array());
        //  die();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {

            return '';
        }
    }

    public function get_cashier_name($users_id) {

        $this->db->select('*');
        $this->db->from('users');
        $this->db->where("id = " . $users_id);
        $query = $this->db->get();
        // print_r($query->result_array());
        //  die();

        if ($query->num_rows() == 1) {
            return $query->row_array()['name'];
        } else {

            return '';
        }
    }

    public function report_orders($start_date = '', $end_date = '') {

        if (trim($start_date) != '' && trim($end_date) != '') {

            //  $this->db->where('active_order.created_at BETWEEN "' . $start_date . '" and "' . $end_date . '"');
            $tables_number = '';
            $created_at = '';
            $total_price = 0;
            $total_qty = 0;
            //    $this->db->select('*,SUM(qty) AS sum_qty');
            $this->db->select('*');
            $this->db->from('active_order');
            $this->db->where('paid_date !=', '0000-00-00 00:00:00');
            $this->db->where('created_at BETWEEN "' . $start_date . '" and "' . $end_date . '"');
            //  $this->db->where("active_order_id = " . $active_order_id);
            //  $this->db->group_by('menu_id');
            $this->db->order_by('id', 'ASC');

            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $row) {
                    // $total_qty = $total_qty + $row['qty'];
                    //  $total_price = $total_price + ($row['price'] * $row['qty']);
                    $char_order_tyoe = $row['tables_number'] == 0 ? '#' : 'T';
                    $arr[] = array(
                        'id' => $row['id'],
                        'order_id' => $char_order_tyoe . $row['id'],
                        // 'active_order_id' => $row['active_order_id'],
                        // 'menu_id' => $row['menu_id'],
                        //  'tables_number' => $tables_number,
                        //  'num_rows' => $this->_get_numrows_order_detail($active_order_id),
                        'order_date' => ($row['created_at']),
                        //'product' => $row['menu_name'],
                        //  'menu_type' => $this->_getMenuTypeEng($row['menu_type']),
                        // 'menu_type_eng' => $row['menu_type'],
                        // 'qty' => ($row['qty']),
                        //'finished_qty' => $row['finished_qty'],
                        //'price' => ($row['price']),
                        //'status' => $row['status'],
                        'total_price' => $this->get_total_price($row['id']),
                        'cashier_name' => $this->get_cashier_name($row['cashier_id']),
                            //   'total_qty' => $this->get_total_qty($active_order_id),
                            //    'last_update' => $this->get_last_update($active_order_id),
                            //  'topping_list' => $this->get_topping_order_detail($row['id']),
                    );
                }
//   $arr[] = [ 'total_qty' =>  $total_qty ];
// $arr[] = ['total_price' =>  $total_price];
                //echo "<pre>";
                // print_r($arr);
                // die();
                // // $arr2['data'] = $arr;
                // echo json_encode($arr2);
                return $arr;
            } else {
                return '';
            }
        }
    }

    public function report_orders_detail($active_order_id = '') {

        if (trim($active_order_id) != '') {

            //  $this->db->where('active_order.created_at BETWEEN "' . $start_date . '" and "' . $end_date . '"');
//            $tables_number = '';
//            $created_at = '';
//            $total_price = 0;
//            $total_qty = 0;
            //    $this->db->select('*,SUM(qty) AS sum_qty');
            $this->db->select('*,active_order.id as active_order_id');
          //  $this->db->select('active_order.id as active_order_id');
            $this->db->from('active_order');
            $this->db->where('active_order.paid_date !=', '0000-00-00 00:00:00');
            $this->db->where("active_order.id = " . $active_order_id);

            $this->db->join('active_order_detail', 'active_order.id = active_order_detail.active_order_id');

            //  $this->db->where('created_at BETWEEN "' . $start_date . '" and "' . $end_date . '"');
            //  $this->db->group_by('menu_id');
            // $this->db->order_by('id', 'ASC');

            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $row) {
                    // $total_qty = $total_qty + $row['qty'];
                    //  $total_price = $total_price + ($row['price'] * $row['qty']);
                    $char_order_tyoe = $row['tables_number'] == 0 ? '#' : 'T';
                    $arr[] = array(
                        'order_id' => $char_order_tyoe . $row['active_order_id'],
                      //  'active_order_id' => $row['active_order_id'],
                        'menu_id' => $row['menu_id'],
                        //  'tables_number' => $tables_number,
                        //  'num_rows' => $this->_get_numrows_order_detail($active_order_id),
                        'order_date' => ($row['created_at']),
                        'product' => $row['menu_name'],
                        'menu_type' => $this->_getMenuTypeEng($row['menu_type']),
                        // 'menu_type_eng' => $row['menu_type'],
                        'qty' => ($row['qty']),
                        //'finished_qty' => $row['finished_qty'],
                        'price' => ($row['price']),
                        'comment' => ($row['comment']),
                        //'status' => $row['status'],
                        'total_price' => $this->get_total_price($row['id']),
                        'cashier_name' => $this->get_cashier_name($row['cashier_id']),
                        //   'total_qty' => $this->get_total_qty($active_order_id),
                        //    'last_update' => $this->get_last_update($active_order_id),
                        'topping_list' => $this->get_topping_order_detail($row['id']),
                    );
                }
//   $arr[] = [ 'total_qty' =>  $total_qty ];
// $arr[] = ['total_price' =>  $total_price];
//                echo "<pre>";
//                print_r($arr);
//                die();
                // // $arr2['data'] = $arr;
                // echo json_encode($arr2);
                return $arr;
            } else {
                return '';
            }
        }
    }

    public function chart() {




        $sql_group_by = 'DATE(active_order.created_at)';
        $sql_format_date = '%Y-%m-%d';

        $this->db->select("DATE_FORMAT(active_order.created_at, '" . $sql_format_date . "') AS formatted_date ,active_order.created_at, SUM(active_order_detail.qty * active_order_detail.price ) as total ");
        $this->db->from('active_order');
        $this->db->where('paid_date !=', '0000-00-00 00:00:00');
        $this->db->join('active_order_detail', 'active_order.id = active_order_detail.active_order_id');

        // if (trim($start_date) != '' && trim($end_date) != '') {
        // $this->db->where('active_order.created_at BETWEEN "' . $start_date . '" and "' . $end_date . '"');
        $this->db->group_by($sql_group_by);


        $query = $this->db->get();
        //  echo json_encode();
        // $arr = [];
        foreach ($query->result_array() as $key => $row) {
            $arr[] = array(
                'name' => $row['formatted_date'],
                'data' => $row['total']
            );
        }
        // $ret = array($x, $y);
        // echo json_encode($ret);
        // echo "<pre>";
        //  print_r($arr);
        //  die();
        // }
        //  echo json_encode($arr);
        return json_encode($arr);
    }

    public function sales($report_type = '', $active_order_id = '', $reservation = '') {


        if ($this->input->post('btn_submit') == 'ค้นหา' || $report_type == 'Order') {

            $post_report_range = $this->input->post('report_range');

            $post_reservation = $this->input->post('reservation'); //ช่วงเวลา
            //ตามเดือน
            $post_daterange_month_start = $this->input->post('daterange_month_start');
            $post_daterange_month_end = $this->input->post('daterange_month_end');

            //ตามปี
            $post_daterange_year_start = $this->input->post('daterange_year_start');
            $post_daterange_year_end = $this->input->post('daterange_year_end');

            $start_date = '';
            $end_date = '';

            $sql_group_by = '';
            $sql_format_date = '';

            $show_str_date = '';

            if ($post_report_range == 'ตามช่วงเวลา') {

                $arrDate = explode(' - ', $post_reservation);
                $arrDateSt = explode('/', $arrDate[0]);
                $arrDateEnd = explode('/', $arrDate[1]);

                $start_date = $arrDateSt[2] . '-' . $arrDateSt[1] . '-' . $arrDateSt[0] . ' ' . ' 00:00:00';
                $end_date = $arrDateEnd[2] . '-' . $arrDateEnd[1] . '-' . $arrDateEnd[0] . ' ' . ' 23:59:59';

                $show_str_date = $post_reservation;

                //$this->db->group_by('DATE(active_order.created_at)');
                $sql_group_by = 'DATE(active_order.created_at)';
                $sql_format_date = '%Y-%m-%d';
            } else if ($post_report_range == 'ตามช่วงเดือน') {

                $start_date = $post_daterange_month_start . '-01 00:00:00';
                $end_date = $post_daterange_month_end . '-31 23:59:59';

                // $this->db->group_by('YEAR(active_order.created_at),MONTH(active_order.created_at)');
                $sql_group_by = 'YEAR(active_order.created_at),MONTH(active_order.created_at)';
                $sql_format_date = '%Y-%m';
                $show_str_date = $post_daterange_month_start . ' - ' . $post_daterange_month_end;
            } else if ($post_report_range == 'ตามช่วงปี') {

                $start_date = $post_daterange_year_start . '-01-01 00:00:00';
                $end_date = $post_daterange_year_end . '-12-31 23:59:59';

                $sql_format_date = '%Y';

                // $this->db->group_by('YEAR(active_order.created_at)');
                $sql_group_by = 'YEAR(active_order.created_at)';

                $show_str_date = $post_daterange_year_start . ' - ' . $post_daterange_year_end;
            }

            //   print_r($start_date);
            // print_r($end_date);


            if (($start_date != '' && $end_date != '') || $report_type == 'Order') {

                if ($this->input->post('report_type') == 'ยอดขาย') {


                    $this->db->select("DATE_FORMAT(active_order.created_at, '" . $sql_format_date . "') AS formatted_date ,active_order.created_at, SUM(active_order_detail.qty * active_order_detail.price ) as total ");
                    $this->db->from('active_order');
                    $this->db->where('paid_date !=', '0000-00-00 00:00:00');
                    $this->db->join('active_order_detail', 'active_order.id = active_order_detail.active_order_id');

                    //$arrDate = explode(' - ', $this->input->post('reservation'));
//                    $arrDateSt = explode('/', $arrDate[0]);
//                    $arrDateEnd = explode('/', $arrDate[1]);
//                    $start_date = $arrDateSt[2] . '-' . $arrDateSt[0] . '-' . $arrDateSt[1] . ' ' . ' 00:00:00';
//                    $end_date = $arrDateEnd[2] . '-' . $arrDateEnd[0] . '-' . $arrDateEnd[1] . ' ' . ' 23:59:59';


                    if (trim($start_date) != '' && trim($end_date) != '') {

                        $this->db->where('active_order.created_at BETWEEN "' . $start_date . '" and "' . $end_date . '"');
                        $this->db->group_by($sql_group_by);


                        $query = $this->db->get();
                        //  print_r($this->db->last_query());
                        // die();

                        $dataView = [
                            'res_active_order_sales' => $query->result_array(),
                            'type' => 'ยอดขาย',
                            'res_chart' => json_encode($query->result_array()),
                            'duration' => $show_str_date,
                            'report_range' => $post_report_range
                        ];

                        $data = array(
                            'content' => $this->load->view('report/sales', $dataView, true),
                        );
                        $this->load->view('main_layout', $data);
                    } else {
                        redirect('report/sales');
                    }
                }
                if ($this->input->post('report_type') == 'สินค้าขายดี') {


                    $this->db->select("active_order_detail.*,SUM(active_order_detail.qty * active_order_detail.price) as total_price");
                    $this->db->select("SUM(active_order_detail.qty) as total_qty");
                    $this->db->select("menu.product");
                    $this->db->from('active_order');
                    $this->db->where('paid_date !=', '0000-00-00 00:00:00');
                    $this->db->join('active_order_detail', 'active_order.id = active_order_detail.active_order_id');
                    $this->db->join('menu', 'active_order_detail.menu_id = menu.id');

                    //  $this->db->join('member', 'active_rent.member_id = member.id');
//                    $arrDate = explode(' - ', $this->input->post('reservation'));
//                    $arrDateSt = explode('/', $arrDate[0]);
//                    $arrDateEnd = explode('/', $arrDate[1]);
//                    $start_date = $arrDateSt[2] . '-' . $arrDateSt[0] . '-' . $arrDateSt[1] . ' ' . ' 00:00:00';
//                    $end_date = $arrDateEnd[2] . '-' . $arrDateEnd[0] . '-' . $arrDateEnd[1] . ' ' . ' 23:59:59';


                    if (trim($start_date) != '' && trim($end_date) != '') {

                        $this->db->where('active_order.created_at BETWEEN "' . $start_date . '" and "' . $end_date . '"');
                        $this->db->group_by('active_order_detail.menu_id');
                        $this->db->group_by('active_order_detail.menu_type');
                        $this->db->order_by('menu.product', 'ASC');
                        $this->db->order_by('active_order_detail.menu_type', 'ASC');

                        // echo $this->db->get_compiled_select();
                        // die();
                        $query = $this->db->get();
                        //  print_r($query->result_array());
                        //  die();

                        $dataView = [
                            'res_active_order_sales' => $query->result_array(),
                            'type' => 'สินค้าขายดี',
                            'res_chart' => ($query->result_array()),
                            'duration' => $show_str_date,
                            'report_range' => $post_report_range
                                //'result_active_payment' => $result_active_payment
                        ];

                        $data = array(
                            'content' => $this->load->view('report/sales', $dataView, true),
                        );
                        $this->load->view('main_layout', $data);
                    } else {
                        redirect('report/sales');
                    }
                }

                if ($this->input->post('report_type') == 'สินค้า') {


                    $this->db->select("active_order_detail.*,SUM(active_order_detail.qty * active_order_detail.price) as total_price");
                    $this->db->select("SUM(active_order_detail.qty) as total_qty");
                    $this->db->select("menu.product");
                    $this->db->from('active_order');
                    $this->db->where('paid_date !=', '0000-00-00 00:00:00');
                    $this->db->join('active_order_detail', 'active_order.id = active_order_detail.active_order_id');
                    $this->db->join('menu', 'active_order_detail.menu_id = menu.id');

                    //  $this->db->join('member', 'active_rent.member_id = member.id');
//                    $arrDate = explode(' - ', $this->input->post('reservation'));
//                    $arrDateSt = explode('/', $arrDate[0]);
//                    $arrDateEnd = explode('/', $arrDate[1]);
//                    $start_date = $arrDateSt[2] . '-' . $arrDateSt[0] . '-' . $arrDateSt[1] . ' ' . ' 00:00:00';
//                    $end_date = $arrDateEnd[2] . '-' . $arrDateEnd[0] . '-' . $arrDateEnd[1] . ' ' . ' 23:59:59';


                    if (trim($start_date) != '' && trim($end_date) != '') {

                        $this->db->where('active_order.created_at BETWEEN "' . $start_date . '" and "' . $end_date . '"');
                        $this->db->group_by('active_order_detail.menu_id');
                        $this->db->group_by('active_order_detail.menu_type');


                        $this->db->order_by("SUM(active_order_detail.qty)", "DESC");
                        $this->db->order_by('menu.product', 'ASC');
                        $this->db->order_by('active_order_detail.menu_type', 'ASC');
                        // echo $this->db->get_compiled_select();
                        // die();
                        $query = $this->db->get();
                        //  print_r($query->result_array());
                        //  die();

                        $dataView = [
                            'res_active_order_sales' => $query->result_array(),
                            'type' => 'สินค้าขายดี'
                                //'result_active_payment' => $result_active_payment
                        ];

                        $data = array(
                            'content' => $this->load->view('report/sales', $dataView, true),
                        );
                        $this->load->view('main_layout', $data);
                    } else {
                        redirect('report/sales');
                    }
                }

                if ($this->input->post('report_type') == 'Topping ขายดี') {


                    $this->db->select("active_order_detail_topping.topping");
                    $this->db->select("COUNT(active_order_detail_topping.topping) AS cnt_topping");
                    $this->db->select("SUM(active_order_detail_topping.price) AS total");

                    $this->db->from('active_order');
                    $this->db->where('paid_date !=', '0000-00-00 00:00:00');
                    $this->db->join('active_order_detail', 'active_order.id = active_order_detail.active_order_id');

                    $this->db->join('active_order_detail_topping', 'active_order_detail.id  = active_order_detail_topping.active_order_detail_id');

//                    $arrDate = explode(' - ', $this->input->post('reservation'));
//                    $arrDateSt = explode('/', $arrDate[0]);
//                    $arrDateEnd = explode('/', $arrDate[1]);
//                    $start_date = $arrDateSt[2] . '-' . $arrDateSt[0] . '-' . $arrDateSt[1] . ' ' . ' 00:00:00';
//                    $end_date = $arrDateEnd[2] . '-' . $arrDateEnd[0] . '-' . $arrDateEnd[1] . ' ' . ' 23:59:59';


                    if (trim($start_date) != '' && trim($end_date) != '') {

                        $this->db->where('active_order.created_at BETWEEN "' . $start_date . '" and "' . $end_date . '"');


                        $this->db->group_by('active_order_detail_topping.topping');
                        $this->db->order_by('cnt_topping', 'DESC');


                        // echo $this->db->get_compiled_select();
                        // die();

                        $query = $this->db->get();
                        //  print_r($query->result_array());
                        //  die();


                        $dataView = [
                            'res_active_order_sales' => $query->result_array(),
                            'type' => 'Topping ขายดี',
                            'res_chart' => ($query->result_array()),
                            'duration' => $show_str_date,
                            'report_range' => $post_report_range
                                //'result_active_payment' => $result_active_payment
                        ];

                        $data = array(
                            'content' => $this->load->view('report/sales', $dataView, true),
                        );
                        $this->load->view('main_layout', $data);
                    } else {
                        redirect('report/sales');
                    }
                }

                if ($this->input->post('report_type') == 'Order' || $report_type == 'Order') {

                    if ($report_type == 'Order' || $active_order_id != '') {
                        //Detail order
                        $arr = $this->report_orders_detail($active_order_id);
                       // print_r($arr);
                      //  die();
                        $dataView = [
                            'res_active_order_sales' => $arr,
                            'type' => 'Order',
                            'detail' => 'OrderDetail',
                            //   'reservation' => $reservation,
                            'duration' => $show_str_date,
                            'report_range' => $post_report_range

                                //'result_active_payment' => $result_active_payment
                        ];


                        $data = array(
                            'content' => $this->load->view('report/sales', $dataView, true),
                        );

                        $this->load->view('main_layout', $data);
                    } else {
                        // order

                        $this->session->set_userdata('reservation', $this->input->post('reservation'));

                        if (trim($start_date) != '' && trim($end_date) != '') {

                            $arr = $this->report_orders($start_date, $end_date);


                            $dataView = [
                                'res_active_order_sales' => $arr,
                                'type' => 'Order',
                                'detail' => '',
                                'duration' => $show_str_date,
                                'report_range' => $post_report_range
                                    //'result_active_payment' => $result_active_payment
                            ];


                            $data = array(
                                'content' => $this->load->view('report/sales', $dataView, true),
                            );

                            $this->load->view('main_layout', $data);
                        } else {
                            redirect('report/sales');
                        }
                    }
                }
            } else {

                $this->db->select("DATE_FORMAT(active_order.created_at, '%Y-%m-%d') AS formatted_date ,active_order.created_at, SUM(active_order_detail.qty * active_order_detail.price ) as total ");
                $this->db->from('active_order');
                $this->db->where('paid_date !=', '0000-00-00 00:00:00');
                $this->db->join('active_order_detail', 'active_order.id = active_order_detail.active_order_id');
                $this->db->group_by('DATE(active_order.created_at)');

                $query = $this->db->get();

                $dataView = [
                    'res_active_order_sales' => $query->result_array(),
                    'type' => '',
                    'report_range' => ''
                ];

                $data = array(
                    'content' => $this->load->view('report/sales', $dataView, true),
                );
                $this->load->view('main_layout', $data);
            }
        } else {



            $this->db->select("DATE_FORMAT(active_order.created_at, '%Y-%m-%d') AS formatted_date ,active_order.created_at, SUM(active_order_detail.qty * active_order_detail.price ) as total ");
            $this->db->from('active_order');
            $this->db->where('paid_date !=', '0000-00-00 00:00:00');
            $this->db->join('active_order_detail', 'active_order.id = active_order_detail.active_order_id');
            $this->db->group_by('DATE(active_order.created_at)');

            $query = $this->db->get();

            $dataView = [
                'res_active_order_sales' => $query->result_array(),
                'type' => '',
                'report_range' => ''
            ];

            $data = array(
                'content' => $this->load->view('report/sales', $dataView, true),
            );
            $this->load->view('main_layout', $data);
        }
    }

}
