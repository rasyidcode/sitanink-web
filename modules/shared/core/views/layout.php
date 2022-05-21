<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sitanink Admin - <?= $pageTitle ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?= site_url('adminlte2/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= site_url('adminlte2/bower_components/font-awesome/css/font-awesome.min.css') ?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?= site_url('adminlte2/bower_components/Ionicons/css/ionicons.min.css') ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= site_url('adminlte2/dist/css/AdminLTE.min.css') ?>">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect. -->
    <link rel="stylesheet" href="<?= site_url('adminlte2/dist/css/skins/skin-yellow.min.css') ?>">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <?= $renderer->renderSection('custom-css') ?>
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->

<body class="hold-transition skin-yellow sidebar-mini">
    <div class="wrapper">

        <!-- Main Header -->
        <?= $renderer->include('modules/shared/core/views/header') ?>


        <!-- Left side column. contains the logo and sidebar -->
        <?= $renderer->include('modules/shared/core/views/sidebar') ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    <?= $pageTitle ?>
                    <small><?= $pageDesc ?></small>
                </h1>
                <ol class="breadcrumb">
                    <?php foreach ($pageLinks as $pageKey => $pageVal) : ?>
                        <?php
                        $pagesKey = explode('-', $pageKey);
                        $pageKey = count($pagesKey) > 1 ? implode(' ', $pagesKey) : $pageKey;
                        ?>
                        <?php if ($pageVal['active']) : ?>
                            <li class="active"><?= ucwords($pageKey) ?></li>
                        <?php else : ?>
                            <li><a href="<?= $pageVal['url'] ?>"><?= ucwords($pageKey) ?></a></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <!-- <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li> -->
                </ol>
            </section>

            <!-- Main content -->
            <?= $renderer->renderSection('content') ?>

            <!-- <section class="content container-fluid"> -->

            <!--------------------------
                | Your Page Content Here |
                -------------------------->


            <!-- </section> -->
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <?= $renderer->include('modules/shared/core/views/footer') ?>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 3 -->
    <script src="<?= site_url('adminlte2/bower_components/jquery/dist/jquery.min.js') ?>"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="<?= site_url('adminlte2/bower_components/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?= site_url('adminlte2/dist/js/adminlte.min.js') ?>"></script>

    <!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
    <!-- jQuery Slimscroll 1.3.8 -->
    <script src="<?= site_url('adminlte2/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') ?>"></script>
    <!-- fastclick -->
    <script src="<?= site_url('adminlte2/bower_components/fastclick/lib/fastclick.js') ?>"></script>
    <script>
        $(function() {
            $('.footer-year').text(new Date().getFullYear());


            $('#logout-btn').click(function(e) {
                e.preventDefault();

                $.ajax({
                    url: '<?= route_to('admin.logout') ?>',
                    type: 'post',
                    data: {
                        ['<?= csrf_token() ?>']: '<?= csrf_hash() ?>'
                    },
                    success: function(res) {
                        console.log(res);
                        location.reload();
                    },
                    error: function(err) {
                        console.log(err);
                    }
                })
            });
        });
    </script>
    <?= $renderer->renderSection('custom-js') ?>
</body>

</html>