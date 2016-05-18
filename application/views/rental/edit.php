 
<section class="content-header">
    <h1>
        แก้ไขข้อมูลสัญญาเช่า

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
                <form class="form-horizontal" action="<?= base_url('rental/edit/' . $id) ?>" method="POST">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">เลขที่สัญญา</label>
                            <div class="col-sm-8">
                                <input type="text" readonly="" value="<?php echo $id; ?>" class="form-control" name="id" data-validation="required" >
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">วันที่เปิดสัญญา</label>
                            <div class="col-sm-8">
                                <input type="text" readonly="" value="<?php echo ShowDateThTime($open_rental_date); ?>" class="form-control" name="" data-validation="" >
                            </div>

                        </div>
                        <?php if ($status == 'ปิดสัญญา'): ?>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">วันที่ปิดสัญญา</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly="" value="<?php echo ShowDateThTime($close_rental_date) == ''? '-': ShowDateThTime($close_rental_date) ; ?>" class="form-control" name="" data-validation="" >
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">ชื่อผู้เช่า</label>
                            <div class="col-sm-8">
                                <input type="text" readonly="" value="<?php echo $member_id; ?>" class="form-control" id="member_id" name="member_id" data-validation="required" >
                            </div>
                            <div class="col-md-2 hidden">
                                <a href="javascript:;" onclick="showDialog('<?= base_url() ?>member/member_list')" class="btn btn-sm btn-primary">เลือก</a>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">หมายเลขห้อง</label>
                            <div class="col-sm-8">
                                <input type="text" readonly="" value="<?php echo $room_id; ?>" class="form-control" id="room_id" name="room_id" data-validation="required" >
                            </div>
                            <div class="col-md-2 hidden">
                                <a href="javascript:;" onclick="showDialog('<?= base_url() ?>room/room_list')" class="btn btn-sm btn-primary">เลือก</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">หมายเหตุ</label>
                            <div class="col-sm-8">

                                <textarea name="comment" rows="4" class="form-control"><?php echo $comment; ?></textarea>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">สถานะ</label>
                            <div class="col-sm-8">

                                <input type="checkbox" id="on-off-switch"  value="on" name="status" <?= $status == 'เปิดสัญญา' ? 'checked' : '' ?>>
                            </div>

                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">

                        <button type="submit" name="btn_submit" value="บันทึก" class="btn btn-instagram pull-right  margin-r-5">บันทึก</button>&nbsp;&nbsp;

                    </div><!-- /.box-footer -->
                </form>
            </div><!-- /.box -->

        </div><!--/.col (right) -->
    </div>
</section><!-- /.content -->
<!-- Validate -->

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

<script src="<?= base_url() ?>assets/plugins/switch/js/on-off-switch.js"></script>
<script src="<?= base_url() ?>assets/plugins/switch/js/on-off-switch-onload.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/switch/css/on-off-switch.css">
<script>

    new DG.OnOffSwitch({
        el: '#on-off-switch',
        textOn: 'เปิดสัญญา',
        textOff: 'ปิดสัญญา',
          listener: function (name, checked) {

         }
    });
</script>