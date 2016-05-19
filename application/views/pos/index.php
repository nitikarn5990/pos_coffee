<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="row">
        <div class="col-md-12">
            <a href="<?= base_url() ?>pos/tables" class="btn btn-default <?= $pos == 'tables' ? 'active' : '' ?>" style="font-size: 22px;">
                <span class="badge bg-teal"></span>
                TABLES
            </a>


            <a href="<?= base_url() ?>pos/buy_back_home" class="btn btn-default <?= $pos == 'buy_back_home' ? 'active' : '' ?>" style="font-size: 22px;">
                <span class="badge bg-teal"></span>
                BUY BACK HOME
            </a>


            <a href="<?= base_url() ?>pos/barista" class="btn btn-default <?= $pos == 'barista' ? 'active' : '' ?>" style="font-size: 22px;">
                <span class="badge bg-teal"></span>
                BARISTA
            </a>
        </div>

    </div>



    <ol class="breadcrumb hidden">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <?php if ($pos == 'tables') { ?>
            <div id="tables-control">
                <div class="col-md-5">

                    <form action="<?= base_url() ?>" method="POST">
                        <input type="hidden" id="selected_table" value="">
                        <div class="box box-widget">
                            <div class="box-header with-border bg-purple">
                                <div class="col-md-12">
                                    <div class="pull-left caption font-18">เลือกโต๊ะ</div>
                                    <div class="caption pull-right hidden">
                                        <a href="<?= base_url('category/add') ?>" class="btn btn-success  btn-flat btn-sm" name="btn_submit" value="เพิ่มข้อมูล"><i class="fa fa-plus"></i> เพิ่มข้อมูล</a>
                                        <button type="submit" class="btn btn-danger btn-flat btn-sm" name="btn_submit" value="ลบที่เลือก"><i class="fa fa-trash"></i> ลบที่เลือก</button>

                                    </div>

                                </div>
                            </div>
                            <div class="box-body">
                                <div class="">

                                    <div class="tiles">
                                        <?php
                                        $res_seat_number = $this->db->get_where('seat', array('id' => 1))->row_array()['seat_number'];

                                        for ($i = 0; $i < $res_seat_number; $i++) {
                                            ?>
                                            <div class="col-md-3 col-xs-4 padding-left-0 padding-right-0">
                                                <div class="tile bg-gray"  data-tables="<?= $i + 1 ?>" data-actived="" onclick="select_table(this)">
                                                    <div class="corner">
                                                    </div>
                                                    <div class="check">
                                                    </div>
                                                    <div class="tile-body">
                                                        <i class="fa"><?= $i + 1 ?></i>
                                                    </div>
                                                    <div class="tile-object">

                                                        <div class="name">

                                                        </div>
                                                        <div class="number" id="total_price">

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        <?php }
                                        ?>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <div id="detail-control">
                <div class="col-md-7">
                    <form action="<?= base_url() ?>pos/tables" method="POST">
                        <input type="hidden" class="tables_number" name="tables_number">
                        <div class="box box-widget">
                            <div class="box-header with-border bg-purple">
                                <div class="col-md-12">
                                    <div class="pull-left caption font-18" style="margin-right: 30px;"><i class="fa fa-reorder"></i> โต๊ะที่ <span class="detail-tb-number"></span> </div>
                                    <div class="pull-left caption font-18"></div>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-3 col-xs-12">

                                            <p  style="font-size: 40px; color: blue;" class="detail-tb-number">5 </p>

                                        </div>
                                        <div class="col-md-9 col-xs-12">
                                            <div class="col-md-6 col-xs-6">
                                                <div class="form-horizontal">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-xs-3 text-right">โต๊ะ</label>
                                                        <div class="col-md-9 col-xs-9">
                                                            <p class="form-control-static detail-tb-number"></p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-xs-3 text-right">เวลา</label>
                                                        <div class="col-md-9 col-xs-9">
                                                            <p class="form-control-static" id="detail-created"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xs-6">
                                                <div class="form-horizontal">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-xs-3 text-right">Items</label>
                                                        <div class="col-md-9 col-xs-9">
                                                            <p class="form-control-static"><span id="detail-items"></span>  &nbsp;&nbsp;&nbsp;รายการ</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-xs-3 text-right">รวม</label>
                                                        <div class="col-md-9 col-xs-9">
                                                            <p class="form-control-static text-bold"  style="font-size: 20px;">฿ <span id="detail-total-price">0</span>.00</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-xs-12">
                                        <button type="submit" class="btn btn-flat  btn-microsoft"><i class="fa fa-plus"></i>&nbsp; Add</button>
                                        <button type="button" class="btn btn-flat btn-default" data-toggle="modal" id="btn-move" data-target="#myModal">
                                            <i class="fa fa-edit"></i>&nbsp;ย้ายโต๊ะ
                                        </button>
                                        <button type="button" class="hidden btn btn-flat btn-danger" onclick="check_remove()">
                                            <i class="fa fa-trash"></i>&nbsp;Remove Items
                                        </button>
                                        <button type="button" class="btn btn-flat btn-danger pull-right" onclick="clear_table()">
                                            <i class="fa fa-trash"></i>&nbsp; Clear Table
                                        </button>
                                    </div>
                                    <div class="col-md-12 col-xs-12">
                                        <p class="text-center">Items</p>
                                    </div>
                                    <div class="col-md-12 col-xs-12">
                                        <div class="table-responsive" id="list-menu">
                                            <table class="table table-condensed">

                                                <thead>
                                                <th style="width: 10px">Del</th>
                                                <th  style="width: 40px" class="text-center">Qty</th>
                                                <th class="text-left">Product</th>

                                                <th style="width: 100px" class="text-right ">Price</th>
                                                <th style="width: 100px" class="text-right">Ext.Price</th>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><input type="checkbox" value=""></td>
                                                        <td class="text-center text-bold" style="font-size: 16px;"><p style="color: blue;">0</p></td>
                                                        <td style="font-size: 16px;"></td>

                                                        <td class="text-right" style="font-size: 16px;">
                                                            ฿ 0.00
                                                        </td>
                                                        <td class="text-right text-bold" style="font-size: 16px;">฿ 0.00</td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <input type="hidden" id="last_update" value="">
                                    <input type="hidden" id="num_rows" value="">
                                    <div class="col-md-12 col-xs-12 " >

                                        <button type="button" class="btn btn-block bg-purple" data-toggle="modal"  data-target="#tb-payment" id="btn-tb-payment" disabled="" style="font-size: 18px;">
                                            <i class="fa fa-money "></i>&nbsp;&nbsp;  โต๊ะ <span class="detail-tb-number"></span> ชำระเงิน :&nbsp;&nbsp;&nbsp;&nbsp; ฿ <span id="pay_money"></span> 
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div><!-- /.col -->
            </div>
            <div class="modal fade" id="tb-payment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel" style="font-size: 30px;font-weight: lighter;" >Payment <span style="color: blue;">Table #<span class="detail-tb-number"></span></span></h4>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-3 text-right" style="font-size: 24px;font-weight: lighter;">Total</label>
                                        <div class="col-md-9">
                                            <h3 style="margin: 0;font-size: 40px;font-weight: lighter;">฿ <span id="total-cash">150</span>.00</h3>
                                        </div>
                                    </div>
                                </div>
                                <p>&nbsp;</p>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-3 text-right" style="font-size: 24px;font-weight: lighter;">Cash Receive</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <input type="text" name="cash_receive" id="cash_receive"  class="form-control" style=" font-size: 46px;font-weight: lighter;   height: 55px;">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-default btn-flat" onclick="cal_change_fit()" style="height: 55px;">รับพอดี</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p>&nbsp;</p>
                                <input type="hidden" id="status_ready_pay" value="0">
                                <div class="col-md-12 bg-green-active hidden" id="block_change" style="padding: 5px 0 5px 0;">
                                    <div class="form-group ">
                                        <label class="control-label col-md-3 text-right" style="font-size: 24px;font-weight: lighter;">Change</label>
                                        <div class="col-md-9">
                                            <h3 style="margin: 0;font-size: 40px;font-weight: lighter;">฿ <span id="money_back">150</span>.00</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <div class="pull-left">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" id="copy_receipt" name="Copy Receipt" checked=""> Copy Receipt
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-flat btn-default" data-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-flat btn-success" id="btn-payment" disabled="" onclick="ajax_pay_cash()"><i class="fa fa-thumbs-o-up"  style="padding-left: 10px; font-size: 20px; color: white;"></i>&nbsp; จ่าย</button>
                        </div>
                    </div>
                </div>
            </div>


        <?php } ?>
        <?php if ($pos == 'buy_back_home') { ?>
            <div id="main-backhome-control">
                <form action="<?= base_url('pos/buy_back_home') ?>" method="POST">
                    <input type="hidden" id="last_update_main_backhome" value="">
                    <input type="hidden" id="num_rows_main_backhome" value="">
                    <input type="hidden" id="active_order_id_selected" value="">
                    <div id="tables-control">
                        <div class="col-md-5">

                            <button style="font-weight: 900;background-color: white;" class="col-md-12 col-xs-12 btn btn-lg btn-default" name="buy_back_home" value="new_to_go"> <i class="fa fa-plus" style="font-size: 18px"></i> New TO GO</button>
                            <p>&nbsp;</p>
                            <div id="togo-list">
                                <table class="table table-advance">
                                    <thead>
                                        <tr class="bg-gray">
                                            <th style="font-weight: bold">Queue ID</th>
                                            <th style="font-weight: bold">Items</th>
                                            <th style="font-weight: bold"> Grand Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>

                            </div>

                        </div>


                    </div>
                </form>
            </div>
            <div id="detail-control">
                <div class="col-md-7">
                    <form action="<?= base_url() ?>pos/buy_back_home" method="POST">
                        <input type="hidden" id="active_order_id_selected_detail" name="active_order_id_selected_detail" value="">
                        <div class="box box-widget">
                            <div class="box-header with-border bg-purple">
                                <div class="col-md-12">
                                    <div class="pull-left caption font-18" style="margin-right: 30px;"><i class="fa fa-reorder" style="font-size: 14px;"></i> #Queue <span class="detail-tb-number"></span> </div>
                                    <div class="pull-left caption font-18"></div>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-3 col-xs-12">

                                            <p  style="font-size: 40px; color: blue;" class="">#<span class="detail-tb-number"></span></p>

                                        </div>
                                        <div class="col-md-9 col-xs-12">
                                            <div class="col-md-6 col-xs-6">
                                                <div class="form-horizontal">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-xs-3 text-right">Queue</label>
                                                        <div class="col-md-9 col-xs-9">
                                                            <p class="form-control-static detail-tb-number"></p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-xs-3 text-right">เวลา</label>
                                                        <div class="col-md-9 col-xs-9">
                                                            <p class="form-control-static" id="detail-created"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xs-6">
                                                <div class="form-horizontal">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-xs-3 text-right">Items</label>
                                                        <div class="col-md-9 col-xs-9">
                                                            <p class="form-control-static"><span id="detail-items"></span>  &nbsp;&nbsp;&nbsp;รายการ</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-xs-3 text-right">รวม</label>
                                                        <div class="col-md-9 col-xs-9">
                                                            <p class="form-control-static text-bold"  style="font-size: 20px;">฿ <span id="detail-total-price">0</span>.00</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-xs-12">
                                        <button type="submit" class="btn btn-flat  btn-microsoft"><i class="fa fa-plus"></i>&nbsp; Add</button>

                                        <button type="button" class=" hidden btn btn-flat btn-danger" onclick="check_remove()">
                                            <i class="fa fa-trash"></i>&nbsp;Remove Items
                                        </button>
                                        <button type="button" class=" btn btn-flat btn-danger pull-right" onclick="clear_backhome()">
                                            <i class="fa fa-trash"></i>&nbsp; Clear Order
                                        </button>
                                    </div>
                                    <div class="col-md-12 col-xs-12">
                                        <p class="text-center">Items</p>
                                    </div>
                                    <div class="col-md-12 col-xs-12">
                                        <div class="table-responsive" id="list-menu">

                                            <table class="table table-condensed">

                                                <thead>
                                                <th style="width: 10px">Del</th>
                                                <th  style="width: 40px" class="text-center">Qty</th>
                                                <th class="text-left">Product</th>

                                                <th style="width: 100px" class="text-right ">Price</th>
                                                <th style="width: 100px" class="text-right">Ext.Price</th>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td></td>
                                                        <td class="text-center text-bold" style="font-size: 16px;"><p style="color: blue;">0</p></td>
                                                        <td style="font-size: 16px;"></td>

                                                        <td class="text-right" style="font-size: 16px;">
                                                            ฿ 0.00
                                                        </td>
                                                        <td class="text-right text-bold" style="font-size: 16px;">฿ 0.00</td>
                                                    </tr>


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <input type="hidden" id="last_update" value="">
                                    <input type="hidden" id="num_rows" value="">
                                    <div class="col-md-12 col-xs-12 " >

                                        <button type="button" class="btn btn-block bg-purple" data-toggle="modal"  data-target="#tb-payment" id="btn-tb-payment" disabled="" style="font-size: 18px;">
                                            <i class="fa fa-money "></i>&nbsp;&nbsp;  Queue <span class="detail-tb-number"></span> ชำระเงิน :&nbsp;&nbsp;&nbsp;&nbsp; ฿ <span id="pay_money"></span> 
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div><!-- /.col -->
            </div>

            <div class="modal fade" id="tb-payment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel" style="font-size: 30px;font-weight: lighter;" >Payment <span style="color: blue;">Queue #<span class="detail-tb-number"></span></span></h4>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-3 text-right" style="font-size: 24px;font-weight: lighter;">Total</label>
                                        <div class="col-md-9">
                                            <h3 style="margin: 0;font-size: 40px;font-weight: lighter;">฿ <span id="total-cash">150</span>.00</h3>
                                        </div>
                                    </div>
                                </div>
                                <p>&nbsp;</p>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-3 text-right" style="font-size: 24px;font-weight: lighter;">Cash Receive</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <input type="text" name="cash_receive" id="cash_receive"  class="form-control" style=" font-size: 46px;font-weight: lighter;   height: 55px;">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-default btn-flat" onclick="cal_change_fit()" style="height: 55px;">รับพอดี</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p>&nbsp;</p>
                                <input type="hidden" id="status_ready_pay" value="0">
                                <div class="col-md-12 bg-green-active hidden" id="block_change" style="padding: 5px 0 5px 0;">
                                    <div class="form-group ">
                                        <label class="control-label col-md-3 text-right" style="font-size: 24px;font-weight: lighter;">Change</label>
                                        <div class="col-md-9">
                                            <h3 style="margin: 0;font-size: 40px;font-weight: lighter;">฿ <span id="money_back">150</span>.00</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <div class="pull-left">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" id="copy_receipt" name="Copy Receipt" checked=""> Copy Receipt
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-flat btn-default" data-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-flat btn-success" id="btn-payment" disabled="" onclick="ajax_pay_cash('backhome')"><i class="fa fa-thumbs-o-up"  style="padding-left: 10px; font-size: 20px; color: white;"></i>&nbsp; จ่าย</button>
                        </div>
                    </div>
                </div>
            </div>


        <?php } ?>
        <?php if ($pos == 'barista') { ?>
            <div id="main-backhome-control">
                <form action="<?= base_url('pos/barista') ?>" method="POST">
                    <input type="hidden" id="last_update_main_backhome" value="">
                    <input type="hidden" id="num_rows_main_backhome" value="">
                    <input type="hidden" id="active_order_id_selected" value="">
                    <div id="tables-control">
                        <div class="col-md-5">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box box-widget ">
                                        <div class="box-header with-border bg-warning">
                                            <h3 class="box-title">Waiting</h3>
                                            <div class="box-tools pull-right">
                                                <button class="btn btn-box-tool" data-widget="remove"></button>
                                            </div><!-- /.box-tools -->
                                        </div><!-- /.box-header -->
                                        <div class="box-body">
                                            <div id="togo-list-waiting">
                                                <table class="table table-advance">
                                                    <thead>
                                                        <tr class="bg-gray">
                                                            <th style="font-weight: bold">Queue ID</th>
                                                            <th style="font-weight: bold">Items</th>
                                                            <th style="font-weight: bold"> Grand Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>

                                            </div>
                                        </div><!-- /.box-body -->
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box box-widget  ">
                                        <div class="box-header with-border bg-success">
                                            <h3 class="box-title">Finished</h3>
                                            <div class="box-tools pull-right">
                                                <button class="btn btn-box-tool" data-widget="remove"></button>
                                            </div><!-- /.box-tools -->
                                        </div><!-- /.box-header -->
                                        <div class="box-body">
                                            <div id="togo-list-all-finished">
                                                <table class="table table-advance">
                                                    <thead>
                                                        <tr class="bg-gray">
                                                            <th style="font-weight: bold">Queue ID</th>
                                                            <th style="font-weight: bold">Items</th>
                                                            <th style="font-weight: bold"> Grand Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>

                                            </div>
                                        </div><!-- /.box-body -->
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>
                </form>
            </div>
            <div id="detail-control">
                <div class="col-md-7">
                    <form action="<?= base_url() ?>pos/buy_back_home" method="POST">
                        <input type="hidden" id="active_order_id_selected_detail" name="active_order_id_selected_detail" value="">
                        <div class="box box-widget">
                            <div class="box-header with-border bg-purple">
                                <div class="col-md-12">
                                    <div class="pull-left caption font-18" style="margin-right: 30px;"><i class="fa fa-reorder" style="font-size: 14px;"></i> <span class="char_type">#Queue</span> <span class="detail-tb-number"></span> </div>
                                    <div class="pull-left caption font-18"></div>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-3 col-xs-12">

                                            <p  style="font-size: 40px; color: blue;" class=""><span class="char_type">#</span><span class="detail-tb-number"></span></p>

                                        </div>
                                        <div class="col-md-9 col-xs-12">
                                            <div class="col-md-6 col-xs-6">
                                                <div class="form-horizontal">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-xs-3 text-right"><span class="char_type">Queue</span></label>
                                                        <div class="col-md-9 col-xs-9">
                                                            <p class="form-control-static detail-tb-number"></p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-xs-3 text-right">เวลา</label>
                                                        <div class="col-md-9 col-xs-9">
                                                            <p class="form-control-static" id="detail-created"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xs-6">
                                                <div class="form-horizontal">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-xs-3 text-right">Items</label>
                                                        <div class="col-md-9 col-xs-9">
                                                            <p class="form-control-static"><span id="detail-items"></span>  &nbsp;&nbsp;&nbsp;รายการ</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-xs-3 text-right">รวม</label>
                                                        <div class="col-md-9 col-xs-9">
                                                            <p class="form-control-static text-bold"  style="font-size: 20px;">฿ <span id="detail-total-price">0</span>.00</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-xs-12">
                                        <button type="submit" class="btn btn-flat hidden btn-microsoft"><i class="fa fa-plus"></i>&nbsp; Add</button>
                                        <button type="button" class="btn btn-flat  bg-green" onclick="check_all_finished()"><i class="fa fa-check-square-o"></i>&nbsp; All Finished</button>
                                        <button type="button" class=" hidden btn btn-flat btn-danger" onclick="check_remove()">
                                            <i class="fa fa-trash"></i>&nbsp;Remove Items
                                        </button>
                                        <button type="button" class="hidden btn btn-flat btn-danger pull-right" onclick="clear_backhome()">
                                            <i class="fa fa-trash"></i>&nbsp; Clear Order
                                        </button>
                                    </div>
                                    <div class="col-md-12 col-xs-12">
                                        <p class="text-center">Items</p>
                                    </div>
                                    <div class="col-md-12 col-xs-12">
                                        <div class="table-responsive" id="list-menu">

                                            <table class="table table-condensed">

                                                <thead>
                                                <th style="width: 10px">Status</th>
                                                <th  style="width: 40px" class="text-center">Qty</th>
                                                <th class="text-left">Product</th>

                                                <th style="width: 100px" class="text-right ">Price</th>
                                                <th style="width: 100px" class="text-right">Ext.Price</th>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td></td>
                                                        <td class="text-center text-bold" style="font-size: 16px;"><p style="color: blue;">0</p></td>
                                                        <td style="font-size: 16px;"></td>

                                                        <td class="text-right" style="font-size: 16px;">
                                                            ฿ 0.00
                                                        </td>
                                                        <td class="text-right text-bold" style="font-size: 16px;">฿ 0.00</td>
                                                    </tr>


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <input type="hidden" id="last_update" value="">
                                    <input type="hidden" id="num_rows" value="">
                                    <div class="col-md-12 col-xs-12 hidden" >

                                        <button type="button" class="btn btn-block bg-purple" data-toggle="modal"  data-target="#tb-payment" id="btn-tb-payment" disabled="" style="font-size: 18px;">
                                            <i class="fa fa-money "></i>&nbsp;&nbsp;  <span class="char_type">Queue</span> <span class="detail-tb-number"></span> ชำระเงิน :&nbsp;&nbsp;&nbsp;&nbsp; ฿ <span id="pay_money"></span> 
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div><!-- /.col -->
            </div>

            <div class="modal fade" id="tb-payment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel" style="font-size: 30px;font-weight: lighter;" >Payment <span style="color: blue;" class="char_type">Queue #</span><span class="detail-tb-number" style="color: blue;"></span></h4>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-3 text-right" style="font-size: 24px;font-weight: lighter;">Total</label>
                                        <div class="col-md-9">
                                            <h3 style="margin: 0;font-size: 40px;font-weight: lighter;">฿ <span id="total-cash">150</span>.00</h3>
                                        </div>
                                    </div>
                                </div>
                                <p>&nbsp;</p>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-3 text-right" style="font-size: 24px;font-weight: lighter;">Cash Receive</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <input type="text" name="cash_receive" id="cash_receive"  class="form-control" style=" font-size: 46px;font-weight: lighter;   height: 55px;">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-default btn-flat" onclick="cal_change_fit()" style="height: 55px;">รับพอดี</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p>&nbsp;</p>
                                <input type="hidden" id="status_ready_pay" value="0">
                                <div class="col-md-12 bg-green-active hidden" id="block_change" style="padding: 5px 0 5px 0;">
                                    <div class="form-group ">
                                        <label class="control-label col-md-3 text-right" style="font-size: 24px;font-weight: lighter;">Change</label>
                                        <div class="col-md-9">
                                            <h3 style="margin: 0;font-size: 40px;font-weight: lighter;">฿ <span id="money_back">150</span>.00</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <div class="pull-left">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" id="copy_receipt" name="Copy Receipt" checked=""> Copy Receipt
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-flat btn-default" data-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-flat btn-success" id="btn-payment" disabled="" onclick="ajax_pay_cash('backhome')"><i class="fa fa-thumbs-o-up"  style="padding-left: 10px; font-size: 20px; color: white;"></i>&nbsp; จ่าย</button>
                        </div>
                    </div>
                </div>
            </div>


        <?php } ?>

    </div><!-- /.row -->
