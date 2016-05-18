<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title></title>
        <link rel="stylesheet" href="<?= base_url() . 'assets/bootstrap/css/bootstrap.min.css' ?>">
        <style>
            @font-face {
                font-family: 'thSarabun';
                src:   url('<?= base_url() ?>assets/fonts/THSarabunNew.ttf') format('truetype');
                font-weight: normal;
                font-style: normal;

            }
            body{
                font-family: 'thSarabun' !important;
            }
        </style>
    </head>
    <body>
        <div class="container">
           
            <div class="row">
                <div class="col-md-12 text-right">
                       สัญญาเลขที่ <?=$id?>
                       <?php 
                       $member_id = $this->db->get_where('rental', array('id' => $id))->row_array()['member_id'];
                       $room_id = $this->db->get_where('rental', array('id' => $id))->row_array()['room_id'];
                               
                       ?>
                   </div>
                   <div class="col-md-12 text-right">
                       วันที่ทำสัญญา <?= ShowDateThTime(DATE_TIME) ?>
                   </div>
                <div class="col-md-12 text-center" style="font-size: 28px;">
                  สัญญาเช่าหอพัก
                </div>
                
                <div class="col-md-12">
                    <p class="text-ident">สัญญานี้ทำขึ้นที่ <b>หอพักแตงโม เลขที่ตั้ง 224/7 ถนนสีหราชเดโชชัย ต.ในเมือง อ.พิษณุโลก จ.พิษณุโลก</b></p>
                    ซึ่งต่อไปใน
                    สัญญานี้จะเรียกว่า "<strong style="font-weight: bold;">ผู้ให้เช่า</strong>" ฝ่ายหนึ่งกับ <b><?= $this->db->get_where('member', array('id' => $member_id))->row_array()['customer_firstname']?> <?= $this->db->get_where('member', array('id' => $member_id))->row_array()['customer_lastname']?></b>
                    อยู่บ้านเลขที่ <b><?= $this->db->get_where('member', array('id' => $member_id))->row_array()['customer_address']?></b> จังหวัด <b><?= $this->db->get_where('member', array('id' => $member_id))->row_array()['province']?></b> 
                    ซึ่งต่อไปในสัญญานี้จะเรียกว่า "<strong style="font-weight: bold;">ผู้เช่า</strong>" อีกฝ่ายหนึ่ง<br>
                    <p class="text-ident">ทั้งสองฝ่ายตกลงทำสัญญากันโดยมีข้อความดังต่อไปนี้</p>
                    <p class="text-ident"><strong style="font-weight: bold;">ข้อ ๑</strong>  ผู้เช่าตกลงเช่าและผู้ให้เช่าตกลงให้เช่าห้องพักอาศัยห้องเลขที่ <b><?=$this->db->get_where('room', array('id' => $room_id))->row_array()['number_room']; ?></b></p>
                    <b>หอพักแตงโม เลขที่ตั้ง224/7 ถนนสีหราชเดโชชัย ต.ในเมือง อ.พิษณุโลก จ.พิษณุโลก</b> เพื่อใช้เป็น
                    ที่พักอาศัย ในอัตราค่าเช่าเดือนละ <b><?=$this->db->get_where('room', array('id' => $room_id))->row_array()['price_per_month']; ?></b> บาท ค่าเช่านี้ไม่รวมถึงค่าไฟฟ้า
                    ค่าน้ำประปา ซึ่งผู้เช่าต้องชำระแก่ผู้ให้เช่าตามอัตราที่กำหนดไว้ในสัญญาข้อ ๔ <br>
                    <p class="text-ident"><strong style="font-weight: bold;">ข้อ ๒</strong> ผู้เช่าตกลงเช่าห้องพักอาศัยตามสัญญาข้อ ๑ </p>
                    <p class="text-ident"><strong style="font-weight: bold;">ข้อ ๓</strong> การชำระค่าเช่า ผู้เช่าตกลงจะชำระค่าเช่าแก่ผู้ให้เช่าเป็นการล่วงหน้า โดยชำระภายในวันที่ <b><?=$this->db->get_where('pay_limit_date', array('id' => 1))->row_array()['day']; ?></b> <br>ของทุกเดือนตลอดเวลาอายุการเช่า</p>
                    <p class="text-ident"><strong style="font-weight: bold;">ข้อ ๔</strong> ผู้ให้เช่าคิดค่าไฟฟ้า ค่าน้ำประปา ในอัตราดังนี้
                    <p class="text-ident2">(๑) ค่าไฟฟ้ายูนิตละ <b><?=$this->db->get_where('electric_rate', array('id' => 1))->row_array()['rate_price']; ?></b> บาท</p>
                    <p class="text-ident2">(๒) ค่าน้ำประปาลูกบาศก์เมตรละ <b><?=$this->db->get_where('water_rate', array('id' => 1))->row_array()['rate_price']; ?></b> บาท</p>

                    <p class="text-ident"><strong style="font-weight: bold;">ข้อ ๕</strong>  ผู้เช่าต้องชำระค่าไฟฟ้า ค่าน้ำประปา ตามจำนวนหน่วยที่ใช้ในแต่ละเดือน และต้องชำระพร้อม กับการชำระค่าเช่า ของเดือนถัดไป</p>
                    <p class="text-ident"><strong style="font-weight: bold;">ข้อ ๖</strong>  เพื่อเป็นการปฏิบัติตามสัญญาเช่า ผู้เช่าตกลงมอบเงินประกันแก่ผู้ให้เช่าไว้เป็นจำนวน  <b><?=$this->db->get_where('deposit', array('id' => 1))->row_array()['price']; ?></b>  บาท เงินประกันนี้ผู้ให้เช่าจะคืนให้แก่ผู้เช่าเมื่อผู้เช่ามิได้
                        ผิดสัญญา และมิได้ค้างชำระเงินต่างๆ ตามสัญญานี้</p>
                  
                    <p class="text-ident"><strong style="font-weight: bold;">ข้อ ๗</strong>  ผู้เช่าต้องเป็นผู้ดูแลรักษาความสะอาดบริเวณทางเดินส่วนกลางหน้าห้องพักอาศัยของผู้เช่า และผู้เช่าจะต้องไม่นำสิ่งของใดๆ มาวางไว้ในบริเวณทางเดินดังกล่าว
                    <p class="text-ident"><strong style="font-weight: bold;">ข้อ ๘</strong>  ผู้เช่าต้องดูแลห้องพักอาศัยและทรัพย์สินต่างๆ ในห้องพักดังกล่าวเสมือนเป็นทรัพย์สินของตนเอง และต้องรักษาความสะอาดตลอดจนรักษาความสงบเรียบร้อยไม่ก่อให้เกิดเสียงให้เป็นที่เดือดร้อนรำคาญแก่ผู้อยู่ห้อง พักอาศัยข้างเคียง
                    <p class="text-ident"><strong style="font-weight: bold;">ข้อ ๙</strong>  ผู้เช่าต้องเป็นผู้รับผิดชอบในบรรดาความสูญหาย เสียหาย หรือบุบสลายอย่างใดๆ อันเกิดแก่ห้องพักอาศัย และทรัพย์สินต่างๆ ในห้องพักดังกล่าว
                    <p class="text-ident"><strong style="font-weight: bold;">ข้อ ๑๐</strong>  ผู้เช่าต้องยอมให้ผู้ให้เช่า หรือตัวแทนของผู้ให้เช่าเข้าตรวจดูห้องพักอาศัยได้เป็นครั้งคราวในระยะเวลา อันสมควร
                    <p class="text-ident"><strong style="font-weight: bold;">ข้อ ๑๑</strong>  ผู้เช่าต้องไม่ทำการดัดแปลง ต่อเติม หรือรื้อถอนห้องพักอาศัยและทรัพย์สินต่างๆ ในห้องพักดังกล่าว ไม่ว่าทั้งหมดหรือบางส่วน หากฝ่าฝืนผู้ให้เช่าจะเรียกให้ผู้เช่าทำทรัพย์สินดังกล่าวให้กลับคืนสู่สภาพเดิม และเรียกให้ผู้เช่า รับผิดชดใช้ค่าเสียหายอันเกิดความสูญหาย เสียหาย หรือบุบสลายใดๆ อันเนื่องมาจากการดัดแปลง ต่อเติม หรือรื้อถอนดังกล่าว
                    <p class="text-ident"><strong style="font-weight: bold;">ข้อ ๑๒</strong>  ผู้เช่าต้องไม่นำบุคคลอื่นนอกจากบุคคลในครอบครัวของผู้เช่าเข้ามาพักอาศัยในห้องพักอาศัย
                    <p class="text-ident"><strong style="font-weight: bold;">ข้อ ๑๓</strong>  ผู้เช่าสัญญาว่าจะปฏิบัติตามระเบียบข้อบังคับของอพาร์ตเม้นต์ท้ายสัญญานี้ซึ่งคู่สัญญาทั้งสอง ฝ่ายให้ถือว่า ระเบียบข้อบังคับดังกล่าวเป็นส่วนหนึ่งแห่งสัญญาเช่านี้ด้วย หากผู้เช่าละเมิดแล้วผู้ให้เช่าย่อมให้สิทธิตามข้อ ๑๗ และข้อ ๑๘ แห่งสัญญานี้ได้
                    <p class="text-ident"><strong style="font-weight: bold;">ข้อ ๑๔</strong>  ผู้ให้เช่าไม่ต้องรับผิดชอบในความสูญหายหรือความเสียหายอย่างใดๆ อันเกิดขึ้นแก่รถยนต์รวม ทั้งทรัพย์สินต่างๆ ในรถยนต์ของผู้เช่า ซึ่งได้นำมาจอดไว้ในที่จอดรถยนต์ที่ผู้ให้เช่าจัดไว้ให้
                    <p class="text-ident"><strong style="font-weight: bold;">ข้อ ๑๕</strong>  ผู้เช่าตกลงว่าการผิดสัญญาเช่าเครื่องเรือนซึ่งผู้เช่าได้ทำไว้กับผู้ให้เช่าต่างหากจากสัญญานี้ ถือว่าเป็นการผิดสัญญานี้ด้วย และโดยนัยเดียวกัน การผิดสัญญานี้ย่อมถือเป็นการผิดสัญญาเช่าเครื่องเรือนด้วย
                    <p class="text-ident"><strong style="font-weight: bold;">ข้อ ๑๖</strong>  หากผู้เช่าประพฤติผิดสัญญาข้อหนึ่งข้อใด หรือหลายข้อก็ดี ผู้เช่าตกลงให้ผู้ให้เช่าใช้สิทธิดังต่อไปนี้ ข้อใดข้อหนึ่งหรือหลายข้อรวมกันก็ได้ คือ
                    <p class="text-ident2">(๑) บอกเลิกสัญญาเช่า</p>
                    <p class="text-ident2">(๒) เรียกค่าเสียหาย</p>
                    <p class="text-ident2">(๓) บอกกล่าวให้ผู้เช่าปฏิบัติตามข้อกำหนดในสัญญาภายในกำหนดเวลาที่ผู้ให้เช่าเห็นสมควร</p>
                    <p class="text-ident2">(๔) ตัดกระแสไฟฟ้า น้ำประปา และโทรศัพท์ ได้ในทันที โดยไม่จำเป็นต้องบอกกล่าวแก่ผู้เช่าเป็นการล่วงหน้า</p>
                    <p class="text-ident"><strong style="font-weight: bold;">ข้อ ๑๗</strong> ในกรณีที่สัญญาเช่าระงับสิ้นลง ไม่ว่าด้วยเหตุใดๆ ก็ตาม ผู้เช่าต้องส่งมอบห้อง พักอาศัยคืนแก่ผู้ให้ เช่าทันที หากผู้เช่าไม่ปฏิบัติผู้ให้เช่าสิทธิกลับเข้าครอบครองห้องพักอาศัยที่ให้เช่าและขนย้ายบุคคล และทรัพย์สิน ของผู้เช่าออกจากห้องพักดังกล่าวได้ โดยผู้เช่าเป็นผู้รับผิดชอบในความสูญหายหรือความเสียหายอย่างใดๆ อันเกิดขึ้นแก่ทรัพย์สินของผู้เช่า ทั้งผู้ให้เช่ามีสิทธิริบเงินประกันการเช่า ตามที่ระบุไว้ในสัญญาข้อ ๖ ได้ด้วย
                    <p class="text-ident"><strong style="font-weight: bold;">ข้อ ๑๘</strong>  ในวันทำสัญญานี้ ผู้เช่าได้ตรวจดูห้องพักอาศัยที่เช่าตลอดจนทรัพย์สินต่างๆ ในห้องพักดังกล่าวแล้วเห็นว่า มีสภาพปกติทุกประการ และผู้ให้เช่าได้ส่งมอบห้องพักอาศัยและทรัพย์สินต่างๆ ในห้องพักแก่ผู้เช่าแล้ว
                        คู่สัญญาได้อ่าน และเข้าใจข้อความในสัญญานี้โดยตลอดแล้วเห็นว่าถูกต้อง จึงได้ลงลายมือชื่อไว้เป็นสำคัญต่อหน้าพยาน
                    </p>
                    <p>&nbsp;</p>

                </div>
                <div class="col-md-12">
                    <div style="text-align: right;">
                        <p>ลงชื่อ...........................................ผู้เช่า<br>
                            (.........................................................)
                        </p>
                        <p>ลงชื่อ..........................................ผู้ให้เช่า<br>
                            (.........................................................)
                        </p>
                        <p>
                            ลงชื่อ............................................พยาน<br>
                            (.........................................................)
                        </p>
                        <p>
                            ลงชื่อ............................................พยาน<br>
                            (.........................................................)
                        </p>
                    </div>
                </div>


            </div> <!-- /row -->
        </div> 




        <style>

            body {

                font-family: 'thsaraban';
                font-size: 19px;


            }
            .text-ident{
                text-indent: 60px;
                margin-bottom: 0px;
            }
            .text-ident2{
                text-indent: 80px;
                margin-bottom: 0px;
            }



        </style>
        <script>

              window.print();
          
        </script>
    </body>
</html>