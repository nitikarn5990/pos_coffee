<!-- Content Header (Page header) -->

<section class="content-header">
    <div class="row">


        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title"> ข้อมูลการเช่าของเลขที่สัญญา # <?= $id ?></h3>
                </div>
                <div class="box-body">
                    <!-- Color Picker -->
                    <div class="form-group">
                        <label>วันที่ทำสัญญา</label>
                        <input type="text" class="form-control my-colorpicker1 colorpicker-element" value="<?= isset($open_rental_date) ? ShowDateThTime($open_rental_date) : '' ?>" readonly="">
                    </div><!-- /.form group -->
                    <div class="form-group">
                        <label>ชื่อผู้เช่า</label>
                        <input type="text" class="form-control my-colorpicker1 colorpicker-element" value="<?= isset($member_name) ? $member_name : '' ?>" readonly="">
                    </div><!-- /.form group -->
                    <div class="form-group">
                        <label>เบอร์ติดต่อ</label>
                        <input type="text" class="form-control my-colorpicker1 colorpicker-element" readonly="" value="<?= isset($tel) ? $tel : '' ?>">
                    </div><!-- /.form group -->
                </div><!-- /.box-body -->
            </div>

        </div>

    </div>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!--Alert -->
            <?php if (validation_errors()) { ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                    <?php echo validation_errors(); ?>
                </div>
            <?php } ?>

            <?php if ($this->session->flashdata('message_success')) { ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('message_success') ?>
                </div>
            <?php } ?>

            <?php if ($this->session->flashdata('message_error')) { ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('message_error') ?>
                </div>
            <?php } ?>



        </div>
        <div class="col-md-12">
            <form action="<?= base_url() ?>rent_info/delete" method="POST">
                <div class="box">
                    <div class="box-header">
                        <div class="col-md-12">
                            <a href="<?= base_url('rent_info/add_new/' . $id) ?>" class="btn btn-success btn-flat" name="btn_submit" value="เพิ่มข้อมูล"><i class="fa fa-plus"></i> เพิ่มข้อมูลการเช่า</a>

                        </div>
                    </div>
                    <div class="box-body">
                        <div class="col-md-12">
                            <table id="example" class="ui celled table" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>ประจำเดือน</th>
                                        <th>หมายเลขห้อง</th>

                                        <th>สถานะ</th>
                                        <th>แก้ไขล่าสุด</th>

                                        <th>ตัวเลือก</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>ประจำเดือน</th>
                                        <th>หมายเลขห้อง</th>

                                        <th>สถานะ</th>
                                        <th>แก้ไขล่าสุด</th>

                                        <th>ตัวเลือก</th>
                                    </tr>
                                </tfoot>
                                <tbody>

                                    <?php if (isset($result)) { ?>
                                        <?php foreach ($result as $rows) { ?>
                                            <?php
                                            //  $limit_day = $rows['pay_monthly'] . '-' . $this->db->get_where('pay_limit_date', array('id' => 1))->row_array()['day'];
                                            //   $today_dt = new DateTime($today);
                                            //   $expire_dt = new DateTime($limit_day);


                                            $today = date("Y-m-d");
                                            $result_active_rent2 = $rows['pay_monthly'];
                                            $month_next_pay = Date("Y-m-" . $this->db->get_where('pay_limit_date', array('id' => 1))->row_array()['day'], strtotime("$result_active_rent2 +1 Month"));

                                            $result_active_payment = $this->db->get_where('active_payment', array('active_rent_id' => $rows['id']))->result_array();

                                            //หายอดเงินที่ชำระมาแล้ว
                                            $total_paid = 0;
                                            foreach ($result_active_payment as $key => $row) {

                                                $total_paid = $total_paid + $row['total_paid'];
                                            }


                                            $water_rate = $this->db->get_where('water_rate', array('id' => 1))->row_array()['rate_price'];
                                            $electric_rate = $this->db->get_where('electric_rate', array('id' => 1))->row_array()['rate_price'];


                                            //หา เลขมิเตอร์เดือนที่แล้ว
                                            $result_active_rent_last_count = $this->db->get_where('active_rent', array('rental_id' => $rows['rental_id'], 'pay_monthly' => Add_month('-1', $rows['pay_monthly'])))
                                                    ->num_rows();
                                            
                                            if ($result_active_rent_last_count == 0) {
                                    
                                                $price_el = ( $rows['meter_electric_last'] - $rows['meter_electric'] ) * $electric_rate;
                                                $price_water = ( $rows['meter_water_last'] -  $rows['meter_water'] ) * $water_rate;
                                                
                                            } else {
                                                 $result_active_rent_before = $this->db->get_where('active_rent', array('rental_id' => $rows['rental_id'], 'pay_monthly' => Add_month('-1', $rows['pay_monthly'])))
                                                    ->row_array();
                                                $price_el = ( $rows['meter_electric_last'] - $result_active_rent_before['meter_electric_last'] ) * $electric_rate;
                                                $price_water = ( $rows['meter_water_last'] - $result_active_rent_before['meter_water_last'] ) * $water_rate;
                                            }
                    
                                            //  if ($rows['id_next_month'] > 0) {
                                            //ค่าเน็ต
                                          //  $result_internet = $result_active_rent['internet'];
                                            //       $still_pay = ($rows['internet'] + $rows['deposit'] + $rows['price_per_month'] + $price_el + $price_water) - $total_paid;
                                            //   } else {
                                            $still_pay = ($rows['internet'] + $rows['deposit'] + $rows['price_per_month'] + $price_el + $price_water) - $total_paid;
                                            // }

                                            if ($rows['meter_electric_last'] == 0 && $rows['meter_water_last'] == 0) {
                                                $txt_msg = 'รอชำระเงิน';
                                                $bg = 'bg-warning';
                                            } else {

                                              //  if ($month_next_pay < $today) { //ถ้าเกินวันกำหนดชำระเงิน
                                                    if ($still_pay > 0) { //ถ้าชำระไม่หมด
                                                        $txt_msg = 'ค้างชำระ';
                                                        $bg = 'bg-danger';
                                                    } else {
                                                        $txt_msg = 'ชำระแล้ว';
                                                        $bg = 'bg-success';
                                                    }
                                                //} else {
                                                    //อยุ่ในเวลากำหนด
//                                                    if ($still_pay > 0) { //ถ้าชำระไม่หมด
//                                                        $txt_msg = 'ค้างชำระ';
//                                                        $bg = 'bg-danger';
//                                                    } else {
//                                                        $txt_msg = 'ชำระแล้ว';
//                                                        $bg = 'bg-success';
//                                                    }
                                               // }
                                            }
                                            ?>
                                            <tr class="<?= $bg ?>">
                                                <th><?= $rows['id'] ?></th>
                                                <th><?= $rows['pay_monthly'] ?></th>
                                                <td><?= $this->db->get_where('room', array('id' => $rows['room_id']))->row_array()['number_room'] ?></td>

                                                <td>
                                                    <?= $txt_msg ?>
                                                </td>
                                                <td><?= ShowDateThTime($rows['updated_at']) ?></td>

                                                <td>
                                                    <a href="<?= base_url() ?>rent_info/edit/<?= $rows['rental_id'] . '/' . $rows['id'] ?>"  id="active_rent_id_<?= $rows['id'] ?>" class="btn btn-sm btn-dropbox">ดูการชำระเงิน / ชำระเงิน</a>
                                                    <?php if ($active_rent_min_id != $rows['id']) { ?>
                                                        <a href="javascript:void(0)" onclick="if (confirm('คุณต้องการลบข้อมูลนี้หรือใม่?') == true) {
                                                                    document.location.href = '<?= base_url() ?>rent_info/delete_active_rent/<?= $rows['id'] ?>/<?= $rows['rental_id'] ?>'
                                                                            }" class="btn btn-sm btn-danger">ลบ</a>
                                                       <?php } ?>                        
                                                </td>

                                            </tr>
                                        <?php } ?>
                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div><!-- /.col -->

        <div  class="row">
            <div class="col-md-12" id="paid_list">

            </div>


        </div>


    </div><!-- /.row -->
