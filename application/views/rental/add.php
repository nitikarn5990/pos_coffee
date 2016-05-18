

<section class="content-header">
    <h1>
        เพิ่มข้อมูลสัญญาเช่า

    </h1>
    <ol class="breadcrumb hidden">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
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

        <!--End Alert -->
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">ข้อมูล</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" action="<?= base_url('rental/add') ?>" method="POST">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">ชำระประจำเดือน</label>
                            <div class='col-md-5' id="month_payment">
                                <div id="datepicker" data-date="12/03/2012"></div>
                                <input type="hidden" id="my_hidden_input" name="pay_monthly">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">เลือกผู้เช่า</label>
                            <div class="col-sm-8">
                                <input type="text" readonly="" value="<?php echo set_value('member_id'); ?>" class="form-control" id="member_id" name="member_id" data-validation="required" >
                            </div>
                            <div class="col-md-2">
                                <a href="javascript:;" onclick="showDialog('<?= base_url() ?>member/member_list')" class="btn btn-sm btn-primary">เลือก</a>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">เลือกห้องว่าง</label>
                            <div class="col-sm-8">
                                <input type="text" readonly="" value="" class="form-control" id="room_id" name="room_id" data-validation="required" >

                            </div>
                            <div class="col-md-2">
                                <a href="javascript:;" onclick="showDialog('<?= base_url() ?>room/room_list')" class="btn btn-sm btn-primary">เลือก</a>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Internet</label>
                            <div class="col-sm-8">
                                <input type="checkbox" id="on-off-switch" class="form-control" value="on" name="internet">
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">เลขมิเตอร์ไฟฟ้า</label>
                            <div class="col-sm-8">
                                <input type="text" id="meter_electric" class="form-control" value="" name="meter_electric" data-validation="number">
                            </div>

                        </div>
                         <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">เลขมิเตอร์น้ำ</label>
                            <div class="col-sm-8">
                                <input type="text" id="meter_water" class="form-control" value="" name="meter_water" data-validation="number">
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">รวมเงินทั้งสิ้น</label>
                            <div class="col-sm-8">
                                <div class="col-xs-12">
                                    <p class="lead">ยอดเงินที่ต้องชำระ</p>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr class="bg-warning">
                                                    <th style="width:50%">ค่ามัดจำ :</th>
                                                    <td><input type="text" value="<?= $deposit ?>" class="" id="deposit" readonly data-validation="required" >   บาท</td>
                                                </tr>
                                                <tr class="bg-warning">
                                                    <th>ค่าห้อง :</th>
                                                    <td><input type="text" id="price_per_month" readonly data-validation="required" >   บาท</td>
                                                </tr>
                                                <tr class="bg-warning">
                                                    <th>ค่า Internet :</th>
                                                    <td><input type="text" id="internet" readonly data-validation="">   บาท</td>
                                            <input type="hidden" id="internet2" value="<?=$this->db->get_where('internet', array('id' => 1))->row_array()['price'];?>"> 


                                            </tr>
                                            <tr class="bg-info">
                                                <th>รวมทั้งสิ้น :</th>
                                                <td><input type="text" id="total_amt" readonly data-validation="required" >   บาท</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">รับเงิน</label>
                            <div class="col-sm-8">
                                <div class="col-xs-12">
                                    <p class="lead">รับเงินมา</p>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr class="bg-warning">
                                                    <th style="width:50%">ยอดเงิน :</th>
                                                    <td><input type="text" name="total_paid" data-validation="required,number" >   บาท</td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">หมายเหตุ</label>
                            <div class="col-sm-8">

                                <textarea name="comment" rows="4" class="form-control"><?php echo set_value('comment'); ?></textarea>
                            </div>

                        </div>
                        <div class="box-footer">
                            <button type="submit" name="btn_submit" value="บันทึก" class="btn btn-instagram pull-right margin-r-5">บันทึก</button>&nbsp;&nbsp;

                        </div><!-- /.box-footer -->
                </form>
            </div><!-- /.box -->

        </div><!--/.col (right) -->
    </div>
</section><!-- /.content -->

<script> $.validate();</script>
<script>
    function showDialog(uri) {

        var sList = PopupCenter(uri, '', "900", "400");

    }

    function PopupCenter(url, title, w, h) {
        // Fixes dual-screen position Most browsers      Firefox
        var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
        var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

        width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

        var left = ((width / 2) - (w / 2)) + dualScreenLeft;
        var top = ((height / 2) - (h / 2)) + dualScreenTop;
        var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

        // Puts focus on the newWindow
        if (window.focus) {
            newWindow.focus();
        }
    }



</script>


<script>
    new DG.OnOffSwitch({
        el: '#on-off-switch',
        textOn: 'ใช้',
        textOff: 'ไม่ใช้',
        listener: function (name, checked) {

            //  document.getElementById("ELEMENT").innerHTML = "Switch " + name + " changed value to " + checked;
            if (checked) {
                var internet = $('#internet2').val();
                var internet2 = $('#internet').val(internet);

                total_amt();

            } else {

                $('#internet').val('');

                total_amt();
            }
        }
    });
    function total_amt() {
        var internet = $('#internet').val();
        var price_per_month = $('#price_per_month').val() == '' ? '0' : $('#price_per_month').val();
        var deposit = $('#deposit').val() == '' ? '0' : $('#deposit').val();
        var internet = $('#internet').val() == '' ? '0' : $('#internet').val();

        var total_amt = parseInt(price_per_month) + parseInt(deposit) + parseInt(internet);
        $('#total_amt').val(total_amt);
    }
</script>
<style>
    #month_payment{
        background: rgba(158, 158, 158, 0.09);
        border-radius: 5px;
        d: red;
        border: 1px solid rgba(13, 28, 10, 0.07);
    }
</style>

<script>

    $(document).ready(function () {

        $('#datepicker').datepicker({
            format: 'yyyy-mm',
            todayHighlight: true,
            language: 'th',
            minViewMode: 'months',
        });
        $('#datepicker').on("changeDate", function () {
            $('#my_hidden_input').val(
                    $('#datepicker').datepicker('getFormattedDate')
                    );
        });
        $('#my_hidden_input').val(
                $('#datepicker').datepicker('getFormattedDate')
                );
    });


</script>
