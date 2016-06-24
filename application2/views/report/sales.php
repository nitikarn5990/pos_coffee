<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/data.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
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
                            //  'สินค้า',
                            'สินค้าขายดี',
                            'Topping ขายดี',
                            'Order',
                        );
                        $arr2 = array(
                            '',
                            'ตามช่วงเวลา',
                            'ตามช่วงเดือน',
                            'ตามช่วงปี',
                        );
                        ?>
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <div class="form-inline">
                                    <p>
                                        <select name="report_type" data-validation="required" id="report_type" class="form-control col-md-3 col-sm-6 col-xs-6" style="min-width: 240px;">
                                            <?php
                                            foreach ($arr as $value) {
                                                ?>
                                                <option value="<?= $value ?>" <?= $value == $type ? 'selected' : '' ?>><?= $value ?></option>  
                                            <?php } ?>
                                        </select>
                                        <select name="report_range" data-validation="required" id="report_range" class="form-control col-md-3 col-sm-6 col-xs-6" style="min-width: 240px;" onchange="report_ranges(this)">
                                            <?php
                                            foreach ($arr2 as $value2) {
                                                ?>
                                                <option value="<?= $value2 ?>" <?= $value2 == $report_range ? 'selected' : '' ?>><?= $value2 == '' ?'เลือก': $value2?></option>  
                                            <?php } ?>
                                        </select>
                                    </p>

                                    <p class="tools_date">
                                        <?php if (isset($reservation)) { ?>
                                            <input type="text" readonly="" data-validation="required" placeholder="คลิกเลือกวันที่" class="form-control col-md-3 col-sm-6 col-xs-6" id="reservation" name="reservation" value="<?= $reservation ?>" style="min-width: 300px;">   
                                        <?php } else { ?>
                                            <input type="text" readonly="" data-validation="required" placeholder="คลิกเลือกวันที่" class="form-control col-md-3 col-sm-6 col-xs-6" id="reservation" name="reservation" value="<?= empty($_POST['reservation']) ? '' : $_POST['reservation'] ?>" style="min-width: 300px;">
                                        <?php }
                                        ?>
                                    </p>

                                    <p class="tools_month">
                                        <input type="text" readonly="" data-validation="required" placeholder="คลิกเลือกเดือนเริ่ม" class="form-control" id="daterange_month_start" name="daterange_month_start" value="" style="min-width: 150px;">   
                                        To <input type="text" readonly="" data-validation="required" placeholder="คลิกเลือกเดือนสุดท้าย" class="form-control" id="daterange_month_end" name="daterange_month_end" value="" style="min-width: 150px;">   
                                    </p>

                                    <p class="tools_year">
                                        <input type="text" readonly="" data-validation="required" placeholder="คลิกเลือกปีเริ่ม" class="form-control" id="daterange_year_start" name="daterange_year_start" value="" style="min-width: 150px;">   
                                        To <input type="text" readonly="" data-validation="required" placeholder="คลิกเลือกปีสุดท้าย" class="form-control" id="daterange_year_end" name="daterange_year_end" value="" style="min-width: 150px;">   
                                    </p>


                                    <button type="submit" class="btn btn-flat bg-purple col-md-1 col-xs-12" name="btn_submit" id="btn_submit" value="ค้นหา"><i class="fa fa-search"></i> ค้นหา</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="box box-widget">
                    <div class="box-header">
                        <h3><i class="fa fa-list"></i> แสดงข้อมูลที่ค้นหา </h3>
                        <h4 class="text-center"> <?= isset($duration) ? $duration : '' ?> </h4>
                    </div>
                    <div class="box-body">
                        <?php if (($type) == 'ยอดขาย') { ?>

                            <div class="col-md-12">
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#view_text" data-toggle="tab">แสดงข้อมูล</a></li>
                                        <li class=""><a href="#view_gp" data-toggle="tab" >แสดงกราฟ</a></li>
                                    </ul>

                                    <div class="tab-content">
                                        <div class="active tab-pane" id="view_text">
                                            <div class="table-responsive">
                                                <table id="report1" class="table table-hover table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>No.</th>  
                                                            <th>Date</th>  
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th>No.</th>  
                                                            <th>Date</th>  
                                                            <th>Total</th>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>
                                                        <?php
                                                        $total_sales = 0;
                                                        foreach ($res_active_order_sales as $key => $row) {

                                                            $date = ($row['formatted_date']);
                                                            $total_sales = $total_sales + $row['total'];
                                                            ?>

                                                            <tr class="">
                                                                <td><?= $key + 1 ?></td>
                                                                <td><?= $date ?></td>
                                                                <td> <?= $row['total'] ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="info-box">
                                                <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">รวมทั้งหมด</span>
                                                    <span class="info-box-number">฿ <?= $total_sales ?></span>
                                                </div>
                                            </div>
                                        </div><!-- /.tab-pane -->
                                        <div class="tab-pane" id="view_gp">
                                            <div class="table-responsive">
                                                <div class="" style="width: 80%;" id="gp">

                                                </div>
                                            </div>


                                        </div><!-- /.tab-pane -->
                                    </div><!-- /.tab-content -->
                                </div><!-- /.nav-tabs-custom -->
                            </div>



                        <?php } ?>
                        <?php if (($type) == 'สินค้าขายดี') { ?>

                            <div class="col-md-12">
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#view_text_product" data-toggle="tab">แสดงข้อมูล</a></li>
                                        <li class=""><a href="#view_gp_product" data-toggle="tab" >แสดงกราฟ</a></li>
                                    </ul>

                                    <div class="tab-content">
                                        <div class="active tab-pane" id="view_text_product">
                                            <div class="table-responsive">
                                                <table id="report2" class="table table-hover table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>No.</th>  
                                                            <th>Product</th>
                                                            <th>Qty</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th>No.</th>  
                                                            <th>Product</th>
                                                            <th>Qty</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </tfoot>
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
                                                                <td> <?= $row['total_price'] ?></td>

                                                            </tr>
                                                        <?php } ?>


                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="info-box">
                                                <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">รวมทั้งหมด</span>
                                                    <span class="info-box-number">฿ <?= $total_sales ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="view_gp_product">
                                            <div class="table-responsive">
                                                <div class="" style="width: 85%;" id="gp_product">

                                                </div>
                                            </div>


                                        </div><!-- /.tab-pane -->
                                    </div>

                                <?php } ?>
                                <?php if (($type) == 'สินค้า') { ?>
                                    <div class="table-responsive" id="">

                                        <table id="report3" class="table table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>  
                                                    <th>Product</th>
                                                    <th>Qty</th>

                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>No.</th>  
                                                    <th>Product</th>
                                                    <th>Qty</th>

                                                </tr>
                                            </tfoot>

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

                                                    </tr>
                                                <?php } ?>

                                            </tbody>
                                        </table>
                                    </div>
                                <?php } ?>
                                <?php if (($type) == 'Topping ขายดี') { ?>
                                    <div class="col-md-12">
                                        <div class="nav-tabs-custom">
                                            <ul class="nav nav-tabs">
                                                <li class="active"><a href="#view_text_topping" data-toggle="tab">แสดงข้อมูล</a></li>
                                                <li class=""><a href="#view_gp_topping" data-toggle="tab" >แสดงกราฟ</a></li>
                                            </ul>

                                            <div class="tab-content">
                                                <div class="active tab-pane" id="view_text_topping">
                                                    <div class="table-responsive">
                                                        <table id="report4" class="table table-hover table-bordered" cellspacing="0" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>No.</th>  
                                                                    <th>Topping</th>
                                                                    <th>Qty</th>
                                                                    <th>Total</th>
                                                                </tr>
                                                            </thead>
                                                            <tfoot>
                                                                <tr>
                                                                    <th>No.</th>  
                                                                    <th>Topping</th>
                                                                    <th>Qty</th>
                                                                    <th>Total</th>
                                                                </tr>
                                                            </tfoot>
                                                            <tbody>
                                                                <?php
                                                                $total_sales = 0;
                                                                foreach ($res_active_order_sales as $key => $row) {

                                                                    // $date = ShowDateTh2($row['formatted_date']);
                                                                    $total_sales = $total_sales + $row['total'];
                                                                    ?>

                                                                    <tr class="">
                                                                        <td><?= $key + 1 ?></td>
                                                                        <td><?= $row['topping'] ?></td>
                                                                        <td><?= $row['cnt_topping'] ?></td>
                                                                        <td> <?= $row['total'] ?></td>

                                                                    </tr>
                                                                <?php } ?>


                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="info-box">
                                                        <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>
                                                        <div class="info-box-content">
                                                            <span class="info-box-text">รวมทั้งหมด</span>
                                                            <span class="info-box-number">฿ <?= $total_sales ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="view_gp_topping">
                                                    <div class="table-responsive">
                                                        <div class="" style="width: 85%;" id="gp_topping">

                                                        </div>
                                                    </div>


                                                </div><!-- /.tab-pane -->

                                            </div>
                                        </div>
                                    </div>



                                <?php } ?>
                                <?php if (($type) == 'Order') { ?>
                                    <?php if (($detail) == 'OrderDetail') { ?>

                                        <div class="col-md-12 col-xs-12 hidden">
                                            <div class="form-inline">
                                                <button type="button" id="btn_back" class="btn btn-flat bg-blue col-md-1 col-xs-12"><i class="fa fa-arrow-left"></i>&nbsp; Back </button>
                                            </div>
                                        </div>
                                        <p>&nbsp;</p>

                                        <div class="col-md-12">
                                            <div class="nav-tabs-custom">
                                                <ul class="nav nav-tabs">
                                                    <li class="active"><a href="#view_text" data-toggle="tab" aria-expanded="true">แสดงข้อมูล</a></li>
                                                    <li class="hidden"><a href="#view_gp" data-toggle="tab" aria-expanded="false">แสดงกราฟ</a></li>

                                                </ul>

                                                <div class="tab-content">
                                                    <div class="active  tab-pane" id="view_text">
                                                        <section class="">
                                                            <!-- title row -->
                                                            <div class="row">
                                                                <div class="col-xs-12">
                                                                    <h2 class="page-header">
                                                                        <b>Order ID:</b> <?= $res_active_order_sales[0]['order_id'] ?>

                                                                        <small class="pull-right">Order Date: <?= $res_active_order_sales[0]['order_date'] ?></small>
                                                                    </h2>
                                                                </div><!-- /.col -->
                                                            </div>
                                                            <!-- info row -->
                                                            <div class="row invoice-info">

                                                                <div class="col-md-12 invoice-col">

                                                                    <b>Cashier:</b> <?= $res_active_order_sales[0]['cashier_name'] ?>

                                                                </div><!-- /.col -->
                                                            </div><!-- /.row -->

                                                            <!-- Table row -->
                                                            <div class="row">
                                                                <div class="col-md-12 text-center">
                                                                    <b>รายการ</b> 
                                                                </div>
                                                                <div class="col-md-12 table-responsive">
                                                                    <table class="table table-condensed">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="width: 40px;" class="text-center">Qty</th>
                                                                                <th style="width: 150px;" class="text-left">Product</th>
                                                                                <th style="width: 150px;" class="text-left">หมายเหตุ</th>
                                                                                <th style="width: 50px;" class="text-right ">Price</th>
                                                                                <th style="width: 100px;" class="text-right">Ext.Price</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            $grand_total = 0;
                                                                            foreach ($res_active_order_sales as $key => $row) {
                                                                                $total_sales = 0;
                                                                                $total_sales_topping = 0;
                                                                                ?>
                                                                                <tr data-active-order-detail-id="444" data-qty="1" data-detail-active_order_id="195" data-detail-menu_id="1" data-detail-menu_type="iced">
                                                                                    <td class="text-center text-bold" style="font-size: 16px;">
                                                                                        <p style="color: blue;"><?= $row['qty'] ?></p>
                                                                                    </td>
                                                                                    <td style="font-size: 16px;">
                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <span id="menu-name"><?= $row['product'] ?>  (<?= $row['menu_type'] ?> )</span> 
                                                                                                <div class="col-md-12">
                                                                                                    <ul class="text-topping">

                                                                                                        <?php
                                                                                                        if ($row['topping_list'] != '') {
                                                                                                            foreach ($row['topping_list'] as $key => $row2) {
                                                                                                                ?>
                                                                                                                <li class="">+ <?= $row2['topping'] ?></li>
                                                                                                            <?php } ?>
                                                                                                        <?php } ?>
                                                                                                    </ul>
                                                                                                </div>
                                                                                            </div>

                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="" style="font-size: 13px;"><?= $row['comment'] ?></td>
                                                                                    <td class="" style="font-size: 16px;">
                                                                                        <div id="" class="text-right">฿ <?= $row['price'] ?>.00</div>
                                                                                        <ul class="">
                                                                                            <?php
                                                                                            if ($row['topping_list'] != '') {
                                                                                                foreach ($row['topping_list'] as $key => $row2) {
                                                                                                    $total_sales_topping = $total_sales_topping + $row2['price'];
                                                                                                    ?>
                                                                                                    <li class="text-left">+ ฿<?= $row2['price'] ?>.00</li>
                                                                                                <?php } ?>
                                                                                            <?php } ?>
                                                                                        </ul>
                                                                                    </td>
                                                                                    <?php
                                                                                    $total_sales = ($total_sales_topping + $row['price'] ) * $row['qty'];
                                                                                    $grand_total = $grand_total + $total_sales;
                                                                                    ?>
                                                                                    <td class="text-right text-bold" style="font-size: 16px;">฿ <?= $total_sales ?>.00</td>
                                                                                </tr>
                                                                            <?php } ?>
                                                                                <tr class="bg-warning">

                                                                                <td colspan="4" style="font-size: 16px;"><b>Total:</b></td>
                                                                                <td style="font-size: 16px;text-align: right;"><b>฿ <?= $grand_total ?>.00</b></td>
                                                                            </tr>

                                                                        </tbody>
                                                                    </table>
                                                                </div><!-- /.col -->
                                                            </div><!-- /.row -->
                                                        </section><!-- /.content -->
                                                    </div><!-- /.tab-pane -->
                                                    <div class="tab-pane active" id="view_gp">
                                                    </div><!-- /.tab-pane -->
                                                </div><!-- /.tab-content -->
                                            </div><!-- /.nav-tabs-custom -->
                                        </div>

                                    <?php } else { ?>

                                        <table id="example2" class="display" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th class="text-center">OrderID</th>
                                                    <th class="text-center">Grand total</th>
                                                    <th class="text-center">Order Date</th>

                                                    <th class="text-center">Cashier Name</th>
                                                    <th class="text-center">ตัวเลือก</th>


                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th></th>
                                                    <th class="text-center">OrderID</th>
                                                    <th class="text-center">Grand total</th>
                                                    <th class="text-center">Order Date</th>
                                                    <th class="text-center">Cashier Name</th>
                                                    <th class="text-center">ตัวเลือก</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php
                                                $total_sales = 0;
                                                foreach ($res_active_order_sales as $key => $row) {
                                                    ?>

                                                    <tr class="">
                                                        <td class="text-center"><?= $key + 1 ?></td>
                                                        <td class="text-center"><?= $row['order_id'] ?></td>
                                                        <td class="text-center"><?= $row['total_price'] ?></td>
                                                        <td class="text-center"><?= $row['order_date'] ?></td>
                                                        <td class="text-center"> <?= $row['cashier_name'] ?></td>
                                                        <td class="text-center"> <a href="<?= base_url('report/sales/Order/' . $row['id']) ?>" class="btn-sm btn btn-info">ดูรายละเอียด</a></td>

                                                    </tr>
                                                <?php } ?>


                                            </tbody>
                                        </table>
                                    <?php } ?>
                                <?php } ?>

                            </div>
                        </div>
                        </form>
                    </div><!-- /.col -->
                </div><!-- /.row -->
                </section><!-- /.content -->

                <input type="hidden" id="kk">

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

                <script>
                    var tool_date = $('.tools_date');
                    var tool_month = $('.tools_month');
                    var tool_year = $('.tools_year');

                    tool_month.hide();
                    tool_year.hide();
                    tool_date.hide();

