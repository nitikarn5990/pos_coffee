
<html>
    <head>
        <meta charset="utf-8">
        <title>ใบเสร็จ</title>

        <link rel="stylesheet" href="<?= base_url() ?>assets/bootstrap.css">
        <style>
            .invoice-head td {
                padding: 0 8px;
            }
            .container {
                padding-top:30px;
            }
            .invoice-body{
                background-color:transparent;
            }
            .invoice-thank{
                margin-top: 60px;
                padding: 5px;
            }
            address{
                margin-top:15px;
            }
            table th{
                font-size: 14px;
            }
            .table-detail td{
                font-size: 12px;
            }
        </style>

    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="span12 text-center">
                    <h2>ใบเสร็จรับเงิน</h2>
                </div>
            </div>


            <div class="row">
                <div class="span6">

                    <address>
                        <strong>หอพักแตงโม</strong><br>
                        เลขที่ตั้ง 224/7 ถนนสีหราชเดโชชัย <br>ต.ในเมือง อ.เมือง จ.พิษณุโลก 65000
                    </address>
                </div>
                <div class="span6">
                    <table class="invoice-head pull-right">
                        <tbody>

                            <tr>
                                <td class="pull-right"><strong>ห้อง </strong></td>
                                <td><?= $number_room ?></td>
                            </tr>
                            <tr>
                                <td class="pull-right"><strong>ประจำเดือน </strong></td>
                                <td><?= $monthly ?></td>
                            </tr>
                            <tr>
                                <td class="pull-right"><strong>วันที่ทำรายการ</strong></td>
                                <td><?= $updated_at ?></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">

                <div class="span12">
                    ได้รับเงินจาก : <?= $res_member['customer_firstname'] . ' ' . $res_member['customer_lastname'] ?>
                </div>
                <div class="span12">
                    ที่อยู่ : <?= $res_member['customer_address'] ?>
                </div>
                <div class="span12">
                    เบอร์โทร : <?= $res_member['customer_tel'] ?>
                </div>
            </div>
            <p>&nbsp;</p>
            <div class="row">

                <div class="span12 well invoice-body">
                    <table class="table-detail table table-bordered">
                        <thead>
                            <tr>

                                <th style="text-align: center;">รายการ</th>
                                <th style="text-align: center;">จำนวนหน่วยที่ใช้</th>
                                <th style="text-align: center;">ราคาต่อหน่วย</th>
                                <th style="text-align: right;">จำนวนเงิน</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $el_unit = $res_active_rent['meter_electric_last'] - $res_active_rent['meter_electric'];
                            $water_unit = $res_active_rent['meter_water_last'] - $res_active_rent['meter_water'];
                            $price_per_month = 0;
                            $internet_cost = 0;
                            
                            if ($res_active_rent['id_next_month'] > 0) {
                                //มีการเช่าต่อ
                                $res_active_rent_next_month = $this->db->get_where('active_rent', array('id' => $res_active_rent['id_next_month']))->row_array();
                                $price_per_month = $res_active_rent_next_month['price_per_month'];
                                ?>
                                <tr>
                                    <td>ค่าเช่า (<?=  ShowDateTh($res_active_rent_next_month['pay_monthly'])?>)</td>
                                    <td style="text-align: center;">-</td>
                                    <td style="text-align: center;">-</td>
                                    <td style="text-align: right;"><?= $res_active_rent_next_month['price_per_month'] ?></td>
                                </tr>
                                <?php if ($res_active_rent_next_month['internet'] > 0) { 
                                      $internet_cost = $res_active_rent_next_month['internet'];
                                    ?>
                                    <tr>
                                        <td>ค่า Internet (<?=  ShowDateTh($res_active_rent_next_month['pay_monthly'])?>)</td>
                                        <td style="text-align: center;">-</td>
                                        <td style="text-align: center;">-</td>
                                        <td style="text-align: right;"><?= $res_active_rent_next_month['internet'] ?></td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                            <tr>
                                <td>ค่าไฟฟ้า [<?= $res_active_rent['meter_electric'] . ' - ' . $res_active_rent['meter_electric_last'] ?>]</td>
                                <td style="text-align: center;"><?= $el_unit ?></td>
                                <td style="text-align: center;"><?= $electric_rate ?></td>
                                <td style="text-align: right;"><?= $el_unit * $electric_rate ?></td>
                            </tr>
                            <tr>
                                <td>ค่าน้ำ [<?= $res_active_rent['meter_water'] . ' - ' . $res_active_rent['meter_water_last'] ?>]</td>
                                <td style="text-align: center;"><?= $water_unit ?></td>
                                <td style="text-align: center;"><?= $water_rate ?></td>
                                <td style="text-align: right;"><?= $water_unit * $water_rate ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align: right;"><b>ได้รับเงินรวมทั้งสิ้น</b></td>
                                <td colspan="" style="text-align: right;"><?= ($el_unit * $electric_rate) + ($water_unit * $water_rate) + $price_per_month + $internet_cost?></td>
                            </tr>


                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="span12 well invoice-body">
                    หมายเหตุ :
                    <p>
                        <b>ชำระเงินก่อนวันที่  <?= $this->db->get_where('pay_limit_date', array('id' => 1))->row_array()['day']; ?>  ของทุกเดือน</b>
                    </p>
                </div>

            </div>

        </div>
        <script>

            //  $(document).ready(function () {
              window.print();
            //  });
        </script>
    </body>
</html>