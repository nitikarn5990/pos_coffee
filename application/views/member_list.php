<!-- Content Header (Page header) -->
<script src="<?= base_url() ?>assets/plugins/jQuery/jquery-1.12.0.min.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/bootstrap/css/bootstrap.min.css">
<div class="container">
    <section class="content-header">
        <h1>
            ข้อมูลผู้เช่า
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
                <form action="<?= base_url() ?>member/delete" method="POST">
                    <div class="box">
                        <div class="box-header">
                            <div class="col-md-12">

                            </div>
                        </div>
                        <div class="box-body">
                            <div class="col-xs-12">
                                <table id="example" class="ui celled table" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>

                                            <th>รหัส</th>
                                            <th>ชื่อ-นามสกุล</th>
                                            <th>เบอร์โทร</th>
                                            <th>เลขที่ห้อง</th>
                                       
                                            <th class="">แก้ไขล่าสุด</th>
                                            <th class="">ตัวเลือก</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>

                                            <th>รหัส</th>
                                            <th>ชื่อ-นามสกุล</th>
                                            <th>เบอร์โทร</th>
                                            <th>เลขที่ห้อง</th>
                                            <th>แก้ไขล่าสุด</th>
                                            <th>ตัวเลือก</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>

                                        <?php if (isset($resultq1)) { ?>
                                            <?php foreach ($resultq1 as $rows) { ?>
                                                <tr>

                                                    <td><?= $rows['id'] ?></td>
                                                    <td><?= $rows['customer_firstname'] . ' ' . $rows['customer_lastname'] ?></td>
                                                    <td><?= $rows['customer_tel'] ?></td>
                                                    <td style="text-align: center;">
                                                        <?php
                                                        $member_id = $rows['id'];
                                                        $room_id = $this->db->get_where('rental', array('member_id' => $member_id, 'status' => 'เปิดสัญญา', 'deleted_at' => '0000-00-00 00:00:00',))->row_array()['room_id'];
                                                        if ($room_id != '') {
                                                            echo $this->db->get_where('room', array('id' => $room_id))->row_array()['number_room'];
                                                        } else {
                                                            echo "-";
                                                        }
                                                        ?>
                                                    </td>
                        
                                                    <td class=""><?= ShowDateThTime($rows['updated_at']) ?></td>
                                                    <td class="">
                                                        <a href="#" onclick="picks('<?= $rows['id'] . '|' . $rows['customer_firstname'] . ' ' . $rows['customer_lastname'] ?>')" class="btn btn-sm btn-primary">เลือก</a>

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
</div>

<!-- Bootstrap 3.3.5 -->
<script src="<?= base_url() ?>assets/bootstrap/js/bootstrap.min.js"></script>
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

                                                    function picks(id) {
                                                        if (window.opener && !window.opener.closed) {
                                                            //  window.opener.document.stockForm.stockBox.value = symbol;

                                                            if (id !== '') {

                                                                window.opener.$('#member_id').val(id);
                                                                window.close();

                                                            }


                                                        }
                                                    }
                                                    function picks2(media_id) {
                                                        if (window.opener && !window.opener.closed) {
                                                            //  window.opener.document.stockForm.stockBox.value = symbol;

                                                            window.opener.document.getElementById('media_id').value = media_id;

                                                            window.opener.$('#table_media_list').html(html_table);
                                                            window.close();

                                                        }
                                                    }

</script>