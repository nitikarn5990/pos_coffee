<div class="content">

    <div class="">

         <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"> ข้อมูลการเช่าของเลขที่สัญญา # <?= $id ?></h3>
                </div><!-- /.box-header -->

                <!-- form start -->
                <form>
                    <div class="box-body">

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">ห้องที่</label>
                            <div class="col-sm-10">
                                <input type="text" readonly="" value="<?= $result_room['number_room'] ?>" class="form-control">

                            </div>
                        </div>
                        <div class=" form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">วันที่ทำสัญญา</label>
                            <div class="col-sm-10">
                                <input type="text" readonly="" value="<?= ShowDateThTime($result_rental['open_rental_date']) ?>" class="form-control">

                            </div>
                        </div>
                        <div class=" form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">ชื่อผู้เช่า</label>
                            <div class="col-sm-10">
                                <input type="text" readonly="" value="<?= $result_member['customer_firstname'] . ' ' . $result_member['customer_lastname'] ?>" class="form-control">

                            </div>
                        </div>
                        <div class=" form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">เบอร์โทร</label>
                            <div class="col-sm-10">
                                <input type="text" readonly="" value="<?= $result_member['customer_tel'] ?>" class="form-control">

                            </div>
                        </div>
                    </div><!-- /.box -->
                </form>

            </div><!--/.col (right) -->
        </div>
         </div>
        <div class="row">
            <div class="col-md-6">
                <form class="form-horizontal" action="<?= base_url('rent_info/update_meter') ?>" method="POST">
                    <input type="hidden" name="id" value="<?= $result_active_rent['id'] ?>">
                    <input type="hidden" name="rental_id" value="<?= $result_active_rent['rental_id'] ?>">

                    <!--End Alert -->

                    <!-- Horizontal Form -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">ชำระเงิน</h3>


                        </div><!-- /.box-header -->
                        <div class="box-header with-border">
                            <h3 class="box-title bg-blue-active">ของเดือน : <?= $result_active_rent['pay_monthly'] ?></h3>

                        </div><!-- /.box-header -->

                        <div class="box-body">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label ">Internet</label>
                                <div class="col-sm-10">
                                    <div class="col-xs-12">

                                        <div class="table-responsive" id="meter_input">
                                            <table class="table">
                                                <tbody>
                                                    <tr class="bg-warning">
                                                        <th>การใช้งาน :</th>
                                                        <td>
                                                            <input type="radio" name="status_internet" value="ใช้" <?= $result_active_rent['internet'] > 0 ? 'checked' : '' ?>> ใช้ &nbsp;
                                                            <input type="radio"  name="status_internet" value="ไม่ใช้" <?= $result_active_rent['internet'] == 0 ? 'checked' : '' ?>> ไม่ใช้
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">ค่าน้ำ ค่าไฟ</label>
                                <div class="col-sm-10">
                                    <div class="col-xs-12">
                                        <p class="lead">ใส่เลขมิเตอร์</p>
                                        <div class="table-responsive" id="meter_input">
                                            <table class="table">
                                                <tbody>
                                                    <tr class="bg-warning">
                                                        <th>เลขมิเตอร์ไฟฟ้า สุดท้าย :</th>
                                                        <td><input type="text" id="meter_electric_price_per_month" disabled="" value="<?= $result_active_rent_last_count == 0 ? $result_active_rent_last['meter_electric'] : $result_active_rent_last['meter_electric_last'] ?>" data-validation="required,number" > </td>
                                                    </tr>
                                                    <tr class="bg-warning">
                                                        <th>เลขมิเตอร์ไฟฟ้า ปัจจุบัน :<em class="text-red">*</em></th>
                                                        <td>
                                                            <input type="text" id="meter_electric_price_per_month_current" name="meter_electric_price_per_month_current" data-validation="chk_meter_electric,required,number" value="<?= $result_active_rent['meter_electric_last'] == '' || $result_active_rent['meter_electric_last'] == 0 ? '' : $result_active_rent['meter_electric_last'] ?>" placeholder="ใส่เลขมิเตอร์">  
                                                        </td>
                                                    </tr>
                                                    <tr class="bg-warning">
                                                        <th>ค่าไฟรวม :<em class="text-red">*</em></th>
                                                        <td>
                                                            <?php
                                                            $water_rate = $this->db->get_where('water_rate', array('id' => 1))->row_array()['rate_price'];
                                                            $electric_rate = $this->db->get_where('electric_rate', array('id' => 1))->row_array()['rate_price'];

                                                            if ($result_active_rent['meter_water_last'] == 0) {
                                                                $total_price_electric = 0;
                                                            } else {
                                                                if ($result_active_rent_last_count == 0) {
                                                                    $total_price_electric = ($result_active_rent['meter_electric_last'] - $result_active_rent['meter_electric']) * $electric_rate;
                                                                } else {
                                                                    $total_price_electric = ($result_active_rent['meter_electric_last'] - $result_active_rent_last['meter_electric_last']) * $electric_rate;
                                                                }
                                                            }

                                                            if ($result_active_rent['meter_water_last'] == 0) {
                                                                $total_price_water = 0;
                                                            } else {
                                                                if ($result_active_rent_last_count == 0) {
                                                                    $total_price_water = ($result_active_rent['meter_water_last'] - $result_active_rent['meter_water'] ) * $water_rate;
                                                                } else {
                                                                    $total_price_water = ($result_active_rent['meter_water_last'] - $result_active_rent_last['meter_water_last'] ) * $water_rate;
                                                                }
                                                            }

                                                            $total_el_water = $total_price_electric + $total_price_water;
                                                            $total_amt = $total_price_electric + $total_price_water + $result_active_rent['deposit'] + $result_active_rent['internet'] + $result_active_rent['price_per_month'];
                                                            ?>
                                                            <input type="text" id="electric_total" data-validation="required,number" disabled="" value="<?= $total_price_electric ?>" >  
                                                        </td>
                                                    </tr>
                                                    <tr class="bg-info">
                                                        <th>เลขมิเตอร์น้ำ สุดท้าย :</th>
                                                        <td><input type="text" id="meter_water_price_per_month" disabled="" value="<?= $result_active_rent_last_count == 0 ? $result_active_rent_last['meter_water'] : $result_active_rent_last['meter_water_last'] ?>" data-validation="required,number" > </td>
                                                    </tr>
                                                    <tr class="bg-info">
                                                        <th>เลขมิเตอร์น้ำ ปัจจุบัน :<em class="text-red">*</em></th>
                                                        <td>
                                                            <input type="text" id="meter_water_price_per_month_current" name="meter_water_price_per_month_current" value="<?= $result_active_rent['meter_water_last'] == '' || $result_active_rent['meter_water_last'] == 0 ? '' : $result_active_rent['meter_water_last'] ?>" data-validation="chk_meter_water,required,number"  onkeyup="calculate_totals()" placeholder="ใส่เลขมิเตอร์">  
                                                        </td>
                                                    </tr>
                                                    <tr class="bg-info">
                                                        <th>ค่าน้ำรวม :<em class="text-red">*</em></th>
                                                        <td>
                                                            <input type="text" id="water_total" disabled="" data-validation="required,number" value="<?= $total_price_water ?>">  
                                                        </td>
                                                    </tr>
                                                    <tr class="bg-gray">
                                                        <th>รวม :</th>
                                                        <td><input type="text" id="meter_total_amt" readonly="" data-validation="required" value="<?= $total_el_water ?>"> </td>
                                                    </tr>
                                                <input type="hidden" name="water_rate" id="water_rate" value="<?= $this->db->get_where('water_rate', array('id' => 1))->row_array()['rate_price'] ?>">
                                                <input type="hidden" name="electric_rate" id="electric_rate" value="<?= $this->db->get_where('electric_rate', array('id' => 1))->row_array()['rate_price'] ?>">
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="">
                                            <button type="submit" name="btn_submit" value="บันทึก" class="btn btn-instagram pull-left margin-r-5">บันทึกการเปลี่ยนแปลงและคำนวณค่าใช้จ่าย</button>&nbsp;&nbsp;
                                        </div>
                                    </div>

                                </div>
                            </div>


                        </div><!-- /.box -->

                    </div><!--/.col (right) -->

                </form>

            </div>
            <?php if ($active_rent_min_id == $result_active_rent['id']) { ?>

                <!-- Main content -->


                <!-- Horizontal Form -->
                <div class="col-md-6">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">ชำระค่ามัดจำ</h3>
                        </div><!-- /.box-header -->

                        <!-- form start -->
                        <div class="box-body">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">จำนวนเงิน</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly="" value="<?= $result_active_rent['deposit'] ?>" class="form-control" id="" name=""  >

                                </div>


                            </div>

                        </div><!-- /.box -->

                    </div><!--/.col (right) -->
                </div>
                <?php if ($result_active_rent['price_per_month'] > 0) { ?>

                    <!-- Main content -->

                    <div class="col-md-6">
                        <!-- Horizontal Form -->
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">ชำระค่าห้อง</h3>
                            </div><!-- /.box-header -->

                            <!-- form start -->
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">จำนวนเงิน</label>
                                    <div class="col-sm-10">
                                        <input type="text" readonly="" value="<?= $result_active_rent['price_per_month'] ?>" class="form-control" id="" name=""  >

                                    </div>


                                </div>
                            </div><!-- /.box -->

                        </div><!--/.col (right) -->
                    </div>


                <?php } ?>  
                <?php if ($result_active_rent['internet'] > 0) { ?>

                    <!-- Main content -->
                    <div class="col-md-6">
                        <!-- Horizontal Form -->
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">ชำระค่า Internet</h3>
                            </div><!-- /.box-header -->

                            <!-- form start -->
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">จำนวนเงิน</label>
                                    <div class="col-sm-10">
                                        <input type="text" readonly="" value="<?= $result_active_rent['internet'] ?>" class="form-control" id="" name=""  >

                                    </div>


                                </div>
                            </div><!-- /.box -->

                        </div><!--/.col (right) -->
                    </div>

                <?php } ?>    
            <?php } else { ?>
                <?php if ($result_active_rent['price_per_month'] > 0) { ?>

                    <!-- Main content -->
                    <div class="col-md-6">
                        <!-- Horizontal Form -->
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">ชำระค่าห้อง</h3>
                            </div><!-- /.box-header -->

                            <!-- form start -->
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">จำนวนเงิน</label>
                                    <div class="col-sm-10">
                                        <input type="text" readonly="" value="<?= $result_active_rent['price_per_month'] ?>" class="form-control" id="" name=""  >

                                    </div>


                                </div>
                            </div><!-- /.box -->

                        </div><!--/.col (right) -->
                    </div>

                <?php } ?>  
                <?php if ($result_active_rent['internet'] > 0) { ?>

                    <!-- Main content -->

                    <div class="col-md-6">
                        <!-- Horizontal Form -->
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">ชำระค่า Internet</h3>
                            </div><!-- /.box-header -->

                            <!-- form start -->
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">จำนวนเงิน</label>
                                    <div class="col-sm-10">
                                        <input type="text" readonly="" value="<?= $result_active_rent['internet'] ?>" class="form-control" id="" name=""  >

                                    </div>


                                </div>
                            </div><!-- /.box -->

                        </div><!--/.col (right) -->
                    </div>

                <?php } ?>  

            <?php } ?>  



            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <i class="fa fa-money"></i>
                                <h3 class="box-title">ยอดเงินรวมที่ต้องชำระ</h3>

                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr class="bg-success">
                                                <th>รวมทั้งสิ้น :</th>
                                                <td><input type="text" id="total_pays" name="total_pays" value="<?= $total_amt ?>" readonly class="text-right">   บาท</td>
                                            </tr>

                                        </tbody>
                                    </table>

                                </div>

                            </div><!-- /.box-body -->
                            <div class="box-footer">
                               

                            </div><!-- /.box-footer -->
                        </div><!-- /.box -->
                    </div>

                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-6">

                <div class="box box-default">
                    <div class="box-header with-border">
                        <i class="fa fa-money"></i>
                        <h3 class="box-title">ชำระเงิน / ประวัติการชำระเงิน</h3>

                    </div><!-- /.box-header -->
                    <div class="box-body" id="payment_history">

                    </div><!-- /.box-body -->

                </div><!-- /.box -->

            </div>
            <div class="col-md-6">
                <form action="<?=  base_url()?>bill/bill_end_month_receipt/<?=$active_rent_id?>" target="_blank" method="post">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <i class="fa fa-print"></i>
                            <h3 class="box-title"> พิมพ์ใบเสร็จรับเงิน</h3>
                        </div><!-- /.box-header -->
                        <div class="col-md-12">
                           
                            <button class="btn btn-info" type="submit"><i class="fa fa-print"></i> พิมพ์รายการที่เลือก</button>
                        </div>
                        <div class="box-body" id="">
                            <table id="example" class="ui celled table bill_type" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox"  id="select_all"></th>
                                        <th>ชื่อใบเสร็จ</th>
                                        <th>จำนวน</th>
                                       
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>ชื่อใบเสร็จ</th>
                                        <th>จำนวน</th>
                                     
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php if ($result_active_rent['price_per_month'] > 0) { ?>
                                        <tr class="">
                                            <td><input type="checkbox" name="bill_type[]" value="price_per_month"></td>
                                            <td>ค่าเช่า</td>
                                            <td><?= $result_active_rent['price_per_month'] ?></td>
                                            
                                        </tr>
                                    <?php } ?>
                                    <?php if ($result_active_rent['deposit'] > 0) { ?>
                                        <tr class="">
                                            <td><input type="checkbox" name="bill_type[]" value="deposit"></td>
                                            <td>ค่ามัดจำ</td>
                                            <td><?= $result_active_rent['deposit'] ?></td>
                                           
                                        </tr>
                                    <?php } ?>
                                    <?php if ($result_active_rent['internet'] > 0) { ?>
                                        <tr class="">
                                            <td><input type="checkbox" name="bill_type[]" value="internet"></td>
                                            <td>ค่าอินเตอร์เน็ต</td>
                                            <td><?= $result_active_rent['internet'] ?></td>
                                          
                                        </tr>
                                    <?php } ?>

                                    <?php if ($total_price_water > 0) { ?>
                                        <tr class="">
                                            <td><input type="checkbox" name="bill_type[]" value="water"></td>
                                            <td>ค่าน้ำ</td>
                                            <td><?= $total_price_water ?></td>
                                     
                                        </tr>
                                    <?php } ?>
                                    <?php if ($total_price_electric > 0) { ?>
                                        <tr class="">
                                            <td><input type="checkbox" name="bill_type[]" value="electric"></td>
                                            <td>ค่าไฟฟ้า</td>
                                            <td><?= $total_price_electric ?></td>
                                       
                                        </tr>
                                    <?php } ?>



                                </tbody>
                            </table>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                           <div class="box box-default">
                <div class="box-header with-border">
                    <i class="fa fa-print"></i>
                    <h3 class="box-title"> พิมพ์ใบแจ้งหนี้ค่าน้ำ ค่าไฟฟ้า</h3>
                </div><!-- /.box-header -->
                <div class="col-md-12">
                    <a href="<?=base_url()?>bill/bill_end_month/<?=$active_rent_id?>" target="_blank" class="btn btn-danger"><i class="fa fa-print"></i> พิมพ์ </a> 
                </div>
                <div class="box-body" id="">

                </div><!-- /.box-body -->
            </div><!-- /.box -->
            <div class="box box-default hidden">
                <div class="box-header with-border">
                    <i class="fa fa-print"></i>
                    <h3 class="box-title"> พิมพ์ใบแจ้งหนี้ค้างชำระ </h3>
                </div><!-- /.box-header -->
                <div class="col-md-12">
                    <a href="" target="_blank" class="btn btn-danger"><i class="fa fa-print"></i> พิมพ์ </a> 
                </div>
                <div class="box-body" id="">

                </div><!-- /.box-body -->
            </div><!-- /.box -->
                </form>
            </div>
        </div>
        <div class="row">
        <div class="col-md-6">

     
        </div>
        </div>


    </div>
