
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
                                <td>404</td>
                            </tr>
                            <tr>
                                <td class="pull-right"><strong>ประจำเดือน </strong></td>
                                <td>มีนาคม</td>
                            </tr>
                            <tr>
                                <td class="pull-right"><strong>วันที่ทำรายการ</strong></td>
                                <td>10-08-2013</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
          
                <div class="span12">
                    ได้รับเงินจาก :
                </div>
                <div class="span12">
                    ที่อยู่ :
                </div>
                <div class="span12">
                    เบอร์โทร :
                </div>
            </div>
            <p>&nbsp;</p>
            <div class="row">
              
                <div class="span12 well invoice-body">
                    <table class="table-detail table table-bordered">
                        <thead>
                            <tr>

                                <th style="text-align: center;">รายการ</th>
                                <th style="text-align: center;">จำนวนหน่วย</th>
                                <th style="text-align: right;">ราคาต่อหน่วย</th>
                                <th style="text-align: right;">จำนวนเงิน</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Service request</td>
                                <td style="text-align: center;">10/8/2013</td>
                                <td style="text-align: right;">1000.00</td>
                                <td style="text-align: right;">1000.00</td>
                            </tr>
                              <tr>
                                  <td colspan="3" style="text-align: right;"><b>รวมทั้งสิ้น</b></td>
                                  <td colspan="" style="text-align: right;"></td>
                            </tr>


                        </tbody>
                    </table>
                </div>
            </div>
              <div class="row">
                  <div class="span12 well invoice-body">
                      หมายเหตุ :
                      <p>
                          <b>ชำระเงินก่อนวันที่  <?=$this->db->get_where('pay_limit_date', array('id' => 1))->row_array()['day'];?>  ของทุกเดือน</b>
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