<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <div style="width: 50px; height: 50px; background-color: gray;" class="img-circle text-center">
                    <h1 style="color: white; margin: 0;"><?= session()->get('username')[0] ?></h1>
                </div>
            </div>
            <div class="pull-left info">
                <p><?= session()->get('username') ?></p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-warning"></i> <?= session()->get('level') ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Dashboard</li>
            <li class="<?= isLinkActive('dashboard') ?>">
                <a href="<?= route_to('admin') ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
            </li>
            <?php if (session()->get('level') === 'admin'): ?>
                <li class="header">Master</li>
                <li class="<?= isLinkActive('user', 1) ?>">
                    <a href="<?= route_to('user') ?>"><i class="fa fa-user"></i> <span>Data User</span></a>
                </li>
                <li class="<?= isLinkActive('lokasi-kerja', 1) ?>">
                    <a href="<?= route_to('lokasi-kerja') ?>"><i class="ion ion-location"></i> <span>Data Lokasi Kerja</span></a>
                </li>
                <li class="<?= isLinkActive('jenis-pekerja', 1) ?>">
                    <a href="<?= route_to('jenis-pekerja') ?>"><i class="fa fa-square-o"></i> <span>Data Jenis Pekerja</span></a>
                </li>
                <li class="<?= isLinkActive('tipe-berkas', 1) ?>">
                    <a href="<?= route_to('tipe-berkas') ?>"><i class="fa fa-file"></i> <span>Data Tipe Berkas</span></a>
                </li>
                <!--/ master end -->
            <?php endif; ?>

            <li class="header">Data</li>
            <li class="<?= isLinkActive('pekerja', 1) ?>">
                <a href="<?= route_to('pekerja') ?>">
                    <i class="fa fa-user-o"></i> <span>Data Pekerja</span>
                </a>
            </li>
            <li class="<?= isLinkActive('wilayah', 1) ?>">
                <a href="<?= route_to('wilayah') ?>">
                    <i class="ion ion-map"></i> <span>Data Per Wilayah</span>
                </a>
            </li>
            <?php if (session()->get('level') === 'admin'): ?>
                <li class="<?= isLinkActive('qrcode', 1) ?>">
                    <a href="<?= route_to('qrcode') ?>">
                        <i class="fa fa-qrcode"></i> <span>Data QRCode</span>
                    </a>
                </li>
            <?php endif ?>
            <li class="<?= isLinkActive('kartu2', 1) ?>">
                <a href="<?= route_to('kartu') ?>">
                    <i class="fa fa-vcard-o"></i> <span>Data Kartu</span>
                </a>
            </li>
            <li class="<?= isLinkActive('sk', 1) ?>">
                <a href="<?= route_to('sk') ?>">
                    <i class="ion ion-document-text"></i> <span>Data SK</span>
                </a>
            </li>
            <!--/ data end -->
            
            <?php if (session()->get('level') === 'admin'): ?>
                <li class="header">Lainnya</li>
                <li>
                    <a href="#"><i class="ion ion-android-notifications-none"></i> <span>Notifikasi</span></a>
                </li>
                <li class="<?= isLinkActive('setting', 1) ?>">
                    <a href="<?= route_to('setting') ?>"><i class="ion ion-gear-a"></i> <span>Pengaturan</span></a>
                </li>
                <li class="<?= isLinkActive('dokumentasi', 1) ?>">
                    <a href="<?= route_to('dokumentasi') ?>"><i class="fa fa-book"></i> <span>Dokumentasi</span></a>
                </li>
            <?php endif ?>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>