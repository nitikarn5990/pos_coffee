<ul class="sidebar-menu">
    <li class="header">MAIN NAVIGATION</li>
    <li class="<?php echo activate_menu('home'); ?>"><a href="<?= base_url() ?>home"><i class="fa fa-home"></i> <span>Home</span></a></li>

    <li class="<?php echo activate_menu('pos'); ?>"><a href="<?= base_url() ?>pos"><i class="fa fa-cutlery "></i> <span>การขาย</span></a></li>
    <li class="<?php echo activate_menu('category'); ?>"><a href="<?= base_url() ?>category"><i class="fa fa-folder-open "></i> <span>หมวดหมู่สินค้า</span></a></li>
    <li class="<?php echo activate_menu('menu'); ?>"><a href="<?= base_url() ?>menu"><i class="fa fa-coffee "></i> <span>สินค้า</span></a></li>


    <li class="<?php echo activate_menu('administrator'); ?>"><a href="<?= base_url() ?>administrator"><i class="fa fa-user "></i> <span>พนักงาน</span></a></li>
   
    <li class="<?php echo activate_menu('electric_rate'); ?> treeview">
        <a href="#">
            <i class="fa fa-list-ol"></i> <span>เรทค่าไฟ</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="<?= base_url() ?>electric_rate/edit/1"><i class="fa fa-circle-o"></i> ค่าไฟ</a></li>

        </ul>
    </li>
    <li class="<?php echo activate_menu('water_rate'); ?> treeview">
        <a href="#">
            <i class="fa fa-list-ol"></i> <span>เรทค่าน้ำ</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="<?= base_url() ?>water_rate/edit/1"><i class="fa fa-circle-o"></i> ค่าน้ำ</a></li>

        </ul>
    </li>
    <li class="<?php echo activate_menu('room'); ?> treeview">
        <a href="#">
            <i class="fa fa-list-ol"></i> <span>ข้อมูลห้องเช่า</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="<?= base_url() ?>room"><i class="fa fa-circle-o"></i> ห้องเช่า</a></li>
            <li class="hidden"><a href="<?= base_url() ?>room_option"><i class="fa fa-circle-o"></i> เพิ่ม Option ภายในห้อง</a></li>

        </ul>
    </li>
    <li class="<?php echo activate_menu('rent_info'); ?> treeview">
        <a href="#">
            <i class="fa fa-list-ol"></i> <span>ข้อมูลการเช่า</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="<?= base_url() ?>rent_info"><i class="fa fa-circle-o"></i> การเช่า</a></li>
        </ul>
    </li>
    <li class="<?php echo activate_menu('rental'); ?> treeview">
        <a href="#">
            <i class="fa fa-list-ol"></i> <span>สัญญาเช่า</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="<?= base_url() ?>rental"><i class="fa fa-circle-o"></i> สัญญาเช่า</a></li>
        </ul>
    </li>
    <li class="<?php echo activate_menu('period'); ?> treeview hidden">
        <a href="#">
            <i class="fa fa-list-ol"></i> <span>กำหนดระยะเวลาเช่า</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="<?= base_url() ?>period/edit/1"><i class="fa fa-circle-o"></i> ระยะเวลา</a></li>

        </ul>
    </li>
    <li class="<?php echo activate_menu('pay_limit_date'); ?> treeview">
        <a href="#">
            <i class="fa fa-list-ol"></i> <span>กำหนดช่วงเวลาชำระค่าห้อง</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="<?= base_url() ?>pay_limit_date/edit/1"><i class="fa fa-circle-o"></i> ช่วงเวลา</a></li>

        </ul>
    </li>
    <li class="<?php echo activate_menu('deposit'); ?> treeview">
        <a href="#">
            <i class="fa fa-list-ol"></i> <span>กำหนดค่ามัดจำ</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="<?= base_url() ?>deposit/edit/1"><i class="fa fa-circle-o"></i> ค่ามัดจำ</a></li>

        </ul>
    </li>
    <li class="<?php echo activate_menu('deposit'); ?> treeview">
        <a href="#">
            <i class="fa fa-list-ol"></i> <span>กำหนดค่า Internet</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="<?= base_url() ?>internet/edit/1"><i class="fa fa-circle-o"></i> Internet</a></li>

        </ul>
    </li>

    <li class="<?php echo activate_menu('report'); ?> treeview">
        <a href="#">
            <i class="fa fa-list-ol"></i> <span>รายงาน</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="<?= base_url() ?>report/income"><i class="fa fa-circle-o"></i> รายงานสรุปรายรับประจำเดือน</a></li>
            <li class=""><a href="<?= base_url() ?>report/unpaid"><i class="fa fa-circle-o"></i> รายงานการค้างชำระค่าใช้จ่าย</a></li>
        </ul>
    </li>
    <?php if ($this->session->userdata('group') == 'super admin') { ?>
        <li class="<?php echo activate_menu('administrator'); ?> treeview">
            <a href="#">
                <i class="fa fa-list-ol"></i> <span>เพิ่มผู้ดูแลระบบ</span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li class=""><a href="<?= base_url() ?>administrator"><i class="fa fa-circle-o"></i> เพิ่มผู้ดูแลระบบ</a></li>

            </ul>
        </li>

    <?php } ?>

</ul>