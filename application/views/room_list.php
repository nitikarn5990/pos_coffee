<!-- Content Header (Page header) -->
<script src="<?= base_url() ?>assets/plugins/jQuery/jquery-1.12.0.min.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/bootstrap/css/bootstrap.min.css">
<div class="container">
    <section class="content-header">
        <h1>
            ข้อมูลห้องเช่า
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
                <form action="<?= base_url() ?>room/delete" method="POST">
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
                                            <th>หมายเลขห้อง</th>
                                            <th>ราคา/เดือน</th>
                                            <th>สถานะ</th>
                                            <th class="">แก้ไขล่าสุด</th>
                                            <th class="">ตัวเลือก</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>

                                            <th>รหัส</th>
                                            <th>หมายเลขห้อง</th>
                                            <th>ราคา/เดือน</th>
                                            <th>สถานะ</th>
                                            <th class="">แก้ไขล่าสุด</th>
                                            <th class="">ตัวเลือก</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php if (isset($resultq1)) { ?>
                                            <?php foreach ($resultq1 as $rows) { ?>
                                                <?php
                                            
                                                $result_rentalt_count = $this->db->get_where('rental', array('room_id' => $rows['id'], 'status' => 'เปิดสัญญา'))
                                                        ->num_rows();
                                                ?>
                                                <tr class="<?= $result_rentalt_count == 0 ? 'bg-success' : 'bg-danger' ?>">
                                                    <td><?= $rows['id'] ?></td>
                                                    <td><?= $rows['number_room'] ?></td>
                                                    <td><?= $rows['price_per_month'] ?></td>
                                                    <td><?= $result_rentalt_count == 0 ? 'ว่าง' : 'มีการเช่า' ?></td>
                                                    <td class=""><?= ShowDateThTime($rows['updated_at']) ?></td>
                                                    <td class="">
                                                        <?php
                                                        //ถ้า 0 ไม่มีการเช่า
                                                        if ($result_rentalt_count == 0) {
                                                            ?>
                                                            <a href="#" onclick="picks('<?= $rows['id'] . '|' . $rows['number_room'] ?>', '<?= $rows['price_per_month'] ?>', '<?= $deposit ?>', '<?= $rows['meter_electric'] ?>', '<?= $rows['meter_water'] ?>')" class="btn btn-sm btn-primary">เลือก</a>
                                                        <?php } ?>
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

                                                    function picks(id, price_per_month, deposit, meter_electric, meter_water) {
                                                        if (window.opener && !window.opener.closed) {
                                                            //  window.opener.document.stockForm.stockBox.value = symbol;

                                                            if (id !== '') {

                                                                window.opener.$('#room_id').val(id);
                                                                window.opener.$('#price_per_month').val(price_per_month);

                                                                window.opener.$('#meter_electric').val(meter_electric);
                                                                window.opener.$('#meter_water').val(meter_water);

                                                                var total_amt = parseInt(deposit) + parseInt(price_per_month);
                                                                window.opener.$('#total_amt').val(total_amt);


                                                                window.opener.total_amt();
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
<style>
    table.dataTable.table td, table.dataTable.table th{
        text-align: center !important;

    }
</style>