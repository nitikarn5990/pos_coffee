<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Option ภายในห้อง
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
            <form action="<?= base_url() ?>room_option/delete" method="POST">
                <div class="box">
                    <div class="box-header">
                        <div class="col-md-12">
                            <a href="<?= base_url('room_option/add') ?>" class="btn btn-success btn-flat" name="btn_submit" value="เพิ่มข้อมูล">เพิ่มข้อมูล</a>
                            <button type="submit" class="btn btn-danger btn-flat" name="btn_submit" value="ลบที่เลือก">ลบที่เลือก</button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="col-xs-12">
                            <table id="example" class="ui celled table" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="chkboxall" name="chkbox" ></th>
                                        <th>รหัส</th>
                                        <th>ชื่อ</th>
                                        <th style="text-align: center;">ราคาต่อเดือน</th>
                                        <th class="" style="text-align: center;">แก้ไขล่าสุด</th>
                                        <th class="" style="text-align: center;">ตัวเลือก</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>รหัส</th>
                                        <th>ชื่อ</th>
                                        <th style="text-align: center;">ราคาต่อเดือน</th>
                                        <th class="">แก้ไขล่าสุด</th>
                                        <th class="">ตัวเลือก</th>
                                    </tr>
                                </tfoot>
                                <tbody>

                                    <?php if (isset($resultq1)) { ?>
                                        <?php foreach ($resultq1 as $rows) { ?>
                                            <tr class="">
                                                <td><input type="checkbox" class="chkbox" value="<?= $rows['id'] ?>" name="chkbox[]"></td>
                                                <td><?= $rows['id'] ?></td>
                                                <td><?= $rows['name'] ?></td>
                                                <td style="text-align: center;"><?= $rows['price_per_month'] ?></td>

                                                <td class="" style="text-align: center;"><?= ShowDateThTime($rows['updated_at']) ?></td>
                                                <td class="" style="text-align: center;">
                                                    <a href="<?= base_url() ?>room_option/edit/<?= $rows['id'] ?>" class="btn btn-sm btn-primary">แก้ไข / ดู</a>

                                                    <a href="#" onclick="if (confirm('คุณต้องการลบข้อมูลนี้หรือใม่?') == true) {
                                                                document.location.href = '<?= base_url() ?>room_option/delete/<?= $rows['id'] ?>'
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