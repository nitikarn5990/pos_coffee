<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        ข้อมูลสินค้า
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
            <form action="<?= base_url() ?>menu/delete" method="POST">
                <div class="box">
                    <div class="box-header with-border">
                        <div class="col-md-12">
                            <a href="<?= base_url('menu/add') ?>" class="btn btn-success " name="btn_submit" value="เพิ่มข้อมูล"><i class="fa fa-plus"></i> เพิ่มข้อมูล</a>
                            <button type="submit" class="btn btn-danger" name="btn_submit" value="ลบที่เลือก"><i class="fa fa-trash"></i> ลบที่เลือก</button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="col-xs-12 table-responsive">
                            <table id="example" class="table table-hover table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="chkboxall" name="chkbox" ></th>
                                        <th>รหัส</th>
                                        <th>หมวดหมู่</th>
                                        <th>ชื่อสินค้า</th>
                                        <th>ร้อน</th>
                                        <th>เย็น</th>
                                        <th>ปั่น</th>
                                
                                        <th class="hidden">แก้ไขล่าสุด</th>
                                        <th class="">ตัวเลือก</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>รหัส</th>
                                        <th>หมวดหมู่</th>
                                        <th>ชื่อสินค้า</th>
                                        <th>ร้อน</th>
                                        <th>เย็น</th>
                                        <th>ปั่น</th>
                                      
                                        <th class="hidden">แก้ไขล่าสุด</th>
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
                                                <td><?= $this->db->get_where('category', array('id' => $rows['category_id']))->row_array()['category_name']; ?></td>
                                                <td><?= $rows['product'] ?></td>
                                                <td><?= $rows['hot'] == 0 ? '-' : $rows['hot'] ?></td>
                                                <td><?= $rows['iced'] == 0 ? '-' : $rows['iced'] ?></td>
                                                <td><?= $rows['smoothie'] == 0 ? '-' : $rows['smoothie'] ?></td>
                                               
                                                <td class="hidden"><?= ShowDateThTime($rows['updated_at']) ?></td>
                                                <td class="">
                                                    <a href="<?= base_url() ?>menu/edit/<?= $rows['id'] ?>" class="btn btn-flat  btn-sm btn-primary">แก้ไข / ดู</a>

                                                    <a href="#" onclick="if (confirm('คุณต้องการลบข้อมูลนี้หรือใม่?') == true) {
                                                                        document.location.href = '<?= base_url() ?>menu/delete/<?= $rows['id'] ?>'
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