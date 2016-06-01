<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Topping
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
        <div class="col-xs-12">
            <form action="<?= base_url() ?>topping/delete" method="POST">
                <div class="box box-widget">
                    <div class="box-header with-border ">
                        <div class="col-md-12">
                            <a href="<?= base_url('topping/add') ?>" class="btn btn-success  btn-flat btn-sm" name="btn_submit" value="เพิ่มข้อมูล"><i class="fa fa-plus"></i> เพิ่มข้อมูล</a>
                            <button type="submit" class="btn btn-danger btn-flat btn-sm" name="btn_submit" value="ลบที่เลือก"><i class="fa fa-trash"></i> ลบที่เลือก</button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="col-xs-12 table-responsive">
                            
                            <table id="example" class="table table-hover table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="chkboxall" name="chkbox" ></th>
                                        <th>รหัส</th>
                                        <th>Topping</th>
                                         <th>ราคา</th>
                                    
                                        <th class="">ตัวเลือก</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>รหัส</th>
                                        <th>Topping</th>
                                         <th>ราคา</th>
                                
                                        <th class="">ตัวเลือก</th>
                                    </tr>
                                </tfoot>
                                <tbody>

                                    <?php if (isset($resultq1)) { ?>
                                        <?php
                                        foreach ($resultq1 as $rows) {
                                            ?>
                                            <tr class="">
                                                <td><input type="checkbox" class="chkbox" value="<?= $rows['id'] ?>" name="chkbox[]"></td>
                                                <td><?= $rows['id'] ?></td>
                                                <td><?= $rows['topping_name'] ?></td>
                                                  <td><?= $rows['price'] ?></td>
                                                <td class="">
                                                    <a href="<?= base_url() ?>topping/edit/<?= $rows['id'] ?>" class="btn btn-flat btn-sm btn-info">แก้ไข / ดู</a>

                                                    <a href="#" onclick="if (confirm('คุณต้องการลบข้อมูลนี้หรือใม่?') == true) {
                                                                    document.location.href = '<?= base_url() ?>topping/delete/<?= $rows['id'] ?>'
                                                                            }" class="btn btn-flat btn-sm btn-danger">ลบ</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->








<script>
    $(document).ready(function () {
        $('#example').DataTable();

        $("#chkboxall").click(function (e) {
            $('.chkbox').prop('checked', this.checked);
        });

    });

</script>