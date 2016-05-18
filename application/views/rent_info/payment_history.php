<div class="table-responsive" >
    <table class="table">
        <thead>
        <th>ครั้งที่</th>
        <th>ยอดเงินที่ชำระ</th>
        <th>ตัวเลือก</th>
        </thead>
        <tbody>
            <?php
            $total_paid = 0;


            foreach ($result_active_payment as $key => $row) {
                ?>
                <?php $total_paid = $total_paid + $row['total_paid'] ?>
                <tr class="bg-gray-light">
                    <td> <?= $key + 1 ?></td>
                    <td > <?= $row['total_paid'] ?></td>
                    <td ><a href="javascript:void(0)" onclick="edit_payment('<?= $row['id'] ?>', '<?= $row['total_paid'] ?>')" class="btn btn-sm btn-info">แก้ไข</a> <a href="javascript:void(0)" onclick="delete_payment('<?= $row['id'] ?>')" class="btn btn-sm btn-danger">ลบ</a></td>
                </tr>
            <?php } ?>
            <tr class="bg-gray">
                <td> รวม</td>
                <td> <?= $total_paid ?></td>
                <td> บาท</td>

            </tr>    

        </tbody>
    </table>
</div>


<div class="table-responsive">
    <table class="table">
        <tbody>
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
                    $total_price_water = ($result_active_rent['meter_water_last'] - $result_active_rent['meter_water']) * $water_rate;
                } else {
                    $total_price_water = ($result_active_rent['meter_water_last'] - $result_active_rent_last['meter_water_last'] ) * $water_rate;
                }
            }

            $price_el = $total_price_electric;
            $price_water = $total_price_water;

            //   if ($result_active_rent['id_next_month'] > 0) {
            $still_pay = ($result_active_rent['deposit'] + $result_active_rent['internet'] + $result_active_rent['price_per_month'] + $price_el + $price_water) - $total_paid;
            //  } else {
            //    $still_pay = ($price_el + $price_water) - $total_paid;
            //   }
            ?>
            <tr class="bg-warning">
                <th>ค้างจ่าย :</th>
                <td>
                    <div class="col-md-6">
            <?= $still_pay ?> 
                    </div>
                    <div class="col-md-6">
                        บาท
                    </div>
                </td>
            </tr>
            <tr class="bg-info">
                <th>ชำระเงิน :</th>
                <td>
                    <div class="col-md-6">
                        <input type="text" id="payment_cost" class="form-control" placeholder="จำนวนเงินที่ชำระ (บาท)"  >   
                    </div>

                    <div class="col-md-6">
                        <a href="javascript:void(0)" class="btn btn-sm btn-info" onclick="_add()">บันทึก</a>
                    </div>


                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="box-footer">


</div><!-- /.box-footer -->
<script>
    function _add() {
        // $.blockUI({ message: '<h1><img src="busy.gif" /> Just a moment...</h1>' });

        var id = <?= $result_active_rent['id'] ?>;
        var val = $('#payment_cost').val();
        if ($.isNumeric(val) && parseInt(val) !== 0) {

            $.ajax({
                method: "POST",
                url: "<?= base_url() ?>rent_info/active_payment_add/" + id + "/" + val,
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

                //   $('#payment_history').html(msg);
                $.unblockUI();
                location.reload();

            });
        }
    }
</script>