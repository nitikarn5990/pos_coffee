<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        แก้ไขข้อมูลผู้เช่า

    </h1>
    <ol class="breadcrumb hidden">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-6">
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
        <div class="col-md-6">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">ข้อมูล</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" action="<?= base_url('member/update') ?>" method="POST">
                    <input type="hidden" name="id" value="<?=$id?>">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">ชื่อ</label>
                            <div class="col-sm-10">
                                <input type="text" value="<?php echo $customer_firstname ?>" class="form-control"  name="customer_firstname" data-validation="required" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">นามสกุล</label>
                            <div class="col-sm-10">
                                <input type="text" value="<?php echo $customer_lastname ?>" class="form-control" id="" name="customer_lastname" data-validation="required"  >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">ที่อยู่</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="customer_address" data-validation="required"  rows="3"><?php echo $customer_address ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">จังหวัด</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" data-validation="required"  id="inputPassword3" name="province" value="<?php echo $province ?>" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">รหัสไปษณีย์</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" data-validation="required,number"  id="inputPassword3" name="zipcode" value="<?php echo $zipcode ?>" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">เบอร์มือถือ</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" data-validation="required,number"  id="inputPassword3"  name="customer_tel" value="<?php echo $customer_tel ?>">
                            </div>
                        </div>


                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" name="btn_submit" value="บันทึกและแก้ไขต่อ" class="btn btn-instagram pull-right margin-r-5">บันทึกและแก้ไขต่อ</button>
                        <button type="submit" name="btn_submit" value="บันทึก" class="btn btn-instagram pull-right  margin-r-5">บันทึก</button>&nbsp;&nbsp;

                    </div><!-- /.box-footer -->
                </form>
            </div><!-- /.box -->

        </div><!--/.col (right) -->
    </div>
</section><!-- /.content -->
<!-- Validate -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.2.8/jquery.form-validator.min.js"></script>
<script> $.validate();</script>