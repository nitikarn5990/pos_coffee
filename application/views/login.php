
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>ระบบจัดการร้านกาแฟ</title>
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
        <!-- iCheck -->
        <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/iCheck/square/blue.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="text-center">
                <i class="fa fa-coffee fa-4x"></i> 
            </div>
            <div class="login-logo" style="font-weight: lighter;">
                ระบบจัดการร้านกาแฟ
            </div><!-- /.login-logo -->
            <div class="login-box-body">
                <!--Alert -->
                <?php if (validation_errors()) { ?>
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                   
                        <?php echo validation_errors(); ?>
                    </div>
                <?php } ?>
                <?php if (($this->session->flashdata('message'))) { ?>
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?php echo $this->session->flashdata('message') ?>
                    </div>

                <?php } ?>

                <!--End Alert -->
                <p class="login-box-msg" style="font-size: 18px;"><i class="fa fa-key "></i> Login</p>
                <form action="<?= base_url() ?>auth/login" method="post">
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" name="username" value="<?php echo set_value('username'); ?>" placeholder="Username">
                        <span class="form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" name="password" value="" placeholder="Password">
                        <span class="form-control-feedback"></span>
                    </div>
                    <div class="row">

                        <div class="col-xs-12">
                            <button type="submit" class="btn bg-purple btn-block btn-flat">เข้าสู่ระบบ&nbsp;<i class="fa fa-arrow-circle-right"></i></button>
                        </div><!-- /.col -->
                    </div>
                </form>

            </div><!-- /.login-box-body -->
        </div><!-- /.login-box -->

        <!-- jQuery 2.1.4 -->
        <script src="<?= base_url() ?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <!-- Bootstrap 3.3.5 -->
        <script src="<?= base_url() ?>assets/bootstrap/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="<?= base_url() ?>assets/plugins/iCheck/icheck.min.js"></script>
        <script>
            $(function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });
            });
        </script>
    </body>
</html>
