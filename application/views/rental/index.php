<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        สัญญาเช่าทั้งหมด
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
        <div class="col-xs-12">
            <form action="<?= base_url() ?>rental/delete" method="POST">
                <div class="box">
                    <div class="box-header">
                        <div class="col-md-12">
                            <a href="<?= base_url('rental/add') ?>" class="btn btn-success btn-flat" name="btn_submit" value="เพิ่มข้อมูล">เพิ่มข้อมูล</a>
                            <button type="submit" class="btn btn-danger btn-flat" name="btn_submit" value="ลบที่เลือก">ลบที่เลือก</button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="col-xs-12">
                            <table id="example" class="ui celled table" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="chkboxall" name="chkbox" ></th>
                                        <th>เลขที่สัญญา</th>
                                        <th>หมายเลขห้อง</th>
                                           <th>ชื่อ</th>
                                        <th>สถานะ</th>
                                        <th class="">แก้ไขล่าสุด</th>
                                        <th class="">พิมพ์</th>
                                        <th class="">ตัวเลือก</th>

                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>เลขที่สัญญา</th>
                                        <th>หมายเลขห้อง</th>
                                         <th>ชื่อ</th>
                                        <th>สถานะ</th>
                                        <th class="">แก้ไขล่าสุด</th>
                                        <th class="">พิมพ์</th>
                                        <th class="">ตัวเลือก</th>

                                    </tr>
                                </tfoot>
                                <tbody>

                                    <?php if (isset($resultq1)) { ?>
                                        <?php foreach ($resultq1 as $rows) { ?>
                                            <tr class="<?= $rows['status'] == 'เปิดสัญญา' ? 'bg-success' : 'bg-danger' ?>">
                                                <td><input type="checkbox" class="chkbox" value="<?= $rows['id'] ?>" name="chkbox[]"></td>
                                                <td><?= $rows['id'] ?></td>
                                                <td><?= $this->db->get_where('room', array('id' => $rows['room_id']))->row_array()['number_room'] ?></td>
                                                <td>
                                                <?= 
                                                    $this->db->get_where('member', array('id' => $rows['member_id']))->row_array()['customer_firstname'] .' '.
                                                    $this->db->get_where('member', array('id' => $rows['member_id']))->row_array()['customer_lastname'] 
                                                ?>
                                          
                                                </td>
                                                <td><?= $rows['status'] ?></td>

                                                <td class=""><?= ShowDateThTime($rows['updated_at']) ?></td>
                                                <td class="">
                                                    <?php if ($rows['status'] == 'เปิดสัญญา') { ?>
                                                        <a href="<?= base_url() ?>rental_agreement/index/<?=$rows['id']?>" target="_blank" class="btn btn-sm btn-default"><i class="fa fa-print"></i> สัญญาเช่า</a>
                                                    <?php } else { ?>
                                                        <a href="<?= base_url() ?>" class="btn btn-sm btn-default hidden"><i class="fa fa-print"></i> ใบปิดสัญญาเช่า</a>
                                                    <?php } ?>
                                                </td>  
                                                <td class="">
                                                    <p>
                                                    <a href="<?= base_url() ?>rental/edit/<?= $rows['id'] ?>" class="btn btn-sm btn-info">แก้ไข / ดู</a>

                                                    <a href="#" onclick="if (confirm('คุณต้องการลบข้อมูลนี้หรือใม่?') == true) {
                                                                        document.location.href = '<?= base_url() ?>rental/delete/<?= $rows['id'] ?>'
                                                                                }" class="btn btn-sm btn-danger">ลบ</a>
                                                     </p>
                                                    <p> 
                                                        <a href="<?= base_url() ?>damages/index/<?= $rows['id'] ?>" target="" class="btn btn-sm btn-warning">คำนวณค่าใช้จ่ายและสิ่งของในห้องพัก</a>
                                                    </p>
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
