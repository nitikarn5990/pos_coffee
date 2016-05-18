 
<section class="content-header">
    <h1>
        จำนวนโต๊ะ

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
                <div class="box-header ui-sortable-handle ">
                 
                </div><!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" action="<?= base_url('seat/edit') ?>" method="POST">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">จำนวน</label>
                            <div class="col-sm-10">
                                <input type="text" value="<?php echo $res_seat['seat_number']; ?>" class="form-control"  name="seat_number" data-validation="required,number" >
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" name="btn_submit" value="บันทึกและแก้ไขต่อ" class="btn btn-success pull-right margin-r-5"><i class="fa fa-save"></i> บันทึกและแก้ไขต่อ</button>
                 

                    </div><!-- /.box-footer -->
                </form>
            </div><!-- /.box -->
        </section>
    </div><!--/.col (right) -->


</section><!-- /.content -->
<!-- Validate -->

