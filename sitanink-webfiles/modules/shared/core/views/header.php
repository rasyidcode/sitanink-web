<header class="main-header">

    <!-- Logo -->
    <a href="<?= route_to('admin') ?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">
            <img class="circular-image" src="<?= site_url('assets/logo-small2.png') ?>" alt="">
        </span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">
            <img class="circular-image" src="<?= site_url('assets/logo2.png') ?>" alt="">
            Sitanink Admin
        </span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Notifications Menu -->
                <li class="dropdown notifications-menu">
                    <!-- Menu toggle button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-danger"><?= count($notifs) ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">Anda punya <?= count($notifs) ?> notifikasi!</li>
                        <li>
                            <!-- Inner Menu: contains the notifications -->
                            <ul class="menu">
                                <?php foreach ($notifs as $notif) : ?>
                                    <li>
                                        <!-- start notification -->
                                        <a href="#">
                                            <?php if ($notif->type === 'info') : ?>
                                                <i class="fa fa-info text-blue"></i> <?= $notif->message ?>
                                            <?php else : ?>
                                                <i class="fa fa-bell-o text-warning"></i> <?= $notif->message ?>
                                            <?php endif; ?>
                                        </a>
                                    </li>
                                <?php endforeach ?>
                                <!-- end notification -->
                            </ul>
                        </li>
                        <li class="footer"><a href="<?= route_to('notifikasi') ?>">Lihat Semua</a></li>
                    </ul>
                </li>
                <li>
                    <a id="logout-btn" href="javascript:void(0)"><i class="fa fa-sign-out"></i>&nbsp;Keluar</a>
                </li>
            </ul>
        </div>
    </nav>
</header>