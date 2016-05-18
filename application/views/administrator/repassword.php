 
<section class="content-header">
    <h1>
        <i class="fa fa-key"></i> แก้ไขรหัสผ่าน
    </h1>
    <ol class="breadcrumb hidden">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!--Alert -->
            <?php if (validation_errors()) { ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                    <?php echo validation_errors(); ?>
                </div>
            <?php } ?>
            <?php if ($this->session->flashdata('message_success')) { ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('message_success') ?>
                </div>
            <?php } ?>
            <?php if ($this->session->flashdata('message_error')) { ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('message_error') ?>
                </div>
            <?php } ?>
        </div>
        <!--End Alert -->
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">ข้อมูล</h3>
                </div>
                <form class="form-horizontal" action="<?= base_url('administrator/repassword') ?>" method="POST">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">รหัสผ่านเดิม</label>
                            <div class="col-sm-10">
                                <input type="password" value="" class="form-control"  name="old_password" data-validation="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">รหัสผ่านใหม่</label>
                            <div class="col-sm-10">
                                <input type="password" value="" class="form-control"  name="new_password" id="new_password" data-validation="required" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">ยืนยันรหัสผ่านใหม่</label>
                            <div class="col-sm-10">
                                <input type="password" value="" class="form-control"  name="new_password_confirm" id="new_password_confirm" data-validation="required,chk" >
                            </div>
                        </div>
                       
                    </div>
                    <div class="box-footer">
                        <button type="submit" name="btn_submit" value="บันทึกและแก้ไขต่อ" class="btn btn-instagram pull-right margin-r-5">บันทึกและแก้ไขต่อ</button>
                      
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>

<!-- Validate -->
<script src="<?= base_url() ?>assets/plugins/validate/jquery.form-validator.min.js"></script>

<script>
    $.formUtils.addValidator({
  name : 'chk',
  validatorFunction : function(value, $el, config, language, $form) {
      var new_password = $('#new_password').val();
      if(value === new_password){
          return true;
      }else{
          return false;
      }
 
  },
  errorMessage : 'ยืนยันรหัสผ่านใหม่ให้ตรงกัน',
  errorMessageKey: 'badEvenNumber'
});
</script>
<script> $.validate();</script>
<script>
    function showDialog(uri) {

        var sList = PopupCenter(uri, '', "900", "400");

    }

    function PopupCenter(url, title, w, h) {
        // Fixes dual-screen position Most browsers      Firefox
        var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
        var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

        width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

        var left = ((width / 2) - (w / 2)) + dualScreenLeft;
        var top = ((height / 2) - (h / 2)) + dualScreenTop;
        var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

        // Puts focus on the newWindow
        if (window.focus) {
            newWindow.focus();
        }
    }
</script>

<script src="<?= base_url() ?>assets/plugins/switch/js/on-off-switch.js"></script>
<script src="<?= base_url() ?>assets/plugins/switch/js/on-off-switch-onload.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/switch/css/on-off-switch.css">
<script>

    new DG.OnOffSwitch({
        el: '#on-off-switch',
        textOn: 'เปิดสัญญา',
        textOff: 'ปิดสัญญา',
        listener: function (name, checked) {

        }
    });
</script>