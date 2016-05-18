<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        ข้อมูลพนักงาน
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
                    <?php echo $this->session->flashdata('message_error') ?>
                </div>
            <?php } ?>



        </div>
        <div class="col-xs-12">
            <form action="<?= base_url() ?>administrator/delete" method="POST">
                <div class="box">
                    <div class="box-header">
                        <div class="col-md-12">
                            <a href="<?= base_url('administrator/add') ?>" class="btn btn-success" name="btn_submit" value="เพิ่มข้อมูล">เพิ่มข้อมูล</a>
                       
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="col-xs-12">
                            <table id="example" class="ui celled table " cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>ลำดับ</th>
                                        <th>ชื่อ-สกุล</th>
                                        <th>ตำแหน่ง</th>
                                        <th>สถานะ</th>
                                        <th class="">แก้ไขล่าสุด</th>
                                        <th class="">ตัวเลือก</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ลำดับ</th>
                                        <th>ชื่อ-สกุล</th>
                                        <th>ตำแหน่ง</th>
                                        <th>สถานะ</th>
                                        <th class="">แก้ไขล่าสุด</th>
                                        <th class="">ตัวเลือก</th>
                                    </tr>
                                </tfoot>
                                <tbody>

                                    <?php if (isset($resultq1)) { ?>
                                        <?php foreach ($resultq1 as $key => $rows) { ?>
                                            <tr class="">
                                                <td><?= $key + 1 ?></td>
                                                <td><?= $rows['name'] ?></td>
                                                <td><?= $rows['position'] ?></td>
                                                <td><?= $rows['status'] ?></td>
                                                <td class=""><?= ShowDateThTime($rows['updated_at']) ?></td>
                                                <td class="">
                                                    <p>
                                                        <a href="<?= base_url() ?>administrator/edit/<?= $rows['id'] ?>" class="btn btn-sm btn-info">แก้ไข / ดู</a>
                                                        <a href="#" onclick="if (confirm('คุณต้องการลบข้อมูลนี้หรือใม่?') == true) {
                                                                    document.location.href = '<?= base_url() ?>administrator/delete/<?= $rows['id'] ?>'
                                                                            }" class="btn btn-sm btn-danger">ลบ</a>
                                                    </p>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="box-footer">
                  
                    </div>
                    
                </div>
            </form>
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->



<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatable2/semantic.min.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatable2/dataTables.semanticui.min.css">

<script src="<?= base_url() ?>assets/plugins/datatable2/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatable2/dataTables.semanticui.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatable2/semantic.min.js"></script>



<script>
                                                                $(document).ready(function () {
                                                                    $('#example').DataTable();

                                                                    $("#chkboxall").click(function (e) {
                                                                        $('.chkbox').prop('checked', this.checked);
                                                                    });

                                                                });

</script>
