<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Home
    </h1>
    <ol class="breadcrumb hidden">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
         <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3><?=$this->db->get_where('category', array('status' => 'ใช้งาน'))->num_rows();?></h3>
                    <p>หมวดสินค้า</p>
                </div>
                <div class="icon">
                    <i class="fa fa-folder-open"></i>
                </div>
                <a href="<?=  base_url()?>category" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-teal">
                <div class="inner">
                    <h3><?=$this->db->get_where('menu', array('status' => 'ใช้งาน'))->num_rows();?></h3>
                    <p>จำนวนสินค้า</p>
                </div>
                <div class="icon">
                    <i class="fa fa-coffee"></i>
                </div>
                <a href="<?=  base_url()?>menu" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
    
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                     <h3><?=$this->db->get_where('users', array('status' => 'ใช้งาน', 'group' => 'admin'))->num_rows();?></h3>
                    <p>จำนวนพนักงาน</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="<?=  base_url()?>administrator" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3><?=$this->db->get_where('seat', array('id' => 1))->row_array()['seat_number'];?></h3>
                    <p>จำนวนโต๊ะ</p>
                </div>
                <div class="icon">
                    <i class="fa fa-table"></i>
                </div>
                <a href="<?=  base_url()?>seat/edit" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
    </div>
</section><!-- /.content -->



<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatable2/semantic.min.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatable2/dataTables.semanticui.min.css">

<script src="<?= base_url() ?>assets/plugins/datatable2/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatable2/dataTables.semanticui.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatable2/semantic.min.js"></script>



<script>
    $(document).ready(function () {
        $('#example').DataTable();

        $("#chkboxall").click(function (e) {
            $('.chkbox').prop('checked', this.checked);
        });

    });

</script>