<?php if ($report_range != '') { ?>
    <?php if ($report_range == 'ตามช่วงเวลา') { ?>
                            tool_date.show();
    <?php } ?>
    <?php if ($report_range == 'ตามช่วงเดือน') { ?>
                            tool_month.show();
    <?php } ?>
    <?php if ($report_range == 'ตามช่วงปี') { ?>
                            tool_year.show();
    <?php } ?>
<?php } ?>
                    function report_ranges(ele) {
                        var val = $(ele).val();

                        if (val == 'ตามช่วงเวลา') {
                            tool_date.show();
                            tool_month.hide();
                            tool_year.hide();

                        } else if (val == 'ตามช่วงเดือน') {
                            tool_date.hide();
                            tool_year.hide();
                            tool_month.show();


                        } else if (val == 'ตามช่วงปี') {
                            tool_date.hide();
                            tool_month.hide();
                            tool_year.show();

                        }
                    }

                    $(document).ready(function () {

                        $('#daterange_month_start').datepicker({
                            format: "yyyy-mm",
                            changeYear: false,
                            viewMode: "months",
                            minViewMode: "months",
                        }).datepicker('setDate', 'today');
                        //   $('#daterange_month_start').datepicker().;
                        $('#daterange_month_end').datepicker({
                            format: "yyyy-mm",
                            changeYear: false,
                            viewMode: "months",
                            minViewMode: "months"
                        }).datepicker('setDate', 'today');

                        $('#daterange_year_start').datepicker({
                            format: "yyyy",
                            changeYear: false,
                            viewMode: "years",
                            minViewMode: "years"
                        }).datepicker('setDate', 'today');

                        $('#daterange_year_end').datepicker({
                            format: "yyyy",
                            changeYear: false,
                            viewMode: "years",
                            minViewMode: "years"
                        }).datepicker('setDate', 'today');

                    });
                </script>


                <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
                <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js "></script>

                <!-- date-range-picker -->
                <script src="<?= base_url() ?>assets/js/moment.min.js"></script>
                <script src="<?= base_url() ?>assets/plugins/daterangepicker/daterangepicker.js"></script>

                <style>
                    .ui-datepicker-calendar {

                        display: none;

                    }​

                    td.details-control {
                        background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
                        cursor: pointer;
                    }
                    tr.shown td.details-control {
                        background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
                    }

                </style>
                <pre id="csv" style="display:none">
                    <?php
                    if ($type == 'Topping ขายดี') {
                        if (isset($res_chart)) {
                            // cnt_topping topping
                            echo ",จำนวน, รวมราคา" . "\n";
                            foreach ($res_chart as $value) {
                                echo $value['topping'] . ',' . $value['cnt_topping'] . ',' . $value['total'] . "\n";
                            }
                        }
                    }
                    if ($type == 'สินค้าขายดี') {
                        if (isset($res_chart)) {
                            // cnt_topping topping
                            echo ",จำนวน, รวมราคา" . "\n";
                            $menu_type = '';
                            foreach ($res_chart as $value) {
                                if ($value['menu_type'] == 'iced') {
                                    $menu_type = ' (เย็น)';
                                }
                                if ($value['menu_type'] == 'hot') {
                                    $menu_type = ' (ร้อน)';
                                }
                                if ($value['menu_type'] == 'smoothie') {
                                    $menu_type = ' (ปั่น)';
                                }
                                echo $value['product'] . $menu_type . ',' . $value['total_qty'] . ',' . $value['total_price'] . "\n";
                            }
                        }
                    }
                    ?>

                </pre>
                <script>



                    function set_chart(datas) {

                        //ยอดขาย
<?php if (($type) == 'ยอดขาย') { ?>
                            var data = $.parseJSON(datas);
                            var arrx;
                            var arrx2 = [];
                            $.each(data, function (index, value) {
                                arrx = [
                                    value.formatted_date, parseInt(value.total)
                                ];
                                arrx2.push(arrx);
                            });
                            Highcharts.setOptions({
                                lang: {
                                    decimalPoint: '.',
                                    thousandsSep: ','
                                }
                            });
                            $('#gp').highcharts({
                                chart: {
                                    type: 'column'
                                },
                                title: {
                                    text: 'ยอดขาย'
                                },
                                subtitle: {
                                    text: ''

                                },
                                xAxis: {
                                    type: 'category',
                                    labels: {
                                        rotation: -45,
                                        style: {
                                            fontSize: '12px',
                                            fontFamily: 'Verdana, sans-serif'
                                        }
                                    }
                                },
                                yAxis: {
                                    min: 0,
                                    title: {
                                        text: 'Bath'
                                    }
                                },
                                legend: {
                                    enabled: false
                                },
                                tooltip: {
                                    pointFormat: "รวมทั้งสิ้น <b>{point.y:','.2f} บาท</b>"
                                },
                                exporting: {
                                    enabled: false
                                },
                                series: [{
                                        name: 'Population',
                                        data: arrx2,
                                        dataLabels: {
                                            enabled: true,
                                            rotation: 0,
                                            color: '#FFFFFF',
                                            align: 'center',
                                            format: "{point.y:','.2f} บาท", // one decimal
                                            y: 20, // 10 pixels down from the top
                                            style: {
                                                fontSize: '12px',
                                                fontFamily: 'Verdana, sans-serif'
                                            }
                                        }
                                    }]
                            });
<?php } ?>

                        //สินค้า
<?php if (($type) == 'สินค้าขายดี') { ?>
                    
                              Highcharts.setOptions({
                                lang: {
                                    decimalPoint: '.',
                                    thousandsSep: ','
                                }
                            });
                            $('#gp_product').highcharts({
                                chart: {
                                    type: 'column'
                                },
                                title: {
                                    text: 'สินค้าขายดี '
                                },
                                subtitle: {
                                    text: ''
                                },
                                data: {
                                    csv: document.getElementById('csv').innerHTML
                                },
                                exporting: {
                                    enabled: false
                                },
                                plotOptions: {
                                    series: {
                                        marker: {
                                            enabled: false
                                        }
                                    }
                                },
                                yAxis: {
                                    min: 0,
                                    title: {
                                        text: 'Values'
                                    }
                                },
                                tooltip: {
                                    headerFormat: '<span style="font-size:13px">{point.key}</span><table>',
                                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                            '<td style="padding:0"><b>{point.y:",".0f}</b></td></tr>',
                                    footerFormat: '</table>',
                                    shared: true,
                                    useHTML: true
                                },
                                series: []
                            });
<?php } ?>
                        //topping
<?php if (($type) == 'Topping ขายดี') { ?>

                               Highcharts.setOptions({
                                lang: {
                                    decimalPoint: '.',
                                    thousandsSep: ','
                                }
                            });
                            $('#gp_topping').highcharts({
                                chart: {
                                    type: 'column'
                                },
                                title: {
                                    text: 'Topping '
                                },
                                subtitle: {
                                    text: ''
                                },
                                data: {
                                    csv: document.getElementById('csv').innerHTML
                                },
                                exporting: {
                                    enabled: false
                                },
                                plotOptions: {
                                    series: {
                                        marker: {
                                            enabled: false
                                        }
                                    }
                                },
                                yAxis: {
                                    min: 0,
                                    title: {
                                        text: 'Values'
                                    }
                                },
                                tooltip: {
                                    headerFormat: '<span style="font-size:13px">{point.key}</span><table>',
                                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                            '<td style="padding:0"><b>{point.y:",".0f}</b></td></tr>',
                                    footerFormat: '</table>',
                                    shared: true,
                                    useHTML: true
                                },
                                series: []
                            });
<?php } ?>


                    }



                    $(document).ready(function () {
<?php if ($type == 'ยอดขาย') { ?>
                            var json_code = '<?php echo isset($res_chart) ? $res_chart : '' ?>';
                            if (json_code != '') {
                                set_chart(json_code);
                            }
<?php } else { ?>
                            set_chart('');
<?php } ?>


                        $('#btn_back').on('click', function () {
                            $('#btn_submit').trigger('click');

                        });



                        $("#chkboxall").click(function (e) {
                            $('.chkbox').prop('checked', this.checked);
                        });

                    });
                    $('#reservation').daterangepicker({
                        format: 'DD/MM/YYYY',
                    },
                            function (start, end, label) {
                                //alert("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));

                                // var _date = start.format('YYYY-MM-DD') +' - '+ end.format('YYYY-MM-DD');
                                //  $(this).val(_date);

                            });
                    $('#report1').dataTable({
                        "searching": true,
                        "ordering": true,
                        "columnDefs": [{
                                "targets": [0],
                                "orderable": false
                            }]
                    });
                    $('#report2').dataTable({
                        "searching": true,
                        "ordering": true,
                        "columnDefs": [{
                                "targets": [0],
                                "orderable": false
                            }]
                    });
                    $('#report3').dataTable({
                        "searching": true,
                        "ordering": true,
                        "columnDefs": [{
                                "targets": [0],
                                "orderable": false
                            }]
                    });
                    $('#report4').dataTable({
                        "searching": true,
                        "ordering": true,
                        "columnDefs": [{
                                "targets": [0],
                                "orderable": false
                            }]
                    });
                    /* Formatting function for row details - modify as you need */



                    $('#example2').DataTable({
                        "searching": true,
                        "ordering": true,
                        "columnDefs": [{
                                "targets": [0, 5],
                                "orderable": false
                            }]
                    });
                    //        function format(d) {
                    //            // `d` is the original data object for the row
                    //
                    //            var html = '';
                    //             //    console.log(d);
                    //                // var data = $.parseJSON(d);
                    //                 console.log(d);
                    //                    $.each(d, function (i, el) {
                    //                    
                    ////                    html += "<tr dat a-active-order-d etail-id=" + active_order_detail_id + " data-qty=" + va l.qty + " data- detail-active_ord er_id=" + active _order_id + " data-detail-menu_id=" + menu _id + " data-detail- m enu_ty p e='" + menu_type_eng + " '>";
                    //                            htm l += "<td><button type='button' clas s='btn btn-xs btn-flat btn-danger' onclick='remove_item(" + id + ")'> <i class='fa fa-t rash'></i></button></td>";
                    //                            html += "<td class='text-center text-bold' style='font-size: 16px;'><p style='color: blue;'>" + val.qty + "</p></td>";
                    //                            html += "<td style='font-size: 16px;'><div class='row'><div class='col-md-7'><span id='menu-name'>" + val.product + "  (" + menu_type + ")</span> " + box_topping + "</div><div class='col-md-5'><span class=''><button type='button' class='btn btn-xs btn-default'  onclick='edit_qty(this, " + id + ")' ><i class='fa fa-edit'></i> จำนวน</button>&nbsp;&nbsp;</span> " + btn_edit_topping + btn_comment + " <label class='control-label " + class_text_color + "' for='inputWarning' style='font-weight: lighter;'> " + text_status + "</label></div></div></td>";
                    //                            html += "<td class='' style='font-size: 13px;' ><span id='str_comment'>" + val.comment + "</span></td>";
                    //                            html += "<td class='text-right' style='font-size: 16px;'>"; html += "<span id='menu-price'>฿ " + val.price + ".00</span>";
                    //                            html += box_topping_total_price;
                    //                            //   html += btn_comment;
                    //                            html += "</td>";
                    //                            html += "<td class='text-right text-bold' style='font-size: 16px;'>฿ " + _sum_total + ".00</td>";
                    ////                            html += "</tr>";
                    //                    });
                    //                    
                    //                    return html;
                    //            }

                </script>

                <style>


                    td.details-control {
                        background: url('<?= base_url() ?>assets/images/details_open.png') no-repeat center center;
                        cursor: pointer;
                    }
                    tr.shown td.details-control {
                        background: url('<?= base_url() ?>assets/images/details_close.png') no-repeat center center;
                    }
                    td{
                        padding: 5px;
                    }

                </style>