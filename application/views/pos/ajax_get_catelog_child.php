<h4 class="head-label"><?= $category_name ?></h4>
<table class="table table-bordered table-hover" id="choose_category_child" style="cursor: pointer;">
    <tbody>
        <?php
        if (count($res_menu) > 0) {
            foreach ($res_menu as $key => $rows) {
                ?>
                <tr class="" onclick="test(<?= $rows['id'] ?>)">
                    <td colspan="4">
                        <span class="label bg-purple2 border-radius-0 margin-r-5" style="font-size: 12px;"><?= $key + 1 ?>.</span>
                        <span style="font-size: 16px;"><?= $rows['product'] ?></span>
                    </td>
                </tr>

                <?php if ($rows['hot'] != 0) { ?>
                    <tr class="child-cost" data-menu-id="<?= $rows['id'] ?>" onclick="add_list_menu(this)" data-menu-type="ร้อน"  data-price="<?= $rows['hot'] ?>" data-menu-name="<?= $rows['product'] ?>">
                        <td style="width: 40px;"></td>
                        <td style="width: 40px;">
                            <span class="label bg-orange border-radius-0 margin-r-5" style="font-size: 12px;"><?= $key + 1 ?>.</span>     
                        </td>
                        <td>

                            <span style="font-size: 16px;" id="menu-type">ร้อน</span>
                        </td>
                        <td>

                            <span style="font-size: 16px;"><span class="pull-right badge bg-red" style="font-size: 14px;">฿ <?= $rows['hot'] ?></span></span>
                        </td>
                    </tr>
                <?php } ?>
                <?php if ($rows['iced'] != 0) { ?>
                    <tr class="child-cost" data-menu-id="<?= $rows['id'] ?>" onclick="add_list_menu(this)" data-menu-type="เย็น" data-price="<?= $rows['iced'] ?>" data-menu-name="<?= $rows['product'] ?>">
                        <td style="width: 40px;"></td>
                        <td style="width: 40px;">
                            <span class="label bg-blue border-radius-0 margin-r-5" style="font-size: 12px;"><?= $key + 1 ?>.</span>     
                        </td>
                        <td>

                            <span style="font-size: 16px;" id="menu-type">เย็น</span>
                        </td>
                        <td>

                            <span style="font-size: 16px;"><span class="pull-right badge bg-red " style="font-size: 14px;">฿ <?= $rows['iced'] ?></span></span>
                        </td>
                    </tr>
                <?php } ?>
                <?php if ($rows['smoothie'] != 0) { ?>
                    <tr class="child-cost" data-menu-id="<?= $rows['id'] ?>" data-menu-type="ปั่น" onclick="add_list_menu(this)" data-price="<?= $rows['smoothie'] ?>" data-menu-name="<?= $rows['product'] ?>">
                        <td style="width: 40px;"></td>
                        <td style="width: 40px;">
                            <span class="label bg-gray border-radius-0 margin-r-5" style="font-size: 12px;"><?= $key + 1 ?>.</span>     
                        </td>
                        <td>

                            <span style="font-size: 16px;" id="menu-type">ปั่น</span>
                        </td>
                        <td>

                            <span style="font-size: 16px;"><span class="pull-right badge bg-red " style="font-size: 14px;">฿ <?= $rows['smoothie'] ?></span></span>
                        </td>
                    </tr>
                <?php } ?>


            <?php } ?>
        <?php } ?>


    </tbody>
</table>