</div>



<script>


// Add custom validation rule
            $.formUtils.addValidator({
            name : 'chk_meter_electric',
                    validatorFunction : function(value, $el, config, language, $form) {
                     
                    if (parseInt(value) >= parseInt($('#meter_electric_price_per_month').val())) {
                    return true;
                    } else{
                    return false;
                    }


                    },
                    errorMessage : 'ค่าต้องมากกว่าเลขมิเตอร์ไฟฟ้าสุดท้าย',
                    errorMessageKey: 'ค่าต้องมากกว่าเลขมิเตอร์ไฟฟ้าสุดท้าย'
            });
            $.formUtils.addValidator({
            name : 'chk_meter_water',
                    validatorFunction : function(value, $el, config, language, $form) {

                    if (parseInt(value) >= parseInt($('#meter_water_price_per_month').val())) {
                    return true;
                    } else{
                    return false;
                    }


                    },
                    errorMessage : 'ค่าต้องมากกว่าเลขมิเตอร์น้ำสุดท้าย',
                    errorMessageKey: 'ค่าต้องมากกว่าเลขมิเตอร์น้ำสุดท้าย'
            });
            function showDialog(uri) {

            var sList = PopupCenter(uri, '', "900", "400");
            }

    function PopupCenter(url, title, w, h) {
    // Fixes dual-screen position Most browsers      Firefox
    var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
            var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;
            width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
            height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;
            var left = ((width / 2) - (w / 2)) + dualScreenLeft;
            var top = ((height / 2) - (h / 2)) + dualScreenTop;
            var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
            // Puts focus on the newWindow
            if (window.focus) {
    newWindow.focus();
    }
    }



