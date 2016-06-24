 
<section class="content-header">
    <h1>
        แก้ไขข้อมูลสินค้า

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
                <form class="form-horizontal" action="<?= base_url('category/edit/'.$id) ?>" method="POST">
                    <div class="box-body">
                       <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">ชื่อหมวดหมู่</label>
                            <div class="col-sm-10">
                                <input type="text" value="<?php echo $res_category['category_name']; ?>" class="form-control"  name="category_name" data-validation="required" >
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