</section><!-- /.content -->


<!-- Button trigger modal -->


<!-- Modal -->
<form action="<?= base_url('pos/move_table') ?>" method="POST">
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">ย้ายทั้งโต๊ะ, กรุณาใส่หมายเลขโต๊ะปลายทาง</h4>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="old_table" id="old_table">
                            <input type="text"  name="new_table" id="new_table" class="form-control" data-validation='required,number'>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">OK</button>
                </div>
            </div>
        </div>
    </div>
</form>





<script src="<?= base_url('assets/js/bootbox.min.js') ?>"></script>
<script>

                                //focus input
                                $('#tb-payment').on('shown.bs.modal', function (e) {
                                    $('#cash_receive').val('');
                                    $('#cash_receive').focus();
                                    var total_payment = $('#detail-total-price').text();
                                    $('#total-cash').text(total_payment);

                                    var tables_number = $('.tables_number').val();
                                    $('.detail-tb-number').text(tables_number);

                                    cal_money();

                                });
                                $(document).ready(function () {

                                    $("#chkboxall").click(function (e) {
                                        $('.chkbox').prop('checked', this.checked);
                                    });


                                    $('[data-tables=1]').trigger('click');

                                    $('#checkAll').click(function () {
                                        $('#list-menu table input:checkbox').prop('checked', this.checked);
                                    });




                                });

                                function row_select(ele) {

                                    $(ele).closest('tbody').find('tr').removeClass('bg-purple');
                                    $(ele).addClass('bg-purple');
                                    $('#active_order_id_selected').val($(ele).attr('data-active-order-id'));
                                    $('#active_order_id_selected_detail').val($(ele).attr('data-active-order-id'));

                                }


