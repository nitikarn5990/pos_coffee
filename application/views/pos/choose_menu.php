<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="row">
        <div class="col-md-3">
            <a href="<?= base_url() ?>pos/tables" class="btn btn-default <?= $pos == 'tables' ? 'active' : '' ?>" style="font-size: 22px;">
                <span class="badge bg-teal"></span>
                TABLES
            </a>
            <a href="<?= base_url() ?>pos/buy_back_home" class="btn btn-default <?= $pos == 'buy_back_home' ? 'active' : '' ?>" style="font-size: 22px;">
                <span class="badge bg-teal"></span>
                BUY BACK HOME
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

    
    </div>
    <div class="row">

        <div class="col-md-5">
            <form action="<?= base_url() ?>pos/tables" method="POST">
                <input type="hidden" name="tables_number" value="<?= $tables_number ?>">
                <input type="hidden"  name="list_menu" value="list_menu">
                <div class="box box-widget">
                    <div class="box-header with-border bg-purple">
                        <div class="col-md-12">
                            <div class="pull-left caption font-18" style="margin-right: 30px;"><i class="fa fa-reorder"></i> Table <span style="font-size: 20px;">#<?= $tables_number ?></span></div>

                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">

                            <div class="col-md-12 col-xs-12">

                            </div>
                            <div class="col-md-12 col-xs-12">

                            </div>
                            <div class="col-md-12 col-xs-12">
                                <div class="table-responsive" id="list-choose-menu">
                                    <table class="table table-condensed">

                                        <thead>

                                        <th  style="width: 100px" class="text-center">Qty</th>
                                        <th  class="text-left">Product</th>

                                        <th style="width: 60px" class="text-right">Total</th>
                                        <th style="width: 60px" class="text-right">ลบ</th>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row" style="margin-bottom: 10px;">
                                <div class="col-md-6 col-xs-6">
                                    <div class="col-md-12 font-18 font-light">
                                        Items : <span id="num_rows">0</span>
                                    </div>
                                    <div class="col-md-12 font-light hidden">
                                        <input type="checkbox" name="" checked=""> ส่ง Barista 
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-6">
                                    <span style="font-size: 22px;" class="font-light">Grand Total : </span>
                                    <span class="text-bold" style="color: blue;font-size: 30px;">฿ <span id="total_price">0</span>.00 </span>
                                </div>
                            </div>

                            <div class="col-md-12 col-xs-12">
                                <button type="submit" class="btn btn-block bg-primary" style="font-size: 18px;" name="btn_submit" value="add_to_table">Table #<?= $tables_number ?> Add to table.</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div><!-- /.col -->
        <div class="col-md-7">

            <form action="<?= base_url() ?>" method="POST">
                <div class="box box-widget">
                    <div class="box-header with-border bg-purple">
                        <div class="col-md-12">
                            <div class="pull-left caption font-18 font-light">รายการ / เมนู</div>
                            <div class="caption pull-right hidden">
                                <a href="<?= base_url('category/add') ?>" class="btn btn-success  btn-flat btn-sm" name="btn_submit" value="เพิ่มข้อมูล"><i class="fa fa-plus"></i> เพิ่มข้อมูล</a>
                                <button type="submit" class="btn btn-danger btn-flat btn-sm" name="btn_submit" value="ลบที่เลือก"><i class="fa fa-trash"></i> ลบที่เลือก</button>

                            </div>

                        </div>
                    </div>
                    <div class="box-body">
                        <div class="col-md-5">
                            <div id="category">
                                <h4 class="head-label">รายการอาหาร</h4>
                                <table class="table table-bordered table-hover" id="choose_category" style="cursor: pointer;">
                                    <tbody>
                                        <?php
                                        $category = $this->db->get_where('category', array('status' => 'ใช้งาน'))->result_array();
                                        if (count($category) > 0) {
                                            foreach ($category as $key => $rows) {
                                                ?>
                                                <tr class="" onclick="active_row(this,<?= $rows['id'] ?>)">
                                                    <td style="width: 40px;">
                                                        <span class="label bg-purple2 border-radius-0 margin-r-5" style="font-size: 12px;"><?= $key + 1 ?>.</span>
                                                        <span style="font-size: 16px;"><?= $rows['category_name'] ?></span>
                                                    </td>


                                                </tr>

                                            <?php } ?>
                                        <?php } ?>


                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="col-md-7">
                            <div id="category_child">

                            </div>

                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div><!-- /.row -->
</section><!-- /.content -->


<style>
    #choose_category tr:hover{
        background-color: #EFCEF0;
    }
</style>





<script>
    $(document).ready(function () {
        $("#chkboxall").click(function (e) {
            $('.chkbox').prop('checked', this.checked);
        });

    });

    function active_row(ele, id) {

        $('#choose_category tr').removeClass('bg-purple-light-active');
        $(ele).addClass('bg-purple-light-active');

        //ดึงข้อมูลรายการอาหาร ของ category
        $.ajax({
            type: 'GET',
            url: '<?= base_url('pos/ajax_get_catelog_child') ?>',
            data: {category_id: id},
            //  dataType:'json',
            success: function (data) {

                $('#category_child').html(data);
            }
        });
    }

</script>