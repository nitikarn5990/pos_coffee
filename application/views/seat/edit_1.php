 
<section class="content-header">
    <h1>
        แก้ไขข้อมูลโต๊ะ

    </h1>
    <ol class="breadcrumb hidden">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!--End Alert -->

    <div class="row">
        <section class="col-md-12 connectedSortable ui-sortable">
            <!-- Horizontal Form -->

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


            <div class="box box-info">
                <div class="box-header ui-sortable-handle with-border">
                    <h3 class="box-title">ข้อมูล</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" action="<?= base_url('seat/edit/' . $id) ?>" method="POST">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">ชื่อสินค้า</label>
                            <div class="col-sm-10">
                                <input type="text" value="<?php echo $res_seat['name']; ?>" class="form-control"  name="name" data-validation="required" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">สถานะ</label>
                            <div class="col-sm-10">
                                <ul class="" style="list-style: none;padding-left: 0;">
                                    <?php
                                    $getStatus = field_enums('seat', 'status');
                                    $i = 1;
                                    foreach ($getStatus as $value) {
                                        ?>
                                        <li>
                                            <input type="radio" name="status" id="status" value="<?php echo $value ?>" <?= $res_seat['status'] == $value ? 'checked' : '' ?>  data-validation="required"/>
                                            <label><?php echo $value ?></label>
                                        </li>
                                        <?php
                                        $i++;
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
        </section>
    </div><!--/.col (right) -->


</section><!-- /.content -->
<!-- Validate -->

