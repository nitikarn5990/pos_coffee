<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <i class="fa fa-file-text"></i> รายงาน
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
            <form action="<?= base_url() ?>report/sales" method="POST">
                <input type="hidden" id="date_start" name="date_start" value="<?= empty($_POST['date_start']) ? '' : $_POST['date_start'] ?>">
                <input type="hidden" id="date_end" name="date_end" value="<?= empty($_POST['date_end']) ? '' : $_POST['date_end'] ?>">
                <div class="box box-widget ">

                    <div class="box-header with-border ">
                        <h3 class="box-title"><i class="fa fa-search"></i> ค้นหา</h3>
                    </div>
                    <div class="box-body">
                        <?php
                        $arr = array(
                           'ยอดขาย',
                          'สินค้า',
                        );
                        ?>
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <div class="form-inline">

                                    <select name="report_type" id="report_type" class="form-control col-md-3 col-sm-6 col-xs-6" style="min-width: 240px;">
                                        <?php
                                       
                                        foreach ($arr as $value) {
                                            ?>
                                            <option value="<?= $value?>" <?=  $value == $type ? 'selected' : '' ?>><?= $value ?></option>  


                                        <?php } ?>
                                    </select>
                                    <input type="text" readonly="" placeholder="คลิกเลือกวันที่" class="form-control col-md-3 col-sm-6 col-xs-6" id="reservation" name="reservation" value="<?= empty($_POST['reservation']) ? '' : $_POST['reservation'] ?>" style="min-width: 300px;">
                                    <button type="submit" class="btn btn-flat bg-purple col-md-1 col-xs-12" name="btn_submit" value="ค้นหา"><i class="fa fa-search"></i> ค้นหา</button>
                                </div>

                            </div>

                        </div>


                    </div>
                    <div class="box-footer hidden">
                        <button type="submit" class="btn btn-info" name="btn_submit" value="ค้นหา"><i class="fa fa-search"></i> ค้นหา</button>
                        <a href="<?= base_url() ?>report/sales" class="btn btn-info"><i class="fa fa-list-alt"></i> แสดงทั้งหมด</a>
                        <button class="btn btn-facebook" onclick="printContent('tb_1')"><i class="fa fa-print"></i> Print </button>
                    </div>
                </div>
                <div class="box box-widget">
                    <div class="box-header">
                        <h3><i class="fa fa-list"></i> แสดงข้อมูลที่ค้นหา</h3>
                    </div>
                    <div class="box-body">
                        <?php if (($type) == 'ยอดขาย') { ?>
                            <div class="table-responsive" id="tb_1">

                                <table id="" class="table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Date</th>  
                                            <th>Total</th>


                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $total_sales = 0;
                                        foreach ($res_active_order_sales as $key => $row) {

                                            $date = ShowDateTh2($row['formatted_date']);
                                            $total_sales = $total_sales + $row['total'];
                                            ?>

                                            <tr class="">
                                                <td><?= $date ?></td>
                                                <td>฿ <?= $row['total'] ?></td>




                                            </tr>
                                        <?php } ?>
                                        <tr class="">
                                            <td colspan="1" class="text-right">รวมทั้งหมด</td>
                                            <td >฿ <?= $total_sales ?></td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        <?php } ?>
                        <?php if (($type) == 'สินค้า') { ?>
                            <div class="table-responsive" id="tb_1">

                                <table id="" class="table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>  
                                            <th>Product</th>
                                            <th>Qty</th>
                                            <th>Total</th>


                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $total_sales = 0;
                                        $menu_type = '';

                                        foreach ($res_active_order_sales as $key => $row) {

                                            // $date = ShowDateTh2($row['formatted_date']);
                                           $total_sales = $total_sales + $row['total_price'];
                                            if ($row['menu_type'] == 'iced') {
                                                $menu_type = 'เย็น';
                                            }
                                            if ($row['menu_type'] == 'hot') {
                                                $menu_type = 'ร้อน';
                                            }
                                            if ($row['menu_type'] == 'smoothie') {
                                                $menu_type = 'ปั่น';
                                            }
                                            ?>

                                            <tr class="">
                                                <td><?= $key + 1 ?></td>
                                                <td><?= $row['product'] . ' (' . $menu_type . ')' ?></td>
                                                <td><?= $row['total_qty'] ?></td>
                                                <td>฿ <?= $row['total_price'] ?></td>

                                            </tr>
                                        <?php } ?>
                                        <tr class="">
                                            <td colspan="3" class="text-right">รวมทั้งหมด</td>
                                            <td >฿ <?= $total_sales ?></td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </form>
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->

<script>
    function printContent(el) {
        $(document).ready(function () {
            var restorepage = document.body.innerHTML;
            var printcontent = document.getElementById(el).innerHTML;
            document.body.innerHTML = printcontent;
            if (printcontent !== '') {
                window.print();
                document.body.innerHTML = restorepage;
            }


        });
    }
</script>

<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatable2/semantic.min.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatable2/dataTables.semanticui.min.css">

<script src="<?= base_url() ?>assets/plugins/datatable2/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatable2/dataTables.semanticui.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatable2/semantic.min.js"></script>

<!-- date-range-picker -->
<script src="<?= base_url() ?>assets/js/moment.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/daterangepicker/daterangepicker.js"></script>

<style>
    .ui-datepicker-calendar {

        display: none;

    }​

</style>
<script>
    $(document).ready(function () {

     

        $('#example').DataTable();

        $("#chkboxall").click(function (e) {
            $('.chkbox').prop('checked', this.checked);
        });

        $('#reservations').daterangepicker(
                {
                    locale: {
                        format: 'D-M-YYYY'
                    },
                },
                function (start, end, label) {
                  //  $('#date_start').val(start.format('YYYY-M-D') + " 00:00:00");
                   // $('#date_end').val(end.format('YYYY-M-D') + " 23:59:59");
                  // alert(start.format('DD/MM/YYYY'));
                   $("#reservation").val(start.format('DD/MM/YYYY') + '-' + end.format('DD/MM/YYYY'));

                    //   alert("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
                });



    });

$('#reservation').daterangepicker(
{
    locale: {
      format: 'YYYY-MM-DD'
    }
   // startDate: '2013-01-01',
   // endDate: '2013-12-31'
}, 
function(start, end, label) {
   // alert("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
});



</script>
