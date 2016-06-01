 
<section class="content-header">
    <h1>
        <i class="fa fa-plus"></i> เพิ่มข้อมูลพนักงาน
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

            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">ข้อมูล</h3>
                </div>
                <form class="form-horizontal"  enctype="multipart/form-data"  action="<?= base_url('administrator/add') ?>" method="POST">
              
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Image</label>
                            <div class="col-sm-10">
                                <input type="file"  class="form-control"  name="image" data-validation="" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Username</label>
                            <div class="col-sm-10">
                                <input type="text" value="<?php echo set_value('username'); ?>" class="form-control"  name="username" data-validation="required" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" value="" class="form-control"  name="password" data-validation="required" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">ชื่อ-สกุล</label>
                            <div class="col-sm-10">
                                <input type="text" value="<?php echo set_value('name'); ?>" class="form-control"  name="name" data-validation="required" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">เบอร์โทร</label>
                            <div class="col-sm-10">
                                <input type="text" value="<?php echo set_value('tel'); ?>" class="form-control"  name="tel" data-validation="required,number" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">ที่อยู่</label>
                            <div class="col-sm-10">

                                <textarea name="address" class="form-control" rows="5"><?php echo set_value('address'); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">ตำแหน่ง</label>
                            <div class="col-sm-10">
                                <ul class="" style="list-style: none;padding-left: 0;">
                                    <?php
                                    $getStatus = field_enums('users', 'position');
                                    $i = 1;
                                    foreach ($getStatus as $value) {
                                        if ($value != 'ผู้ดูแลระบบ') {
                                            ?>
                                            <li>
                                                <input type="radio" name="position" id="position" value="<?php echo $value ?>" <?= $i == 1 ? 'checked' : '' ?>  data-validation="required"/>
                                                <label for="position"><?php echo $value ?></label>
                                            </li>
                                            <?php
                                            $i++;
                                        }
                                    }
                                    ?>
                                </ul>

                            </div>
                        </div>



                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" name="btn_submit" value="บันทึกและแก้ไขต่อ" class="btn btn-success pull-right margin-r-5"><i class="fa fa-save"></i> บันทึกและแก้ไขต่อ</button>
                        <button type="submit" name="btn_submit" value="บันทึก" class="btn btn-info pull-right margin-r-5"><i class="fa fa-save"></i> บันทึก</button>&nbsp;&nbsp;

                    </div><!-- /.box-footer -->
                </form>
            </div><!-- /.box -->

        </div><!--/.col (right) -->
    </div>
</section><!-- /.content -->

<!-- Validate -->

<script src="<?= base_url() ?>assets/plugins/validate/jquery.form-validator.min.js"></script>
<script> $.validate();</script>


<script src="<?= base_url() ?>assets/plugins/switch/js/on-off-switch.js"></script>
<script src="<?= base_url() ?>assets/plugins/switch/js/on-off-switch-onload.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/switch/css/on-off-switch.css">
<script>


</script>

