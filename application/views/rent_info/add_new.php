<form class="form-horizontal" action="<?= base_url('rent_info/add_new/'.$id) ?>" method="POST">
    <input type="hidden" name="pay_monthly" value="<?=$rent_next_month?>">
        <input type="hidden" name="rental_id" value="<?=$result_rental['id']?>">
          <input type="hidden" name="room_id" value="<?=$result_room['id']?>">
            <input type="hidden" name="member_id" value="<?=$result_member['id']?>">
    <section class="content-header">
        <h1 class=" bg-warning">
            เพิ่มการเช่าห้อง เดือน <?= $rent_next_month?>
   

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
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"> ข้อมูลการเช่าของเลขที่สัญญา # <?= $id ?></h3>
                    </div><!-- /.box-header -->

                    <!-- form start -->
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">ห้องที่</label>

                            <div class="col-sm-10">
                                <input type="text" readonly="" value="<?= $result_room['number_room'] ?>" class="form-control">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">วันที่ทำสัญญา</label>
                            <div class="col-sm-8">
                                <input type="text" readonly="" value="<?= ShowDateThTime($result_rental['open_rental_date']) ?>" class="form-control">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">ชื่อผู้เช่า</label>
                            <div class="col-sm-8">
                                <input type="text" readonly="" value="<?= $result_member['customer_firstname'] . ' ' . $result_member['customer_lastname'] ?>" class="form-control">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">เบอร์โทร</label>
                            <div class="col-sm-8">
                                <input type="text" readonly="" value="<?= $result_member['customer_tel'] ?>" class="form-control">

                            </div>
                        </div>
                    </div><!-- /.box -->

                </div><!--/.col (right) -->
            </div>
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">ข้อมูล</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->

                    <div class="box-body">
                   
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Internet</label>
                            <div class="col-sm-8">
                                <input type="checkbox" id="on-off-switch" class="form-control" value="on">
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
                                                    <th>ค่าห้อง :</th>
                                                    <td><input type="text" class="text-right" id="price_per_month" name="price_per_month" readonly data-validation="required" value="<?=$result_room['price_per_month']?>">   บาท</td>
                                                </tr>
                                                <tr class="bg-warning">
                                                    <th>ค่า Internet :</th>
                                                    <td><input type="text" class="text-right" id="internet" name="internet" value="0" readonly data-validation="">   บาท</td>
                                            <input type="hidden" id="internet2" value="<?= $this->db->get_where('internet', array('id' => 1))->row_array()['price'] ?>"> 

                                            </tr>
                                            <tr class="bg-info">
                                                <th>รวมทั้งสิ้น :</th>
                                                <td><input type="text" class="text-right" id="total_amt" readonly data-validation="required" value="<?=$result_room['price_per_month']?>">   บาท</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div><!-- /.box-body -->
                       <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">การชำระเงิน</label>
                            <div class="col-sm-8">
                                <input type="text" value="" placeholder="จำนวนเงินที่รับมา" data-validation=number name="receive_money" class="form-control">

                            </div>
                        </div>
                        <div class="form-group hidden">
                            <label for="inputEmail3" class="col-sm-2 control-label">หมายเหตุ</label>
                            <div class="col-sm-8">

                                <textarea name="comment" rows="4" class="form-control"><?php echo set_value('comment'); ?></textarea>
                            </div>

                        </div>
                        <div class="box-footer">
                            <button type="submit" name="btn_submit" value="บันทึก" class="btn btn-instagram pull-right margin-r-5">บันทึก</button>&nbsp;&nbsp;

                        </div><!-- /.box-footer -->

                    </div><!-- /.box -->


                </div><!--/.col (right) -->
            </div>

        </div>

    </section><!-- /.content -->
    <!-- Validate -->
</form>
<script src="<?= base_url() ?>assets/plugins/validate/jquery.form-validator.min.js"></script>
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

<!--switch plugin-->
<script src="<?= base_url() ?>assets/plugins/switch/js/on-off-switch.js"></script>
<script src="<?= base_url() ?>assets/plugins/switch/js/on-off-switch-onload.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/switch/css/on-off-switch.css">
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

                $('#internet').val('0');

                total_amt();
            }
        }
    });
    function total_amt() {
        var internet = $('#internet').val();
        var price_per_month = $('#price_per_month').val() == '' ? '0' : $('#price_per_month').val();
     //   var deposit = $('#deposit').val() == '' ? '0' : $('#deposit').val();
        var internet = $('#internet').val() == '' ? '0' : $('#internet').val();

        var total_amt = parseInt(price_per_month)  + parseInt(internet);
        $('#total_amt').val(total_amt);
    }
</script>