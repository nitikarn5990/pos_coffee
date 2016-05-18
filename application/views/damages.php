<!-- Content Header (Page header) -->

<section class="content-header">
    <div class="row">

        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title"> คำนวณค่าใช้จ่ายและสิ่งของเสียหายภายในห้องพัก </h3>
                </div>
                <div class="box-body">

                </div><!-- /.box-body -->
            </div>

        </div>
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title"> ข้อมูลสัญญาเลขที่# <?= $result_rental['id'] ?></h3>
                </div>
                <div class="box-body">
                    <!-- Color Picker -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">วันที่ทำสัญญา</label>
                        <div class="col-sm-10"> 
                            <input type="text" class="form-control my-colorpicker1 colorpicker-element" value="<?= isset($result_rental['open_rental_date']) ? ShowDateThTime($result_rental['open_rental_date']) : '' ?>" readonly="">

                        </div><!-- /.form group -->
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">วันที่ปิดสัญญา</label>
                        <div class="col-sm-10"> 
                            <input type="text" class="form-control my-colorpicker1 colorpicker-element" value="<?= isset($result_rental['close_rental_date']) ? ShowDateThTime($result_rental['close_rental_date']) : '' ?>" readonly="">
                        </div>
                    </div><!-- /.form group -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">ชื่อผู้เช่า</label>
                        <div class="col-sm-10"> 
                            <input type="text" class="form-control my-colorpicker1 colorpicker-element" value="<?= $res_member['customer_firstname'] . ' ' . $res_member['customer_lastname'] ?>" readonly="">

                        </div><!-- /.form group -->
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">เบอร์ติดต่อ</label>
                        <div class="col-sm-10"> 
                            <input type="text" class="form-control my-colorpicker1 colorpicker-element" readonly="" value="<?= $res_member['customer_tel'] ?>">
                        </div>
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

        <form action="<?= base_url() ?>damages/save" method="POST">
            <input type="hidden" name="rental_id" value="<?= $result_rental['id'] ?>">
            <div class="col-md-12">

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><i class="fa fa-plus"></i> เพิ่มรายการที่เสียหาย </h3>
                    </div>
                    <div class="box-body">
                        <div class="col-md-12">
                    
                            <button id="btnAdd" class="btn btn-success" type="button"><i class="fa fa-plus"></i> เพิ่ม</button>

                            <div id="TextBoxContainer">
                                <!--Textboxes will be added here -->
                            </div>


                        </div>

                    </div>
                    <div class="box-footer">

                        <button type="submit" name="btn_submit" value="บันทึก" class="btn btn-instagram margin-r-5">บันทึก</button>&nbsp;&nbsp;

                    </div>
                </div>

            </div><!-- /.col -->
        </form>
        <div class="col-md-12">
            <form action="<?= base_url() ?>rent_info/delete" method="POST">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title"><i class="fa fa-list"></i> สรุปรายการค่าใช้จ่ายและสิ่งของเสียหายในห้องพัก</h3>
                    </div>
                    <div class="box-body">
                        <div class="col-md-12">
                            <div class="table-responsive" id="meter_input">
                                <table class="table">
                                    <thead>
                                        <th>รายการที่</th>
                                        <th>รายละเอียด</th>
                                        <th>จำนวนเงิน</th>
                                         <th>ตัวเลือก</th>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $num_rec_damages = $this->db->get_where('damages', array('rental_id' => $result_rental['id']))->num_rows();

                                         $total_dm = 0;
                                        if ($num_rec_damages > 0){ 
                                            $res_damages = $this->db->get_where('damages', array('rental_id' => $result_rental['id']))->result_array();

                                            foreach ($res_damages as $key => $value) {
                                                $total_dm = $total_dm + $value['price'];
                                                ?>
                                                <tr class="bg-warning">
                                                    <th><?= $key + 1?></th>
                                                    <td><?= $value['detail'] ?></td>
                                                    <td><?= $value['price'] ?></td>
                                                    <td><a href="<?=base_url()?>damages/delete/<?=$value['rental_id'] .'/'.$value['id']?>" onclick="return confirm('คุณแน่ใจที่จะลบ?')" class="btn btn-danger"><i class="fa fa-trash"></i> ลบ</a></td>
                                                </tr>
                                            <?php } ?> 

                                        <?php } ?>

                                        <tr class="bg-danger">
                                            <th></th>
                                            <td>รวมค่าเสียหาย</td>
                                            <td colspan="2"><?= $total_dm ?></td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div><!-- /.col -->

        <div class="col-md-12">
            <form action="<?= base_url() ?>rent_info/delete" method="POST">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title"><i class="fa fa-money"></i> สรุปยอดคงเหลือ</h3>
                        <h3 class="box-title pull-right"><a href="<?=base_url()?>bill/bill_damages/<?=$result_rental['id']?>" target="_blank" class="btn btn-facebook"><i class="fa fa-print"></i>  พิมพ์ใบเสร็จ</a></h3>
                    </div>
                    <div class="box-body">
                        <div class="col-md-12">
                            <div class="table-responsive" id="meter_input">
                                <table class="table">
                                    <thead>
                                    <th>ค่ามัดจำ</th>
                                    <th>ค่าเสียหายทั้งสิ้น</th>
                                    <th>จำนวนเงินคงเหลือ</th>
                                    </thead>
                                    <tbody>
                                        <tr class="bg-info">
                                            <th>
                                                <?php
                                                $first_rec_active_rent = $this->db->order_by("id", "ASC")->get_where('active_rent', array('rental_id' => $result_rental['id']), 1)->row_array();

                                                echo $first_rec_active_rent['deposit'];
                                                ?>
                                            </th>
                                            <td><?= $total_dm ?></td>
                                            <td><?= $first_rec_active_rent['deposit'] - $total_dm ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

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



<script type="text/javascript">
    var k = 0;
    $(function () {

        $("#btnAdd").bind("click", function () {
            k = k + 1;
            var div = $("<div />");
            div.html(GetDynamicTextBox(""));
            $("#TextBoxContainer").append(div);
        });
        
         $("#btnAdd").trigger('click');
        $("#btnGet").bind("click", function () {
            var values = "";
            $("input[name=DynamicTextBox]").each(function () {
                values += $(this).val() + "\n";
            });
            alert(values);
        });
        $("body").on("click", ".remove", function () {

            $(this).closest("#list-dm").remove();
        });
    });
    function GetDynamicTextBox(value) {
        if(k === 1){
                    return  '<div id="list-dm" class="row"><div class="col-md-2">รายการเสียหาย</div>' +
                '<div class="col-md-6"><input name ="detail[]" type="text" value = "' + value + '" class="form-control" placeholder="รายการเสียหาย" data-validation="required"/></div>' +
                '<div class="col-md-2"><input name ="price[]" type="text" value = "' + value + '" class="form-control" placeholder="ราคา" data-validation="required,number"/></div>' +
                '<div class="col-md-2"></span></div>';
        }else{
                    return  '<div id="list-dm" class="row"><div class="col-md-2">รายการเสียหาย</div>' +
                '<div class="col-md-6"><input name ="detail[]" type="text" value = "' + value + '" class="form-control" placeholder="รายการเสียหาย" data-validation="required"/></div>' +
                '<div class="col-md-2"><input name ="price[]" type="text" value = "' + value + '" class="form-control" placeholder="ราคา" data-validation="required,number"/></div>' +
                '<div class="col-md-2"><input type="button" class="btn btn-danger btn-flat remove" value="ลบ" /></span></div>';
        }

    }
</script>