<script>
    var num_rows = 0;
    var chk_dup = 0;
    function test(data_menu_id) {


        // $(".child-cost").slideUp('fast', function () {
        //  $("[data-menu-id='" + data_menu_id + "']").slideToggle('fast');
        // });


    }
    function add_list_menu(ele) {

        var menu_price = $(ele).attr('data-price');
        var menu_id = $(ele).attr('data-menu-id');
        var menu_type = $(ele).attr('data-menu-type');
        var menu_name = $(ele).attr('data-menu-name');
        // console.log($(ele).attr("data-menu-type"));
        //   console.log($(ele).find("menu-type").text());

        var _menu_id = 0;
        var _menu_type = '';

        $('#list-choose-menu').attr('data-list-menu-id');
        if (num_rows === 0) {

            var tr_menu = "<tr data-list-menu-id='" + menu_id + "' data-list-menu-price='" + menu_price + "' data-list-menu-qty='1' data-list-menu-type='" + menu_type + "'>";
            tr_menu += "<td class='text-center text-bold' style='font-size: 16px;'>";
            tr_menu += "<i class='fa fa-minus' onclick='negative_number(this)'></i>";
            tr_menu += "<input autocomplete='off' name='menu_qty[]'  data-validation='required,number' id='menu-qty' class='menu-qty' value='1' style='width: 26px'>";
            tr_menu += "<input type='hidden' name='menu_id[]' value='" + menu_id + "'>";
            tr_menu += "<input type='hidden' name='menu_type[]' value='" + menu_type + "'>";
            tr_menu += "<input type='hidden' name='menu_price[]' value='" + menu_price + "'>";
            tr_menu += "<input type='hidden' name='menu_name[]' value='" + menu_name + "'>";
            tr_menu += "<i class='fa fa-plus' onclick='positive_number(this)'></i> </td><td style='font-size: 16px;'>" + menu_name + " (" + menu_type + ")</td><td class='text-right' style='font-size: 16px;'>  ฿ " + menu_price + " </td><td onclick='remove_list_menu(this)' class='text-right text-bold' style='font-size: 16px;'><i class='fa fa-times text-red'></i></td></tr>";
            $("#list-choose-menu table tbody").append(tr_menu);
            num_rows = num_rows + 1;
        } else {

            $('#list-choose-menu table tbody tr').each(function () {
                if (menu_id === $(this).attr('data-list-menu-id') && menu_type === $(this).attr('data-list-menu-type')) {
                    //ถ้ามี item อยู่แล้ว
                    chk_dup = chk_dup + 1;
                    _menu_type = menu_type;
                    _menu_id = menu_id;

                }

            });

            if (chk_dup > 0) {
                //update
                $('#list-choose-menu table tbody tr').each(function () {
                    if ($(this).attr('data-list-menu-id') === _menu_id && $(this).attr('data-list-menu-type') === _menu_type) {

                        var p_qty = parseInt($(this).find('#menu-qty').val()) + 1;

                        $(this).find('#menu-qty').val(p_qty);
                        $(this).attr('data-list-menu-qty', p_qty);
                    }

                });

            } else {
                //add new
                var tr_menu = "<tr data-list-menu-id='" + menu_id + "' data-list-menu-price='" + menu_price + "' data-list-menu-qty='1' data-list-menu-type='" + menu_type + "'>";
                tr_menu += "<td class='text-center text-bold' style='font-size: 16px;'>";
                tr_menu += "<i class='fa fa-minus' onclick='negative_number(this)'></i>";
                tr_menu += "<input autocomplete='off' name='menu_qty[]' id='menu-qty' class='menu-qty' value='1' data-validation='required,number' style='width: 26px'>";
                tr_menu += "<input type='hidden' name='menu_id[]' value='" + menu_id + "'>";
                tr_menu += "<input type='hidden' name='menu_type[]' value='" + menu_type + "'>";
                tr_menu += "<input type='hidden' name='menu_price[]' value='" + menu_price + "'>";
                tr_menu += "<input type='hidden' name='menu_name[]' value='" + menu_name + "'>";
                tr_menu += "<i class='fa fa-plus' onclick='positive_number(this)'></i> </td><td style='font-size: 16px;'>" + menu_name + " (" + menu_type + ")</td><td class='text-right' style='font-size: 16px;'>  ฿ " + menu_price + " </td><td onclick='remove_list_menu(this)' class='text-right text-bold' style='font-size: 16px;'><i class='fa fa-times text-red'></i></td></tr>";
                $("#list-choose-menu table tbody").append(tr_menu);
                num_rows = num_rows + 1;

            }
            chk_dup = 0;

        }
        count_all_items();
     

    }
    function count_all_items() {
        var all_items = 0;
        $('#list-choose-menu table tbody tr').each(function () {
           var _qty =  parseInt($(this).attr('data-list-menu-qty'));
           all_items = all_items + _qty;
        });
           $('#num_rows').text(all_items);
           total_price();
    }
      function total_price() {
        var all_price = 0;
        $('#list-choose-menu table tbody tr').each(function () {
             var _qty =  parseInt($(this).attr('data-list-menu-qty'));
           var _price =  parseInt($(this).attr('data-list-menu-price'));
           all_price = all_price + ( _qty * _price );
        });
           $('#total_price').text(all_price);
    }
    function remove_list_menu(ele) {
        //   $(ele).remove();
        $(ele).closest('tr').remove();
              count_all_items();
    }

    function positive_number(ele) {

        var menu_qty = parseInt($(ele).closest('tr').find('#menu-qty').val());
        if (menu_qty > 0) {
            menu_qty = menu_qty + 1;
            
            $(ele).closest('tr').find('#menu-qty').val(menu_qty);
            
             $(ele).closest('tr').attr('data-list-menu-qty',menu_qty);
        }
              count_all_items();


    }
    function negative_number(ele) {
        var menu_qty = parseInt($(ele).closest('tr').find('#menu-qty').val());
        if (menu_qty > 1) {
            menu_qty = menu_qty - 1;
            $(ele).closest('tr').find('#menu-qty').val(menu_qty);
             $(ele).closest('tr').attr('data-list-menu-qty',menu_qty);
        }
              count_all_items();
    }
    
    $(document).on('keyup', '.menu-qty', function (){
           
            if(!$.isNumeric($(this).val())){
                 $(this).val('1');
                  $(this).closest('tr').attr('data-list-menu-qty', $(this).val());
             }else{
                $(this).closest('tr').attr('data-list-menu-qty', $(this).val());
             }
               count_all_items();
          
     });

    $(document).ready(function () {
        // $(".child-cost").slideUp('fast');

    });
</script>



