<h4 class="head-label"><?= $category_name ?></h4>

<table class="table table-bordered table-hover" id="choose_category_child" style="cursor: pointer;">
    <tbody>
        <?php
        if (count($res_menu) > 0) {
            foreach ($res_menu as $key => $rows) {
                ?>
                <tr class="" onclick="">
                    <td colspan="4">
                        <span class="label bg-purple2 border-radius-0 margin-r-5" style="font-size: 12px;"><?= $key + 1 ?>.</span>
                        <span style="font-size: 16px;"><?= $rows['product'] ?></span>
                    </td>
                </tr>

                <?php if ($rows['hot'] != 0) { ?>
                    <tr class="child-cost" data-topping-id="0" data-menu-id="<?= $rows['id'] ?>" onclick="add_list_menu(this)" data-menu-type="ร้อน"  data-price="<?= $rows['hot'] ?>" data-menu-name="<?= $rows['product'] ?>">
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
                    <tr class="child-cost"  data-topping-id="0" data-menu-id="<?= $rows['id'] ?>" onclick="add_list_menu(this)" data-menu-type="เย็น" data-price="<?= $rows['iced'] ?>" data-menu-name="<?= $rows['product'] ?>">
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
                    <tr class="child-cost"  data-topping-id="0" data-menu-id="<?= $rows['id'] ?>" data-menu-type="ปั่น" onclick="add_list_menu(this)" data-price="<?= $rows['smoothie'] ?>" data-menu-name="<?= $rows['product'] ?>">
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

<!-- script for views/pos/ajax_get_catelog_child.php-->
<script>

    var num_rows = 0;

    function add_list_menu(ele) {

        var menu_price = $(ele).attr('data-price');
        var menu_id = $(ele).attr('data-menu-id');
        var menu_type = $(ele).attr('data-menu-type');
        var menu_name = $(ele).attr('data-menu-name');
        var menu_topping_id = $(ele).attr('data-topping-id');
        var comment = '';


        //   console.log(menu_name);
        // console.log($(ele).attr("data-menu-type"));
        //   console.log($(ele).find("menu-type").text());

        var _menu_id = 0;
        var _menu_type = '';
        var _menu_name = '';
        var _menu_topping_id = '';

        $('#list-choose-menu').attr('data-list-menu-id');

        var tools_box = "<button type='button' class='btn btn-xs btn-default btn-flat pull-right' onclick='toppings(this)' data-toggle='modal' data-target='#modal-topping' ><i class='fa fa-bolt'></i>  Topping</button>";
        var tools_comment = "<button type='button' class='btn btn-xs btn-info btn-flat pull-right' onclick='comments(this)' data-toggle='modal' data-target='#modal-comment'> หมายเหตุ</button>";

        if (num_rows === 0) {

            var tr_menu = "<tr data-topping-id='0' data-comment='' data-list-menu-name='" + menu_name + "' data-list-menu-topping-id='" + menu_name + "' data-list-menu-id='" + menu_id + "' data-list-menu-price='" + menu_price + "' data-list-menu-qty='1' data-list-menu-type='" + menu_type + "'>";
            tr_menu += "<td class='text-center text-bold' style='font-size: 16px;'>";
            tr_menu += "<i class='fa fa-minus' onclick='negative_number(this)'></i>";
            tr_menu += "<input autocomplete='off' name='menu_qty[]' data-validation='required,number' id='menu-qty' class='menu-qty' value='1' style='width: 26px'>";
            tr_menu += "<input type='hidden' name='topping_id[]' value='0'>";
            tr_menu += "<input type='hidden' name='menu_id[]' value='" + menu_id + "'>";
            tr_menu += "<input type='hidden' name='menu_type[]' value='" + menu_type + "'>";
            tr_menu += "<input type='hidden' name='menu_price[]' value='" + menu_price + "'>";
            tr_menu += "<input type='hidden' name='menu_name[]' value='" + menu_name + "'>";
            tr_menu += "<input type='hidden' name='comment[]' value='" + comment + "'>";
            tr_menu += "<i class='fa fa-plus' onclick='positive_number(this)'></i> </td>";
            tr_menu += "<td style='font-size: 16px;'><div class='row'>" + menu_name + " (" + menu_type + ")" + tools_box + tools_comment + "</div><div class='row topping-title'><ul></ul></div></td>";
            tr_menu += "<td style='font-size: 14px;'><div style='padding:0 5px 0 10px;' class='comment-text'></div></td>";
            tr_menu += "<td class='text-right' style='font-size: 16px;'>  ฿ <span class='price_of_product'>" + menu_price + "</span>.00 </td>";
            tr_menu += "<td onclick='remove_list_menu(this)' class='text-right text-bold' style='font-size: 16px;'><i class='fa fa-times text-red'></i></td>";
            tr_menu += "</tr>";

            $("#list-choose-menu table tbody").append(tr_menu);
            num_rows = num_rows + 1;

        } else {

//วนรอบเช็ค
            $('#list-choose-menu table tbody tr').each(function () {
                if (menu_name === $(this).attr('data-list-menu-name') && menu_id === $(this).attr('data-list-menu-id') &&
                        menu_type === $(this).attr('data-list-menu-type') && menu_topping_id === $(this).attr('data-topping-id')) {
                    //ถ้ามี item อยู่แล้ว
                    chk_dup = chk_dup + 1;
                    _menu_type = menu_type;
                    _menu_id = menu_id;
                    _menu_id = menu_id;
                    _menu_name = menu_name;
                    _menu_topping_id = menu_topping_id;

                }
            });

            if (chk_dup > 0) {
                //update
                $('#list-choose-menu table tbody tr').each(function () {
                    if ($(this).attr('data-list-menu-name') === _menu_name && $(this).attr('data-list-menu-id') === _menu_id
                            && $(this).attr('data-list-menu-type') === _menu_type && $(this).attr('data-topping-id') === _menu_topping_id) {

                        var p_qty = parseInt($(this).find('#menu-qty').val()) + 1;

                        $(this).find('#menu-qty').val(p_qty);
                        $(this).attr('data-list-menu-qty', p_qty);
                    }

                });

            } else {
                //add new
                var tr_menu = "<tr data-topping-id='0' data-comment='' data-list-menu-name='" + menu_name + "' data-list-menu-id='" + menu_id + "' data-list-menu-price='" + menu_price + "' data-list-menu-qty='1' data-list-menu-type='" + menu_type + "'>";
                tr_menu += "<td class='text-center text-bold' style='font-size: 16px;'>";
                tr_menu += "<i class='fa fa-minus' onclick='negative_number(this)'></i>";
                tr_menu += "<input autocomplete='off' name='menu_qty[]' id='menu-qty' class='menu-qty' value='1' data-validation='required,number' style='width: 26px'>";
                tr_menu += "<input type='hidden' name='topping_id[]' value='0'>";
                tr_menu += "<input type='hidden' name='menu_id[]' value='" + menu_id + "'>";
                tr_menu += "<input type='hidden' name='menu_type[]' value='" + menu_type + "'>";
                tr_menu += "<input type='hidden' name='menu_price[]' value='" + menu_price + "'>";
                tr_menu += "<input type='hidden' name='menu_name[]' value='" + menu_name + "'>";
                tr_menu += "<input type='hidden' name='comment[]' value='" + comment + "'>";
                tr_menu += "<i class='fa fa-plus' onclick='positive_number(this)'></i> </td>";
                tr_menu += "<td style='font-size: 16px;'><div class='row'>" + menu_name + " (" + menu_type + ")" + tools_box + tools_comment + "</div><div class='row topping-title'><ul></ul></div></td>";
                tr_menu += "<td style='font-size: 14px;'><div style='padding:0 5px 0 10px;' class='comment-text'></div></td>";
                tr_menu += "<td class='text-right' style='font-size: 16px;'>  ฿ <span class='price_of_product'>" + menu_price + "</span>.00  </td>";
                tr_menu += "<td onclick='remove_list_menu(this)' class='text-right text-bold' style='font-size: 16px;'><i class='fa fa-times text-red'></i></td>";
                tr_menu += "</tr>";

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
            var _qty = parseInt($(this).attr('data-list-menu-qty'));
            all_items = all_items + _qty;
        });
        $('#num_rows').text(all_items);
        total_price();
    }
    function total_price() {

        var all_price = 0;
        $('#list-choose-menu table tbody tr').each(function () {
            // var _qty = parseInt($(this).attr('data-list-menu-qty'));
            //  var _price = parseInt($(this).attr('data-list-menu-price'));
            all_price += parseInt($(this).find('.price_of_product').text());

        });
        $('#total_price').text(all_price);

    }
    function calulate_topping() {

        var topping_total_price = 0;
        $('#list-choose-menu table tbody tr').each(function () {
            var basic_price = parseInt($(this).attr('data-list-menu-price'));
            var li = $(this).find('.topping-title ul li');
            var _qty = parseInt($(this).attr('data-list-menu-qty'));


            if (li.length > 0) {
                $(li).each(function () {
                    topping_total_price += parseInt($(this).attr('data-topping-price'));
                });

                $(this).find('.price_of_product').text((topping_total_price + basic_price) * _qty);

                topping_total_price = 0;
                basic_price = 0;
            } else {

                $(this).find('.price_of_product').text(basic_price * _qty);
            }
        });
        total_price();

    }
    function remove_list_menu(ele) {
        //   $(ele).remove();
        $(ele).closest('tr').remove();
        count_all_items();
        num_rows = num_rows - 1;
    }

    function positive_number(ele) {

        var menu_qty = parseInt($(ele).closest('tr').find('#menu-qty').val());
        if (menu_qty > 0) {
            menu_qty = menu_qty + 1;

            $(ele).closest('tr').find('#menu-qty').val(menu_qty);

            $(ele).closest('tr').attr('data-list-menu-qty', menu_qty);
        }
        count_all_items();

        calulate_topping();
        // total_price();


    }
    function negative_number(ele) {
        var menu_qty = parseInt($(ele).closest('tr').find('#menu-qty').val());
        if (menu_qty > 1) {
            menu_qty = menu_qty - 1;
            $(ele).closest('tr').find('#menu-qty').val(menu_qty);
            $(ele).closest('tr').attr('data-list-menu-qty', menu_qty);
        }
        count_all_items();
        calulate_topping();
        // total_price();

    }

    $(document).on('keyup', '.menu-qty', function () {

        if (!$.isNumeric($(this).val())) {
            $(this).val('1');
            $(this).closest('tr').attr('data-list-menu-qty', $(this).val());
        } else {
            $(this).closest('tr').attr('data-list-menu-qty', $(this).val());
        }
        count_all_items();

    });



</script>
<script>
    $(document).ready(function () {

        $('#choose_category_child .child-cost').click(function () {
            $('#choose_category_child .child-cost').removeClass('bg-purple-light-active');
            $(this).addClass('bg-purple-light-active');
        });

    });


    var index_selected = '';
    // var _li_topping = '';
    function toppings(ele) {


        //index ที่เลือก
        index_selected = $(ele).closest('tr').index();
        var indextr = index_selected + 1;
        var res_tr = $("#list-choose-menu tr:eq(" + indextr + ")");

        var li = "";

        var _li_copy = $(res_tr).find('.topping-title ul li').clone();

        var _li_topping = get_li(_li_copy);
        //console.log(_li_topping);
        $('#selecting-topping-list li').remove();
        $("#selecting-topping-list").append(_li_topping);
        $.ajax({
            type: 'GET',
            url: '<?= base_url('pos/ajax_get_topping') ?>',
            success: function (data) {
                //console.log(data);
                var obj = $.parseJSON(data);
                $.each(obj, function (i, val) {

                    var btn = "<button type='button' class='btn btn-xs btn-info btn-flat pull-right' data-topping-id=" + val.id + "  data-topping-price=" + val.price + " data-topping-name='" + val.topping_name + "' onclick='selecting_topping(this)'><i class='fa fa-bolt'></i> เลือก</button>";

                    li += "<li><span>" + val.topping_name + " , + ฿ " + val.price + ".00 </span>" + btn + "</li>";

                });
                //clear list
                $('#topping-list li').remove();

                $('#topping-list').append(li);

                // topping-list
            }
        });

        var menu_name = $(ele).closest('tr').attr('data-list-menu-name');
        var menu_type = $(ele).closest('tr').attr('data-list-menu-type');
        var menu_price = $(ele).closest('tr').attr('data-list-menu-price');

        $('#modal-topping .menu-name').text(menu_name);
        $('#modal-topping .menu-price').text(menu_price);

    }
    function selecting_topping(ele) {

        var li = '';
        //  console.log($(ele).attr('data-topping-name'));
        var id = $(ele).attr('data-topping-id');
        var name = $(ele).attr('data-topping-name');
        var price = $(ele).attr('data-topping-price');

        var btn_delete = "<i onclick='remove_topping_list(this)' class='fa fa-trash-o text-red'></i>";

        li += "<li data-topping-id=" + id + " data-topping-name='" + name + "' data-topping-price=" + price + " style='font-style: italic;'><i class='fa fa-check'></i> " + name + ",&nbsp;&nbsp;&nbsp;&nbsp; +" + price + " ฿&nbsp;&nbsp;&nbsp;&nbsp;" + btn_delete + "</li>";

        $('#selecting-topping-list').append(li);

    }
    function get_li(ele) {

        var obj_li = ele;
        var li = '';

        $.each(obj_li, function (i, el) {

            var id = $(el).attr('data-topping-id');

            var name = $(el).attr('data-topping-name');
            var price = $(el).attr('data-topping-price');

            // li += "<li data-topping-id=" + id + " data-topping-name=" + name + " data-topping-price=" + price + " style='font-style: italic;'>+ " + name + ",&nbsp;&nbsp;&nbsp;&nbsp; " + price + " ฿&nbsp;&nbsp;&nbsp;&nbsp;</li>";

            var btn_delete = "<i onclick='remove_topping_list(this)' class='fa fa-trash-o text-red'></i>";

            li += "<li data-topping-id=" + id + " data-topping-name='" + name + "' data-topping-price=" + price + " style='font-style: italic;'><i class='fa fa-check'></i> " + name + ",&nbsp;&nbsp;&nbsp;&nbsp; +" + price + " ฿&nbsp;&nbsp;&nbsp;&nbsp;" + btn_delete + "</li>";

        });

        //  $('#selecting-topping-list').append(li);

        return li;

    }

    function remove_topping_list(ele) {
        $(ele).closest('li').remove();
    }

    function save() {
        var obj_li = $('#selecting-topping-list li');

        var li = '';
        var _id = '';

        $.each(obj_li, function (i, el) {

            var id = $(el).attr('data-topping-id');
            var name = $(el).attr('data-topping-name');
            var price = $(el).attr('data-topping-price');
            _id += ',' + id;
            console.log(name);

            li += "<li data-topping-id=" + id + " data-topping-name='" + name + "' data-topping-price=" + price + " style='font-style: italic;'> " + name + ",&nbsp;&nbsp;&nbsp;&nbsp; " + price + " ฿&nbsp;&nbsp;&nbsp;&nbsp;</li>";

        });

        var _index = index_selected + 1;

        $('#list-choose-menu').find("tr:eq( " + _index + " )").find('.topping-title ul li').remove();
        var tr = $('#list-choose-menu').find("tr:eq( " + _index + " )");
        $(tr).find('.topping-title ul').append(li);

        if (_id.substring(1) === '') {
            $(tr).attr('data-topping-id', "0");
            $(tr).find("[name='topping_id[]']").val("0");
        } else {
            $(tr).find("[name='topping_id[]']").val(_id.substring(1));
            $(tr).attr('data-topping-id', _id.substring(1));
        }



        calulate_topping();
        $('#modal-topping').modal('hide');
    }


    var ele_btn_comment;
    var current_val;
    function comments(ele) {
        ele_btn_comment = ele;
        //console.log(ele_btn_comment);


        current_val = $(ele_btn_comment).closest('tr').find("[name='comment[]']").val();
        if (current_val != '') {

            $('#comment').val(current_val);


        } else {
            $('#comment').val('');
        }
        //  $('.comment-text').text(current_val);
        // console.log(current_val);

    }
    function save_comment(ele) {

        //  console.log($('#comment').val());
        var commet_text = ($('#comment').val().trim());
        $(ele_btn_comment).closest('tr').find("[name='comment[]']").val(commet_text);
        // console.log(trim(xx));

        $(ele_btn_comment).closest('tr').find(".comment-text").text(commet_text);
        //$('.comment-text').text()
        $('#modal-comment').modal('hide');
        return;
        var obj_li = $('#selecting-topping-list li');

        var li = '';
        var _id = '';

        $.each(obj_li, function (i, el) {

            var id = $(el).attr('data-topping-id');
            var name = $(el).attr('data-topping-name');
            var price = $(el).attr('data-topping-price');
            _id += ',' + id;
            console.log(name);

            li += "<li data-topping-id=" + id + " data-topping-name='" + name + "' data-topping-price=" + price + " style='font-style: italic;'> " + name + ",&nbsp;&nbsp;&nbsp;&nbsp; " + price + " ฿&nbsp;&nbsp;&nbsp;&nbsp;</li>";

        });

        var _index = index_selected + 1;

        $('#list-choose-menu').find("tr:eq( " + _index + " )").find('.topping-title ul li').remove();
        var tr = $('#list-choose-menu').find("tr:eq( " + _index + " )");
        $(tr).find('.topping-title ul').append(li);

        if (_id.substring(1) === '') {
            $(tr).attr('data-topping-id', "0");
            $(tr).find("[name='topping_id[]']").val("0");
        } else {
            $(tr).find("[name='topping_id[]']").val(_id.substring(1));
            $(tr).attr('data-topping-id', _id.substring(1));
        }



        // calulate_topping();
        $('#modal-comment').modal('hide');
    }

</script>
<style>
    #choose_category_child tr td{
        border: 0px;
    }
    #choose_category_child .child-cost:hover{
        background-color: #EFCEF0;
    }

</style>




