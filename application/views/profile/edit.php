 
<section class="content-header">
    <h1>
        แก้ไขข้อมูล

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
                    <i class="fa fa-check"></i>&nbsp; <?php echo $this->session->flashdata('message_success') ?>
                </div>
            <?php } ?>

            <?php if ($this->session->flashdata('message_error')) { ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <i class="fa fa-trash"></i>&nbsp;<?php echo $this->session->flashdata('message_error') ?>
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
                <form class="form-horizontal" enctype="multipart/form-data" action="<?= base_url('profile/edit') ?>" method="POST">
                    <div class="box-body">
                          <?php if ($res_users['image'] != '') { ?>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">ภาพที่อัพโหลด</label>
                                <div class="col-sm-10">

                                    <img src="<?= base_url('uploads') ?>/<?= $res_users['image'] ?>" class="img-responsive">

                                </div>
                            </div>
                        <?php } ?>


                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Image</label>
                            <div class="col-sm-10">
                                <input type="file"  class="form-control"  name="image" data-validation="" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Username</label>
                            <div class="col-sm-10">
                                <input type="text" value="<?php echo $res_users['username']; ?>" class="form-control"  name="username" data-validation="required" readonly="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-10">
                                <input type="text" value="<?php echo decode_login($res_users['password']); ?>" class="form-control"  name="password" data-validation="required" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">ชื่อ-สกุล</label>
                            <div class="col-sm-10">
                                <input type="text" value="<?php echo $res_users['name']; ?>" class="form-control"  name="name" data-validation="required" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">เบอร์โทร</label>
                            <div class="col-sm-10">
                                <input type="text" value="<?php echo $res_users['tel']; ?>" class="form-control"  name="tel" data-validation="required,number" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">ที่อยู่</label>
                            <div class="col-sm-10">

                                <textarea name="address" class="form-control" rows="5"><?php echo $res_users['address']; ?></textarea>
                            </div>
                        </div>
                      
                       
                    </div><!-- /.box-body -->
                    <div class="box-footer">

                        <button type="submit" name="btn_submit" value="บันทึกและแก้ไขต่อ" class="btn btn-success pull-right margin-r-5"><i class="fa fa-edit"></i>&nbsp; บันทึกและแก้ไขต่อ</button>
          

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