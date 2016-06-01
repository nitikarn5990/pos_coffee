<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="<?= base_url() ?>assets/bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?= base_url() ?>assets/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="<?= base_url() ?>assets/ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/AdminLTE.min.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body onload="">
        <div class="wrapper" style="font-size: 13px;">
            <!-- Main content -->
            <section class="invoice">
                <!-- title row -->
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <i class="fa fa-coffee fa-3x"></i> 
                    </div>
                    <div class="col-xs-12">
                        <h4 class="text-center" style="font-size: 16px;margin-bottom: 0px;">
                            ร้านรถนิยม คาเฟ่

                        </h4>
                    </div><!-- /.col -->
                    <div class="col-xs-12 text-center">
                        <small>
                            279/1 ถนน บุญวาทย์ ต. สวนดอก อ. เมือง จ.ลำปาง 52000
                        </small>
                    </div>
                </div>
                <!-- info row -->
                <div class="row invoice-info" style="margin-top: 5px;margin-bottom: 10px;">
                    <div class="col-xs-12 " style="">
                        Date :  <?= $res_bill[0]['paid_date'] ?> <br>
                        Receipt No : #<?= $res_bill[0]['active_order_id'] ?>   <br>
                        Cashier : <?= $res_bill[0]['name'] ?>  <br>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <!-- Table row -->
                <div class="row" >
                    <div class="col-xs-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Qty</th>
                                    <th>Product</th>
                                    <th class="text-right">Price</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total_price = 0;
                                foreach ($res_bill as $key => $rows) {
                                    $menu_type = '';
                                    $total_price = $total_price + ($rows['price'] * $rows['qty']);
                                    if ($rows['menu_type'] == 'hot') {
                                        $menu_type = '(ร้อน)';
                                    }
                                    if ($rows['menu_type'] == 'iced') {
                                        $menu_type = '(เย็น)';
                                    }
                                    if ($rows['menu_type'] == 'smoothie') {
                                        $menu_type = '(ปั่น)';
                                    }
                                    ?>
                                    <tr>
                                        <td><?= $rows['qty'] ?></td>
                                        <td><?= $rows['product'] . " " . $menu_type ?></td>
                                        <td class="text-right"><?= ($rows['price'] * $rows['qty']) ?>.00</td>
                                    </tr>
                                <?php } ?>

                            </tbody>
                        </table>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <div class="row">

                    <div class="col-xs-12">
                        <div class="">
                            <table class="table">

                                <tr>
                                    <th>Total:</th>

                                    <td colspan="2" class="text-right"><?= $total_price ?>.00</td>
                                </tr>
                                <tr>
                                    <td>Pay Cash <?= $res_bill[0]['cash_receive'] ?>.00</td>

                                    <td colspan="2" class="text-right">Change  <?= $res_bill[0]['cash_receive'] - $total_price ?>.00</td>
                                </tr>
                            </table>
                        </div>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <div class="row">

                    <div class="col-xs-12 text-center">
                        ** Thank You **
                    </div>
                </div>

            </section><!-- /.content -->
        </div><!-- ./wrapper -->

        <!-- AdminLTE App -->
        <style>
            table tr td,table th {
                padding-top: 0px !important;;
                padding-bottom: 0px !important;
            }
        </style>
        <script>
   
            window.print();
              setTimeout(function () { window.close(); }, 1000);
      
        
        </script>

    </body>
</html>
