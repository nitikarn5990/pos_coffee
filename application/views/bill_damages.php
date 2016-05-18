
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
                    <h2>ใบเสร็จค่าเสียหายและยอดเงินคงเหลือ</h2>
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
                                <td class="pull-right"><strong>สัญญาเลขที่  </strong></td>
                                <td><?=$res_active_rent['rental_id']?> </td>
                            </tr>
                            <tr>
                                <td class="pull-right"><strong>ห้อง </strong></td>
                                <td><?= $number_room ?></td>
                            </tr>
                            <tr>
                                <td class="pull-right"><strong>วันที่ทำรายการ</strong></td>
                                <td><?= ShowDateThTime(DATE_TIME) ?></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">

                <div class="span12">
                    คืนเงินให้ : <?= $res_member['customer_firstname'] . ' ' . $res_member['customer_lastname'] ?>
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
                            if (!empty($res_damages)) {
                                foreach ($res_damages as $rows) {
                                    ?>


                                    <tr>
                                        <td><?= $rows['detail'] ?> </td>
                                        <td style="text-align: center;">-</td>
                                        <td style="text-align: center;">-</td>
                                        <td style="text-align: right;"><?= $rows['price'] ?></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>

                            <tr>
                                <td colspan="3" style="text-align: right;"><b>รวม</b></td>
                                <td colspan="" style="text-align: right;"><?= $total_dm ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align: right;"><b>เงินค่ามัด</b></td>
                                <td colspan="" style="text-align: right;"><?= $res_active_rent['deposit'] ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align: right;"><b>รวมค่าเสียหาย</b></td>
                                <td colspan="" style="text-align: right;"><?= $total_dm ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align: right;"><b>ยอดเงินคงเหลือ</b></td>
                                <td colspan="" style="text-align: right;"><?= $res_active_rent['deposit'] - $total_dm ?></td>
                            </tr>




                        </tbody>
                    </table>
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