</script>


<script>

    function calulate_moneyback_unpaid(){

    var money = $('#receive_money').val();
            var total_pays = $('#total_pays').val();
            if (parseInt(money) <= parseInt(total_pays)) {
    var res = parseInt(money) - parseInt(total_pays);
            $('#unpaid').val(Math.abs(res));
            $('#money_back').val(0);
    } else{
    var res = parseInt(money) - parseInt(total_pays);
            $('#unpaid').val(0);
            $('#money_back').val(res);
    }

    //  alert(res);

    }

    new DG.OnOffSwitch({
    el: '#paid_new_month',
            textOn: 'ชำระ',
            textOff: 'ไม่ชำระ',
            listener: function (name, checked) {

            //  document.getElementById("ELEMENT").innerHTML = "Switch " + name + " changed value to " + checked;
            if (checked) {
            //  var internet = $('#internet2').val();
            //  var internet2 = $('#internet').val(internet);

            $('#status_pay').val('yes');
                    total_amt();
            } else {
            $('#status_pay').val('no');
                    total_amt('ไม่ชำระ');
            }
            }
    });
            new DG.OnOffSwitch({
            el: '#on-off-internet',
                    textOn: 'ใช้',
                    textOff: 'ไม่ใช้',
                    checked: false,
                    listener: function (name, checked) {

                    //  document.getElementById("ELEMENT").innerHTML = "Switch " + name + " changed value to " + checked;

                    if (checked) {
                    var internet = $('#internet2').val();
                            var internet2 = $('#internet').val(internet);
                            total_amt();
                    } else {

                    $('#internet').val('0');
                            total_amt('ไม่ชำระ');
                    }
                    }
            });
            $('#meter_water_price_per_month_current,#meter_electric_price_per_month_current').keyup(function () {
    if ($('#status_pay').val() == 'yes') {
    total_pay();
    } else{
    total_pay('ไม่ชำระ');
    }


    });
            var total_amy_all = 0;
            function total_pay(_paid = '') {
            //  var meter_total_amt = $('#meter_total_amt').val();
            //  var total_amt = $('#total_amt').val();

            //  $('#total_pays').val('55');

            //รวมต้องชำระ
            var meter_total_amt = $('#meter_total_amt').val();
                    var _total_amt = $('#total_amt').val();
                    //ผลรวมทั้งหมด
                    //total_pays
                    if (total_amy_all === 0) {
            total_amy_all = $('#total_pays').val();
            }


            if (_paid == 'ไม่ชำระ') {
            var total_pay = parseInt(total_amy_all);
                    //  alert(total_pay);
                    $('#total_pays').val(total_pay);
            } else{
            var total_pay = parseInt(total_amy_all) + parseInt(_total_amt);
                    // alert(meter_total_amt);
                    //   alert(_total_amt);

                    //ผลรวมทั้งหมด
                    //total_pays
                    $('#total_pays').val(total_pay);
            }
            calulate_moneyback_unpaid();
            }

    function total_amt(_paid = '') {

    if ($('#status_pay').val() == 'yes') {
    var internet = $('#internet').val();
            var price_per_month = $('#price_per_month').val() == '' ? '0' : $('#price_per_month').val();
            //   var deposit = $('#deposit').val() == '' ? '0' : $('#deposit').val();
            var internet = $('#internet').val() == '' ? '0' : $('#internet').val();
            var total_amt = parseInt(price_per_month) + parseInt(internet);
            $('#total_amt').val(total_amt);
            total_pay();
    } else{
    var internet = $('#internet').val();
            var price_per_month = $('#price_per_month').val() == '' ? '0' : $('#price_per_month').val();
            //   var deposit = $('#deposit').val() == '' ? '0' : $('#deposit').val();
            var internet = $('#internet').val() == '' ? '0' : $('#internet').val();
            var total_amt = parseInt(price_per_month) + parseInt(internet);
            $('#total_amt').val(total_amt);
            total_pay('ไม่ชำระ');
    }


    }