<?php if ($pos == 'tables') { ?>
                                    var iCountDown = setInterval("SumMainTable()", 1000);
                                    var iCountDown2 = setInterval("SumDetailTable()", 1000);
<?php } ?>
<?php if ($pos == 'buy_back_home') { ?>

                                    //back home
                                    var iCountDown3 = setInterval("SumMainTableBackHome()", 1000);
                                    var iCountDown4 = setInterval("SumDetailTableBackHome()", 1000);
<?php } ?>

<?php if ($pos == 'barista') { ?>

                                    //back home
                                    var iCountDown5 = setInterval("SumMainTableBarista()", 1000);
                                    var iCountDown6 = setInterval("SumDetailTableBarista()", 1000);
<?php } ?>

                                function SumMainTable() {

                                    $.ajax({
                                        type: 'GET',
                                        url: '<?= base_url('pos/ajax_sum_main_table') ?>',
                                        // data: {category_id: id},
                                        //  dataType:'json',
                                        success: function (data2) {
                                            var data = $.parseJSON(data2);
                                            $('.tiles').find('.bg-purple-light').removeClass('bg-purple-light');
                                            $('.tiles').find('.name').text('');
                                            $('.tiles').find('.number').text('');

                                            $.each(data, function (i, val) {

                                                var tables_number = val.tables_number;
                                                var total_price = val.total;


                                                $('.tiles').find("[data-tables='" + tables_number + "']").addClass('bg-purple-light').find('.name').text("รวม").find('#total_price').text("฿ " + total_price);
                                                $('.tiles').find("[data-tables='" + tables_number + "']").addClass('bg-purple-light').find('#total_price').text("฿ " + total_price);
                                            });
                                        }
                                    });

                                }

                                function SumMainTableBackHome() {


                                    var tr = '';
                                    var num_rows = '';

                                    var total_price = '';
                                    var active_order_id = '';
                                    var total_qty = '';

                                    $.ajax({
                                        type: 'GET',
                                        url: '<?= base_url('pos/ajax_sum_main_table_backhome') ?>',
                                        success: function (data2) {

                                            var data = $.parseJSON(data2);


                                            $.each(data, function (i, val) {

                                                // if ($("#last_update_main_backhome").val() !== val.last_update && $("#num_rows_main_backhome").val() !== val.num_rows) {
                                                num_rows = val.num_rows;
                                                // last_update = val.last_update;
                                                total_price = val.total;
                                                active_order_id = val.active_order_id;
                                                total_qty = val.total_qty;

                                                tr += "<tr class='' onclick='row_select(this)' data-active-order-id=" + active_order_id + " data-queue=" + active_order_id + ">";
                                                tr += "<td>#" + active_order_id + "</td>";
                                                tr += "<td>" + total_qty + "</td>";
                                                tr += "<td>฿  " + total_price + ".00</td>";
                                                tr += " </tr>";

                                            });
                                            //   alert(active_order_id);
                                            //     $('#active_order_id_selected').val(active_order_id);
                                            $("#main-backhome-control table tbody").html(tr);
                                            var active_order_id_selected = $('#active_order_id_selected').val();
                                            $('#togo-list table tbody').find("[data-active-order-id=" + active_order_id_selected + "]").addClass('bg-purple');

                                            $('#num_rows_main_backhome').val(num_rows);


                                        }

                                    });
                                }

                                function SumMainTableBarista() {


                                    var tr_0 = '';
                                    var tr_1 = '';
                                    var num_rows = '';

                                    var total_price = '';
                                    var active_order_id = '';
                                    var total_qty = '';
                                    var tables_number = '';
                                    var status = '';

                                    $.ajax({
                                        type: 'GET',
                                        url: '<?= base_url('pos/ajax_sum_main_table_barista') ?>',
                                        success: function (data2) {

                                            var data = $.parseJSON(data2);


                                            $.each(data, function (i, val) {

                                                // if ($("#last_update_main_backhome").val() !== val.last_update && $("#num_rows_main_backhome").val() !== val.num_rows) {
                                                num_rows = val.num_rows;
                                                // last_update = val.last_update;
                                                total_price = val.total;
                                                active_order_id = val.active_order_id;
                                                total_qty = val.total_qty;
                                                tables_number = val.tables_number;

                                                //ถ้าเสร็จหมด เป็น 1 ยังไม่เสร็จ เป็น 0
                                                status = val.status;

                                                var char_type = '';
                                                var tableOrderQ = '';
                                                if (tables_number === '0') {
                                                    char_type = '#';
                                                    tableOrderQ = active_order_id;

                                                } else {
                                                    char_type = 'T.';
                                                    tableOrderQ = tables_number;
                                                }
                                                if (status === '0') {
                                                    tr_0 += "<tr class='' onclick='row_select(this)' data-active-order-id=" + active_order_id + " data-queue=" + active_order_id + ">";
                                                    tr_0 += "<td>" + char_type + tableOrderQ + "</td>";
                                                    tr_0 += "<td>" + total_qty + "</td>";
                                                    tr_0 += "<td>฿  " + total_price + ".00</td>";
                                                    tr_0 += "</tr>";
                                                } else {
                                                    tr_1 += "<tr class='' onclick='row_select(this)' data-active-order-id=" + active_order_id + " data-queue=" + active_order_id + ">";
                                                    tr_1 += "<td>" + char_type + tableOrderQ + "</td>";
                                                    tr_1 += "<td>" + total_qty + "</td>";
                                                    tr_1 += "<td>฿  " + total_price + ".00</td>";
                                                    tr_1 += "</tr>";

                                                }



                                            });
                                            $("#togo-list-waiting table tbody").html(tr_0);
                                            $("#togo-list-all-finished table tbody").html(tr_1);

                                            var active_order_id_selected = $('#active_order_id_selected').val();

                                            $('#tables-control table tbody').find("[data-active-order-id=" + active_order_id_selected + "]").addClass('bg-purple');



                                            $('#num_rows_main_backhome').val(num_rows);


                                        }

                                    });
                                }

                                function check_remove() {

                                    $('#list-menu input[type="checkbox"]').each(function () {
                                        if ($(this).is(":checked")) {

                                            var active_order_id = $(this).closest('tr').attr('data-detail-active_order_id');
                                            var menu_id = $(this).closest('tr').attr('data-detail-menu_id');
                                            var menu_type = $(this).closest('tr').attr('data-detail-menu_type');

                                            $.ajax({
                                                type: 'get',
                                                url: '<?= base_url('pos/ajax_remove_items') ?>',
                                                data: {
                                                    active_order_id: active_order_id,
                                                    menu_id: menu_id,
                                                    menu_type: menu_type,
                                                },
                                                //  dataType:'json',
                                                success: function (data) {
                                                    // console.log(data);
                                                }
                                            });



                                        }
                                    });

                                }
                                function ajax_pay_cash(condi) {
                                    if (condi === 'backhome') {
                                        var active_order_id = $("#active_order_id_selected_detail").val();

                                        if (active_order_id !== '') {
                                            $.ajax({
                                                type: 'get',
                                                url: '<?= base_url('pos/ajax_pay_cash_backhome') ?>',
                                                data: {
                                                    active_order_id: active_order_id,
                                                },
                                                //  dataType:'json',
                                                success: function (data) {

                                                    var data2 = $.parseJSON(data);

                                                    if (data2.status === 'success') {
                                                        //print
                                                        //data2.order_id 
                                                        $('#active_order_id_selected').val('0');
                                                        if ($('#copy_receipt').is(":checked")) {
                                                            $('#tb-payment').modal('hide');

                                                        }
                                                    }

                                                }
                                            });
                                        }
                                    } else {

                                        var tables_number = $(".tables_number").val();


                                        if (tables_number !== '') {
                                            $.ajax({
                                                type: 'get',
                                                url: '<?= base_url('pos/ajax_pay_cash') ?>',
                                                data: {
                                                    tables_number: tables_number,
                                                },
                                                //  dataType:'json',
                                                success: function (data) {

                                                    var data2 = $.parseJSON(data);

                                                    if (data2.status === 'success') {
                                                        //print
                                                        //data2.order_id 
                                                        if ($('#copy_receipt').is(":checked")) {
                                                            $('#tb-payment').modal('hide');

                                                        }
                                                    }

                                                }
                                            });
                                        }
                                    }
                                }
                                function clear_table() {
                                    bootbox.confirm("Are you sure?", function (result) {
                                        if (result) {
                                            var tables_number = $(".tables_number").val();
                                            if (tables_number !== '') {
                                                $.ajax({
                                                    type: 'get',
                                                    url: '<?= base_url('pos/ajax_clear_table') ?>',
                                                    data: {
                                                        tables_number: tables_number,
                                                    },
                                                    //  dataType:'json',
                                                    success: function (data) {
                                                        // console.log(data);
                                                    }
                                                });
                                            }
                                        }
                                    });


                                }

                                function check_finished(order_detail_id) {

                                    if (order_detail_id !== '') {

                                        $('#list-menu').block({
                                            message: '<h5>Processing</h5>',
                                            css: {backgroundColor: 'white'}
                                        });
                                        $.ajax({
                                            type: 'get',
                                            url: '<?= base_url('pos/ajax_check_finished') ?>',
                                            data: {
                                                order_detail_id: order_detail_id,
                                            },
                                            //  dataType:'json',
                                            success: function (data) {
                                                // console.log(data);
                                                $('#list-menu').unblock();
                                            }
                                        });
                                    }

                                }
                                function check_all_finished() {

                                    var active_order_id_selected = $("#active_order_id_selected").val();
                                    if (active_order_id_selected !== '') {
                                        $('#list-menu').block({
                                            message: '<h5>Processing</h5>',
                                            css: {backgroundColor: 'white'}
                                        });
                                        $.ajax({
                                            type: 'get',
                                            url: '<?= base_url('pos/ajax_check_all_finished') ?>',
                                            data: {
                                                active_order_id_selected: active_order_id_selected
                                            },
                                            //  dataType:'json',
                                            success: function (data) {
                                                $('#list-menu').unblock();
                                            }
                                        });
                                    }

                                }
                                function clear_backhome() {

                                    bootbox.confirm("Are you sure?", function (result) {
                                        if (result) {
                                            var active_order_id_selected = $("#active_order_id_selected").val();

                                            if (active_order_id_selected !== '') {
                                                $.ajax({
                                                    type: 'get',
                                                    url: '<?= base_url('pos/ajax_clear_backhome') ?>',
                                                    data: {
                                                        active_order_id_selected: active_order_id_selected,
                                                    },
                                                    //  dataType:'json',
                                                    success: function (data) {
                                                        //  console.log(data);
                                                    }
                                                });
                                            }
                                        }

                                    });

                                }
                                function remove_item(item_id) {


                                    if (item_id !== '') {
                                        $.ajax({
                                            type: 'get',
                                            url: '<?= base_url('pos/ajax_remove_item') ?>',
                                            data: {
                                                item_id: item_id,
                                            },
                                            //  dataType:'json',
                                            success: function (data) {
                                                // console.log(data);
                                            }
                                        });
                                    }


                                }


                                function edit_qty(ele) {

                                    var active_order_id = $(ele).closest('tr').attr('data-detail-active_order_id');
                                    var menu_id = $(ele).closest('tr').attr('data-detail-menu_id');
                                    var menu_type = $(ele).closest('tr').attr('data-detail-menu_type');
                                    var qty = $(ele).closest('tr').attr('data-qty');

                                    bootbox.prompt({
                                        title: "แก้ไขจำนวน",
                                        value: qty,
                                        callback: function (result) {
                                            // console.log(result);
                                            if (result === null) {

                                            } else {
                                                if ($.isNumeric(result)) {
                                                    $.ajax({
                                                        type: 'get',
                                                        url: '<?= base_url('pos/ajax_edit_items') ?>',
                                                        data: {
                                                            active_order_id: active_order_id,
                                                            menu_id: menu_id,
                                                            menu_type: menu_type,
                                                            qty: result,
                                                        },
                                                        //  dataType:'json',
                                                        success: function (data) {
                                                            // console.log(data);
                                                        }
                                                    });
                                                } else {
                                                    alert('ใส่เฉพาะตัวเลข');
                                                }
                                            }
                                        }
                                    });
                                }


                                function SumDetailTable(open_detail) {

                                    var tables_number = $("#selected_table").val();
                                    var html = '';


                                    if (tables_number !== '') {

                                        // console.log(tables_number);
                                        $.ajax({
                                            type: 'get',
                                            url: '<?= base_url('pos/ajax_sum_detail_table') ?>',
                                            data: {tables_number: tables_number},
                                            //  dataType:'json',
                                            success: function (data) {
                                                var data2 = $.parseJSON(data);
                                                // console.log(data2[0].last_update);
                                                if (data2.length > 0) {
                                                    if (open_detail === '') {


                                                        if ($("#last_update").val() === data2[0].last_update && $("#num_rows").val() === data2[0].num_rows) {
                                                            //  console.log(data2[0].num_rows);
                                                            //  console.log('No update');

                                                        } else {
                                                            //wait for change
                                                            $.each(data2, function (i, val) {

                                                                var id = val.id;
                                                                var total_price = val.total_price;
                                                                var total_qty = val.total_qty;

                                                                var active_order_id = val.active_order_id;
                                                                var menu_id = val.menu_id;
                                                                var menu_type = val.menu_type;
                                                                var menu_type_eng = val.menu_type_eng;
                                                                var status = val.status;
                                                                /// console.log(status);
                                                                var qty = val.qty;
                                                                var finished_qty = val.finished_qty;
                                                                var still_waiting = parseInt(qty) - parseInt(finished_qty);


                                                                var class_text_color = '';
                                                                var text_status = '';
                                                                if (parseInt(still_waiting) > 0) {
                                                                    class_text_color = 'text-yellow';
                                                                    text_status = 'Waiting for ' + still_waiting;
                                                                } else {
                                                                    class_text_color = 'text-green';
                                                                    text_status = 'finished';
                                                                }




                                                                $(".detail-tb-number").text(tables_number);
                                                                $("#detail-created").text(val.created_at);
                                                                $("#detail-items").text(total_qty);
                                                                $("#detail-total-price").text(total_price);
                                                                $("#pay_money").text(total_price);
                                                                //set change
                                                                $("#last_update").val(val.last_update);
                                                                $("#num_rows").val(val.num_rows);
                                                                var _sum_total = parseInt(val.qty) * parseInt(val.price);

                                                                html += "<tr data-qty=" + val.qty + " data-detail-active_order_id=" + active_order_id + " data-detail-menu_id=" + menu_id + " data-detail-menu_type='" + menu_type_eng + "'>";
                                                                html += "<td><button type='button' class='btn btn-xs btn-flat btn-danger' onclick='remove_item(" + id + ")'><i class='fa fa-trash'></i></button></td>";
                                                                html += "<td class='text-center text-bold' style='font-size: 16px;'><p style='color: blue;'>" + val.qty + "</p></td>";
                                                                html += "<td style='font-size: 16px;'>" + val.product + "  (" + menu_type + ")<span class='pull-right'><button type='button' class='btn btn-xs btn-default'  onclick='edit_qty(this)' ><i class='fa fa-edit'></i> จำนวน</button>&nbsp;&nbsp;<label class='control-label " + class_text_color + "' for='inputWarning' style='font-weight: lighter;'> " + text_status + "</label></span>  </td>";
                                                                html += "<td class='text-right' style='font-size: 16px;'>";
                                                                html += "<span>฿ " + val.price + "</span>";
                                                                html += "</td>";
                                                                html += "<td class='text-right text-bold' style='font-size: 16px;'>฿ " + _sum_total + "</td>";
                                                                html += "</tr>";
                                                            });
                                                            $("#list-menu table tbody").html(html);
                                                        }
                                                    } else {

                                                        //click see detail
                                                        //wait for change
                                                        $.each(data2, function (i, val) {

                                                            var id = val.id;
                                                            var total_price = val.total_price;
                                                            var total_qty = val.total_qty;

                                                            var active_order_id = val.active_order_id;
                                                            var menu_id = val.menu_id;
                                                            var menu_type = val.menu_type;
                                                            var menu_type_eng = val.menu_type_eng;
                                                            var status = val.status;
                                                            /// console.log(status);
                                                            var qty = val.qty;
                                                            var finished_qty = val.finished_qty;
                                                            var still_waiting = parseInt(qty) - parseInt(finished_qty);


                                                            var class_text_color = '';
                                                            var text_status = '';
                                                            if (parseInt(still_waiting) > 0) {
                                                                class_text_color = 'text-yellow';
                                                                text_status = 'Waiting for ' + still_waiting;
                                                            } else {
                                                                class_text_color = 'text-green';
                                                                text_status = 'finished';
                                                            }




                                                            $(".detail-tb-number").text(tables_number);
                                                            $("#detail-created").text(val.created_at);
                                                            $("#detail-items").text(total_qty);
                                                            $("#detail-total-price").text(total_price);
                                                            $("#pay_money").text(total_price);
                                                            //set change
                                                            $("#last_update").val(val.last_update);
                                                            $("#num_rows").val(val.num_rows);
                                                            var _sum_total = parseInt(val.qty) * parseInt(val.price);

                                                            html += "<tr data-qty=" + val.qty + " data-detail-active_order_id=" + active_order_id + " data-detail-menu_id=" + menu_id + " data-detail-menu_type='" + menu_type_eng + "'>";
                                                            html += "<td><button type='button' class='btn btn-xs btn-flat btn-danger' onclick='remove_item(" + id + ")'><i class='fa fa-trash'></i></button></td>";
                                                            html += "<td class='text-center text-bold' style='font-size: 16px;'><p style='color: blue;'>" + val.qty + "</p></td>";
                                                            html += "<td style='font-size: 16px;'>" + val.product + "  (" + menu_type + ")<span class='pull-right'><button type='button' class='btn btn-xs btn-default'  onclick='edit_qty(this)' ><i class='fa fa-edit'></i> จำนวน</button>&nbsp;&nbsp;<label class='control-label " + class_text_color + "' for='inputWarning' style='font-weight: lighter;'> " + text_status + "</label></span>  </td>";
                                                            html += "<td class='text-right' style='font-size: 16px;'>";
                                                            html += "<span>฿ " + val.price + "</span>";
                                                            html += "</td>";
                                                            html += "<td class='text-right text-bold' style='font-size: 16px;'>฿ " + _sum_total + "</td>";
                                                            html += "</tr>";
                                                        });
                                                        $("#list-menu table tbody").html(html);
                                                    }
                                                } else {
                                                    $("#list-menu table tbody").html(html);
                                                    $(".detail-tb-number").text(tables_number);
                                                    $("#detail-items").text('');
                                                    $("#detail-created").text('');
                                                    $("#detail-total-price").text('0');
                                                    $("#pay_money").text('0');
                                                    $(".detail-tb-number").text(tables_number);
                                                }
                                            }
                                        });
                                    }

                                    //check open payment
                                    if (parseInt($('#detail-total-price').text()) > 0) {
                                        $('#btn-tb-payment').prop('disabled', false);
                                    } else {
                                        $('#btn-tb-payment').prop('disabled', true);
                                    }

                                }
                                function SumDetailTableBackHome(open_detail) {

                                    var active_order_id_selected = $("#active_order_id_selected").val();
                                    var html = '';


                                    if (active_order_id_selected !== '') {

                                        // console.log(tables_number);
                                        $.ajax({
                                            type: 'get',
                                            url: '<?= base_url('pos/ajax_sum_detail_table_backhome') ?>',
                                            data: {active_order_id_selected: active_order_id_selected},
                                            //  dataType:'json',
                                            success: function (data) {
                                                var data2 = $.parseJSON(data);
                                                // console.log(data2[0].last_update);
                                                if (data2.length > 0) {
                                                    if (open_detail === '') {
                                                        if ($("#last_update").val() === data2[0].last_update && $("#num_rows").val() === data2[0].num_rows) {


                                                        } else {
                                                            //wait for change
                                                            $.each(data2, function (i, val) {

                                                                var id = val.id;
                                                                var total_price = val.total_price;
                                                                var total_qty = val.total_qty;

                                                                var active_order_id = val.active_order_id;
                                                                var menu_id = val.menu_id;
                                                                var menu_type = val.menu_type;
                                                                var menu_type_eng = val.menu_type_eng;
                                                                var status = val.status;
                                                                //  console.log(status);


                                                                var qty = val.qty;
                                                                var finished_qty = val.finished_qty;
                                                                var still_waiting = parseInt(qty) - parseInt(finished_qty);


                                                                var class_text_color = '';
                                                                var text_status = '';
                                                                if (parseInt(still_waiting) > 0) {
                                                                    class_text_color = 'text-yellow';
                                                                    text_status = 'Waiting for ' + still_waiting;
                                                                } else {
                                                                    class_text_color = 'text-green';
                                                                    text_status = 'finished';
                                                                }



                                                                $(".detail-tb-number").text(active_order_id_selected);
                                                                $("#detail-created").text(val.created_at);
                                                                $("#detail-items").text(total_qty);
                                                                $("#detail-total-price").text(total_price);
                                                                $("#pay_money").text(total_price);
                                                                //set change
                                                                $("#last_update").val(val.last_update);
                                                                $("#num_rows").val(val.num_rows);
                                                                var _sum_total = parseInt(val.qty) * parseInt(val.price);

                                                                html += "<tr class='' data-id=" + id + " data-qty=" + val.qty + " data-detail-active_order_id=" + active_order_id + " data-detail-menu_id=" + menu_id + " data-detail-menu_type='" + menu_type_eng + "'>";
                                                                html += "<td><button type='button' class='btn btn-xs btn-flat btn-danger' onclick='remove_item(" + id + ")'><i class='fa fa-trash'></i></button></td>";
                                                                html += "<td class='text-center text-bold' style='font-size: 16px;'><p style='color: blue;'>" + val.qty + "</p></td>";
                                                                html += "<td style='font-size: 16px;'>" + val.product + "  (" + menu_type + ")<span class='pull-right'><button type='button' class='btn btn-xs btn-default'  onclick='edit_qty(this)' ><i class='fa fa-edit'></i> จำนวน</button>&nbsp;&nbsp;<label class='control-label " + class_text_color + "' for='inputWarning' style='font-weight: lighter;'> " + text_status + "</label></span>  </td>";
                                                                html += "<td class='text-right' style='font-size: 16px;'>";
                                                                html += "<span>฿ " + val.price + "</span>";
                                                                html += "</td>";
                                                                html += "<td class='text-right text-bold' style='font-size: 16px;'>฿ " + _sum_total + "</td>";
                                                                html += "</tr>";
                                                            });
                                                            $("#list-menu table tbody").html(html);
                                                        }


                                                    } else {

                                                        //click see detail
                                                        $.each(data2, function (i, val) {
                                                            var id = val.id;
                                                            var total_price = val.total_price;
                                                            var total_qty = val.total_qty;

                                                            var active_order_id = val.active_order_id;
                                                            var menu_id = val.menu_id;
                                                            var menu_type = val.menu_type;
                                                            var menu_type_eng = val.menu_type_eng;
                                                            var status = val.status;
                                                            //console.log(status);


                                                            var qty = val.qty;
                                                            var finished_qty = val.finished_qty;
                                                            var still_waiting = parseInt(qty) - parseInt(finished_qty);


                                                            var class_text_color = '';
                                                            var text_status = '';
                                                            if (parseInt(still_waiting) > 0) {
                                                                class_text_color = 'text-yellow';
                                                                text_status = 'Waiting for ' + still_waiting;
                                                            } else {
                                                                class_text_color = 'text-green';
                                                                text_status = 'finished';
                                                            }


                                                            $(".detail-tb-number").text(active_order_id_selected);
                                                            $("#detail-created").text(val.created_at);
                                                            $("#detail-items").text(total_qty);
                                                            $("#detail-total-price").text(total_price);
                                                            $("#pay_money").text(total_price);
                                                            //set change
                                                            $("#last_update").val(val.last_update);
                                                            $("#num_rows").val(val.num_rows);
                                                            var _sum_total = parseInt(val.qty) * parseInt(val.price);

                                                            html += "<tr  class=''  data-id=" + id + " data-qty=" + val.qty + " data-detail-active_order_id=" + active_order_id + " data-detail-menu_id=" + menu_id + " data-detail-menu_type='" + menu_type_eng + "'>";
                                                            html += "<td><button type='button' class='btn btn-xs btn-flat btn-danger' onclick='remove_item(" + id + ")'><i class='fa fa-trash'></i></button></td>";
                                                            html += "<td class='text-center text-bold' style='font-size: 16px;'><p style='color: blue;'>" + val.qty + "</p></td>";
                                                            html += "<td style='font-size: 16px;'>" + val.product + "  (" + menu_type + ")<span class='pull-right'><button type='button' class='btn btn-xs btn-default'  onclick='edit_qty(this)' ><i class='fa fa-edit'></i> จำนวน</button>&nbsp;&nbsp;<label class='control-label " + class_text_color + "' for='inputWarning' style='font-weight: lighter;'> " + text_status + "</label></span>  </td>";
                                                            html += "<td class='text-right' style='font-size: 16px;'>";
                                                            html += "<span>฿ " + val.price + "</span>";
                                                            html += "</td>";
                                                            html += "<td class='text-right text-bold' style='font-size: 16px;'>฿ " + _sum_total + "</td>";
                                                            html += "</tr>";
                                                        });
                                                        $("#list-menu table tbody").html(html);
                                                    }
                                                } else {
                                                    $("#list-menu table tbody").html(html);
                                                    $(".detail-tb-number").text(active_order_id_selected);
                                                    $("#detail-items").text('');
                                                    $("#detail-created").text('');
                                                    $("#detail-total-price").text('0');
                                                    $("#pay_money").text('0');
                                                    $(".detail-tb-number").text(active_order_id_selected);
                                                }
                                            }
                                        });
                                    }

                                    //check open payment
                                    if (parseInt($('#detail-total-price').text()) > 0) {
                                        $('#btn-tb-payment').prop('disabled', false);
                                    } else {
                                        $('#btn-tb-payment').prop('disabled', true);
                                    }

                                }

                                function SumDetailTableBarista(open_detail) {

                                    var active_order_id_selected = $("#active_order_id_selected").val();
                                    var html = '';



                                    if (active_order_id_selected !== '') {

                                        // console.log(tables_number);
                                        $.ajax({
                                            type: 'get',
                                            url: '<?= base_url('pos/ajax_sum_detail_table_backhome') ?>',
                                            data: {active_order_id_selected: active_order_id_selected},
                                            //  dataType:'json',
                                            success: function (data) {
                                                var data2 = $.parseJSON(data);
                                                // console.log(data2[0].last_update);
                                                if (data2.length > 0) {
                                                    if (open_detail === '') {
                                                        if ($("#last_update").val() === data2[0].last_update && $("#num_rows").val() === data2[0].num_rows) {


                                                        } else {
                                                            //wait for change
                                                             $.each(data2, function (i, val) {
                                                            var id = val.id;
                                                            var total_price = val.total_price;
                                                            var total_qty = val.total_qty;

                                                            var active_order_id = val.active_order_id;
                                                            var menu_id = val.menu_id;
                                                            var menu_type = val.menu_type;
                                                            var menu_type_eng = val.menu_type_eng;
                                                            var status = val.status;

                                                            var tables_number = val.tables_number;
                                                            // console.log(tables_number);

                                                            var class_text_color = '';
                                                            var text_status = '';
                                                            var bg = '';
                                                            var icon = '';
                                                            
                                                            //
                                                               var qty = val.qty;
                                                                var finished_qty = val.finished_qty;
                                                                var still_waiting = parseInt(qty) - parseInt(finished_qty);


                                                                var class_text_color = '';
                                                                var text_status = '';
                                                                
//                                                                if (parseInt(still_waiting) > 0) {
//                                                                    class_text_color = 'text-yellow';
//                                                                    text_status = 'Waiting for ' + still_waiting;
//                                                                } else {
//                                                                    class_text_color = 'text-green';
//                                                                    text_status = 'finished';
//                                                                }
                                                                //

                                                            
                                                            
                                                            
                                                            
                                                              if (parseInt(still_waiting) > 0) {
                                                                class_text_color = 'text-yellow';
                                                              text_status = 'Waiting for ' + still_waiting;
                                                                icon = 'fa-square-o fa-2x ';
                                                                bg = 'bg-warning';
                                                            } else {
                                                                class_text_color = 'text-green';
                                                                text_status = 'finished';
                                                                icon = 'fa-check-square-o fa-2x ';
                                                                bg = 'bg-success';
                                                            }
                                                            

                                                            var char_type = '';
                                                            var TablesOrTogo = '';


                                                            if (tables_number === '0') {
                                                                char_type = '#';
                                                                TablesOrTogo = active_order_id;
                                                            } else {
                                                                char_type = 'T. ';
                                                                TablesOrTogo = tables_number;
                                                            }


                                                            $('.char_type').text(char_type);
                                                            $(".detail-tb-number").text(TablesOrTogo);
                                                            $("#detail-created").text(val.created_at);
                                                            $("#detail-items").text(total_qty);
                                                            $("#detail-total-price").text(total_price);
                                                            $("#pay_money").text(total_price);
                                                            //set change
                                                            $("#last_update").val(val.last_update);
                                                            $("#num_rows").val(val.num_rows);

                                                            var _sum_total = parseInt(val.qty) * parseInt(val.price);

                                                            html += "<tr  class='" + bg + "'  data-id=" + id + " data-qty=" + val.qty + " data-detail-active_order_id=" + active_order_id + " data-detail-menu_id=" + menu_id + " data-detail-menu_type='" + menu_type_eng + "'>";
                                                            html += "<td class='text-center'><i  onclick='check_finished(" + id + ")' class='fa " + icon + "'></i></td>";
                                                            html += "<td class='text-center text-bold' style='font-size: 16px;'><p style='color: blue;'>" + val.qty + "</p></td>";
                                                            html += "<td style='font-size: 16px;'>" + val.product + "  (" + menu_type + ")<span class='pull-right'>&nbsp;&nbsp;<label class='control-label " + class_text_color + "' for='inputWarning' style='font-weight: lighter;'> " + text_status + "</label></span>  </td>";
                                                            html += "<td class='text-right' style='font-size: 16px;'>";
                                                            html += "<span>฿ " + val.price + "</span>";
                                                            html += "</td>";
                                                            html += "<td class='text-right text-bold' style='font-size: 16px;'>฿ " + _sum_total + "</td>";
                                                            html += "</tr>";
                                                        });
                                                        $("#list-menu table tbody").html(html);
                                                        }


                                                    } else {

                                                        //click see detail
                                                        $.each(data2, function (i, val) {
                                                            var id = val.id;
                                                            var total_price = val.total_price;
                                                            var total_qty = val.total_qty;

                                                            var active_order_id = val.active_order_id;
                                                            var menu_id = val.menu_id;
                                                            var menu_type = val.menu_type;
                                                            var menu_type_eng = val.menu_type_eng;
                                                            var status = val.status;

                                                            var tables_number = val.tables_number;
                                                            // console.log(tables_number);

                                                            var class_text_color = '';
                                                            var text_status = '';
                                                            var bg = '';
                                                            var icon = '';
                                                            
                                                            //
                                                               var qty = val.qty;
                                                                var finished_qty = val.finished_qty;
                                                                var still_waiting = parseInt(qty) - parseInt(finished_qty);


                                                                var class_text_color = '';
                                                                var text_status = '';
                                                                
//                                                                if (parseInt(still_waiting) > 0) {
//                                                                    class_text_color = 'text-yellow';
//                                                                    text_status = 'Waiting for ' + still_waiting;
//                                                                } else {
//                                                                    class_text_color = 'text-green';
//                                                                    text_status = 'finished';
//                                                                }
                                                                //

                                                            
                                                            
                                                            
                                                            
                                                              if (parseInt(still_waiting) > 0) {
                                                                class_text_color = 'text-yellow';
                                                              text_status = 'Waiting for ' + still_waiting;
                                                                icon = 'fa-square-o fa-2x ';
                                                                bg = 'bg-warning';
                                                            } else {
                                                                class_text_color = 'text-green';
                                                                text_status = 'finished';
                                                                icon = 'fa-check-square-o fa-2x ';
                                                                bg = 'bg-success';
                                                            }
                                                            

                                                            var char_type = '';
                                                            var TablesOrTogo = '';


                                                            if (tables_number === '0') {
                                                                char_type = '#';
                                                                TablesOrTogo = active_order_id;
                                                            } else {
                                                                char_type = 'T. ';
                                                                TablesOrTogo = tables_number;
                                                            }


                                                            $('.char_type').text(char_type);
                                                            $(".detail-tb-number").text(TablesOrTogo);
                                                            $("#detail-created").text(val.created_at);
                                                            $("#detail-items").text(total_qty);
                                                            $("#detail-total-price").text(total_price);
                                                            $("#pay_money").text(total_price);
                                                            //set change
                                                            $("#last_update").val(val.last_update);
                                                            $("#num_rows").val(val.num_rows);

                                                            var _sum_total = parseInt(val.qty) * parseInt(val.price);

                                                            html += "<tr  class='" + bg + "'  data-id=" + id + " data-qty=" + val.qty + " data-detail-active_order_id=" + active_order_id + " data-detail-menu_id=" + menu_id + " data-detail-menu_type='" + menu_type_eng + "'>";
                                                            html += "<td class='text-center'><i  onclick='check_finished(" + id + ")' class='fa " + icon + "'></i></td>";
                                                            html += "<td class='text-center text-bold' style='font-size: 16px;'><p style='color: blue;'>" + val.qty + "</p></td>";
                                                            html += "<td style='font-size: 16px;'>" + val.product + "  (" + menu_type + ")<span class='pull-right'>&nbsp;&nbsp;<label class='control-label " + class_text_color + "' for='inputWarning' style='font-weight: lighter;'> " + text_status + "</label></span>  </td>";
                                                            html += "<td class='text-right' style='font-size: 16px;'>";
                                                            html += "<span>฿ " + val.price + "</span>";
                                                            html += "</td>";
                                                            html += "<td class='text-right text-bold' style='font-size: 16px;'>฿ " + _sum_total + "</td>";
                                                            html += "</tr>";
                                                        });
                                                        $("#list-menu table tbody").html(html);
                                                    }
                                                } else {
                                                    $("#list-menu table tbody").html(html);
                                                    $(".detail-tb-number").text(active_order_id_selected);
                                                    $("#detail-items").text('');
                                                    $("#detail-created").text('');
                                                    $("#detail-total-price").text('0');
                                                    $("#pay_money").text('0');
                                                    $(".detail-tb-number").text(active_order_id_selected);
                                                }
                                            }
                                        });
                                    }

                                    //check open payment
                                    if (parseInt($('#detail-total-price').text()) > 0) {
                                        $('#btn-tb-payment').prop('disabled', false);
                                    } else {
                                        $('#btn-tb-payment').prop('disabled', true);
                                    }

                                }



                                function select_table(ele) {
                                    $('.tile').removeClass('selected');

                                    var data_tables = $(ele).attr('data-tables');

                                    $('.tables_number').val(data_tables);
                                    $('#old_table').val(data_tables);
                                    $('#selected_table').val(data_tables);


                                    if ($(ele).attr('data-actived') === '1') {

                                        $(ele).addClass('selected');

                                    } else {

                                        $(ele).addClass('selected');

                                        $(ele).closest('.check').remove();
                                    }

                                    SumDetailTable('open_detail');



                                }

                                function cal_change_fit() {
                                    var total_cash = $('#total-cash').text();
                                    $('#cash_receive').val(total_cash);

                                    cal_money();

                                }
                                function cal_money() {

                                    if ($.isNumeric($('#total-cash').text()) && $.isNumeric($('#cash_receive').val())) {

                                        var total_cash = parseInt($('#total-cash').text());
                                        var cash_receive = parseInt($('#cash_receive').val());
                                        if (cash_receive >= total_cash) {
                                            $('#money_back').text(cash_receive - total_cash);
                                            $('#block_change').removeClass('hidden');

                                            $('#btn-payment').prop('disabled', false);
                                            $('#status_ready_pay').val('1');


                                        } else {
                                            $('#block_change').addClass('hidden');
                                            $('#btn-payment').prop('disabled', true);
                                            $('#status_ready_pay').val('0');
                                        }


                                    } else {
                                        $('#block_change').addClass('hidden');
                                        $('#btn-payment').prop('disabled', true);
                                        $('#status_ready_pay').val('0');

                                    }


                                }
                                $('#cash_receive').on('keyup', function (e) {

                                    if (e.which === 13) {
                                        e.preventDefault();
                                        cal_money();
                                        if ($('#status_ready_pay').val() === '1') {
<?php if ($pos == 'buy_back_home') { ?>

                                                ajax_pay_cash('backhome');
<?php } else { ?>
                                                ajax_pay_cash();
<?php } ?>
                                        }

                                    } else {
                                        cal_money();
                                    }
                                });



</script>
<script>


    $("#togo-list table tr").click(function (e) {
        $("#togo-list table tr").removeClass('bg-purple');

        $(this).addClass('bg-purple');
    });

</script>