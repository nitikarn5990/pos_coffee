<ul class="sidebar-menu">
    <li class="header">MAIN NAVIGATION</li>
    <li class="<?php echo activate_menu('home'); ?>"><a href="<?= base_url() ?>home"><i class="fa fa-home"></i> <span>Home</span></a></li>

    <li class="<?php echo activate_menu('pos'); ?>"><a href="<?= base_url() ?>pos"><i class="fa fa-cutlery "></i> <span>การขาย</span></a></li>
    <li class="<?php echo activate_menu('category'); ?>"><a href="<?= base_url() ?>category"><i class="fa fa-folder-open "></i> <span>หมวดหมู่สินค้า</span></a></li>
    <li class="<?php echo activate_menu('menu'); ?>"><a href="<?= base_url() ?>menu"><i class="fa fa-coffee "></i> <span>สินค้า</span></a></li>
    <?php if ($this->session->userdata('group') == 'super admin') { ?>
        <li class="<?php echo activate_menu('report'); ?>"><a href="<?= base_url() ?>report"><i class="fa fa-bar-chart "></i> <span>รายงาน</span></a></li>

        <li class="<?php echo activate_menu('administrator'); ?>"><a href="<?= base_url() ?>administrator"><i class="fa fa-user "></i> <span>เพิ่มพนักงาน</span></a></li>
        <?php } ?>


</ul>