</script>
<style>
    #month_payment{
        background: rgba(158, 158, 158, 0.09);
        border-radius: 5px;

        border: 1px solid rgba(13, 28, 10, 0.07);
    }
</style>

<script>
    function calculate_total() {

    var rate_electric = $('#electric_rate').val();
            var rate_water = $('#water_rate').val();
            var total_water = parseInt(rate_water) * (parseInt($('#meter_water_price_per_month_current').val()) - parseInt($('#meter_water_price_per_month').val()));
            var total_electric = parseInt(rate_electric) * (parseInt($('#meter_electric_price_per_month_current').val()) - parseInt($('#meter_electric_price_per_month').val()));
            var total_amt = total_water + total_electric;
            $('#electric_total').val(total_electric);
            $('#water_total').val(total_water);
            $('#meter_total_amt').val(total_amt);
            //alert('sdsd');
            total_amt();
    }
    $(document).ready(function () {


    $('#datepicker').datepicker({
    format: 'yyyy-mm',
            todayHighlight: true,
            language: 'th',
            minViewMode: 'months',
    });
            $('#datepicker').on("changeDate", function () {
    $('#my_hidden_input').val(
            $('#datepicker').datepicker('getFormattedDate')
            );
    });
            $('#my_hidden_input').val(
            $('#datepicker').datepicker('getFormattedDate')
            );
<?php if (isset($result_active_rent_next_month)) { ?>
        $("#paid_new_month").trigger("click");
    <?php if ($result_active_rent_next_month['internet'] == 300) { ?>
            $("#on-off-internet").trigger("click");
    <?php } ?>



<?php } ?>

    _load(<?= $result_active_rent['id'] ?>);
    });
            function edit_payment(id, val){
            bootbox.prompt({
            title: "แก้ไขจำนวนเงิน",
                    value: val,
                    callback: function(result) {

                    if (result != '') {
                    _edit(id, result)
                    }
                    }
            });
            }

    function delete_payment(id){
    bootbox.confirm("คุณแน่ใจที่จะลบ?", function(result) {
    if (result){

    _delete(id);
    }
    });
    }

    function _edit(id, val) {
    // $.blockUI({ message: '<h1><img src="busy.gif" /> Just a moment...</h1>' });

    $.ajax({
    method: "POST",
            url: "<?= base_url() ?>rent_info/active_payment_edit/" + id + "/" + val,
            data: {
            active_rent_id: id,
            },
            beforeSend: function () {
            $.blockUI({message: '<h2 style=padding:10px;>กำลังโหลด...</h2>'});
            },
            complete: function () {
            $.unblockUI();
            }

    }).done(function (msg) {

    // $('#payment_history').html(msg);
    $.unblockUI();
            location.reload();
    });
    }
    function _load(id) {
    // $.blockUI({ message: '<h1><img src="busy.gif" /> Just a moment...</h1>' });

    $.ajax({
    method: "POST",
            url: "<?= base_url() ?>rent_info/load_payment/" + id,
            data: {
            active_rent_id: id,
            },
            beforeSend: function () {
            $.blockUI({message: '<h2 style=padding:10px;>กำลังโหลด...</h2>'});
            },
            complete: function () {
            $.unblockUI();
            }

    }).done(function (htmlData) {

    $('#payment_history').html(htmlData);
            $.unblockUI();
    });
    }
    function _delete(id) {
    // $.blockUI({ message: '<h1><img src="busy.gif" /> Just a moment...</h1>' });

    $.ajax({
    method: "POST",
            url: "<?= base_url() ?>rent_info/active_payment_delete/" + id,
            data: {
            active_rent_id: id,
            },
            beforeSend: function () {
            $.blockUI({message: '<h2 style=padding:10px;>กำลังโหลด...</h2>'});
            },
            complete: function () {
            $.unblockUI();
            }

    }).done(function (msg) {

    // $('#payment_history').html(msg);
    $.unblockUI();
            location.reload();
    });
    }


    $('#select_all').change(function() {
    var checkboxes = $(this).closest('.bill_type').find(':checkbox');
            if ($(this).is(':checked')) {
    checkboxes.prop('checked', true);
    } else {
    checkboxes.prop('checked', false);
    }
    });


</script>
<style>
    #meter_input input[type='text']{
        text-align: right;
    }
</style>