</section><!-- /.content -->



<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatable2/semantic.min.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatable2/dataTables.semanticui.min.css">

<script src="<?= base_url() ?>assets/plugins/datatable2/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatable2/dataTables.semanticui.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatable2/semantic.min.js"></script>



<script>
                                                            $(document).ready(function () {
                                                                $('#example').DataTable();

                                                                $("#chkboxall").click(function (e) {
                                                                    $('.chkbox').prop('checked', this.checked);
                                                                });



                                                                $('#active_rent_id_<?= $active_rent_id ?>').trigger('click');

                                                            });

</script>
<script>

    function load_paid_list(id) {
        // $.blockUI({ message: '<h1><img src="busy.gif" /> Just a moment...</h1>' });
        $.ajax({
            method: "POST",
            url: "<?= base_url() ?>rent_info/paid/" + id,
            data: {
                active_rent_id: id,
            },
            beforeSend: function () {
                $.blockUI({message: '<h2 style=padding:10px;>กำลังโหลด...</h2>'});
            },
            complete: function () {
                $.unblockUI();
            }

        }).done(function (msg) {

            $('#paid_list').html(msg);
            $.unblockUI();
            // $('body').scrollTo('#paid_list');
            $.extend($.scrollTo.defaults, {
                axis: 'y',
                duration: 800
            });
            $.scrollTo('#paid_list');

        });
    }


</script>
