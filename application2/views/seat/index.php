<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        ข้อมูลโต๊ะ
    </h1>
    <ol class="breadcrumb hidden">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <form action="<?= base_url() ?>seat/delete" method="POST">
                <div class="box">
                    <div class="box-header">
                        <div class="col-md-12">
                            <a href="<?= base_url('seat/add') ?>" class="btn btn-success " name="btn_submit" value="เพิ่มข้อมูล"><i class="fa fa-plus"></i> เพิ่มข้อมูล</a>
                            <button type="submit" class="btn btn-danger" name="btn_submit" value="ลบที่เลือก"><i class="fa fa-trash"></i> ลบที่เลือก</button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="col-xs-12">
                            <table id="example" class="ui celled table" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="chkboxall" name="chkbox" ></th>
                                        <th>รหัส</th>
                                       <th>ชื่อโต๊ะ</th>
                                  
                                        <th>สถานะ</th>
                                        <th class="">แก้ไขล่าสุด</th>
                                        <th class="">ตัวเลือก</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>รหัส</th>
                                        <th>ชื่อโต๊ะ</th>
                                      
                                        <th>สถานะ</th>
                                        <th class="">แก้ไขล่าสุด</th>
                                        <th class="">ตัวเลือก</th>
                                    </tr>
                                </tfoot>
                                <tbody>

                                    <?php if (isset($resultq1)) { ?>
                                        <?php
                                        foreach ($resultq1 as $rows) {

                                           
                                            ?>
                                            <tr class="<?= $rows['status'] == 'ใช้งาน' ? 'bg-success' : 'bg-danger' ?>">
                                                <td><input type="checkbox" class="chkbox" value="<?= $rows['id'] ?>" name="chkbox[]"></td>
                                                <td><?= $rows['id'] ?></td>
                                                <td><?= $rows['name'] ?></td>
                                               
                                                 <td><?= $rows['status'] ?></td>

                                                <td class=""><?= ShowDateThTime($rows['updated_at']) ?></td>
                                                <td class="">
                                                    <a href="<?= base_url() ?>seat/edit/<?= $rows['id'] ?>" class="btn btn-sm btn-primary">แก้ไข / ดู</a>

                                                    <a href="#" onclick="if (confirm('คุณต้องการลบข้อมูลนี้หรือใม่?') == true) {
                                                                document.location.href = '<?= base_url() ?>seat/delete/<?= $rows['id'] ?>'
                                                                        }" class="btn btn-sm btn-danger">ลบ</a>
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