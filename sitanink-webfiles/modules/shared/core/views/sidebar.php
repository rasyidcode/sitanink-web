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
            <li class="header">Master</li>
            <li class="<?= isLinkActive('user', 1) ?>">
                <a href="<?= route_to('user') ?>"><i class="fa fa-user"></i> <span>Master Data User</span></a>
            </li>
            <li class="treeview" style="height: auto;">
                <a href="#">
                    <i class="ion ion-ios-people-outline"></i> <span>Master Data Pekerja</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu" style="display: <?= isMenuOpen('master', 1) ?>;">
                    <li class="<?= isLinkActive('lokasi-kerja', 2) ?>"><a href="<?= route_to('lokasi-kerja') ?>"><i class="ion ion-location"></i> Lokasi</a></li>
                    <li class="<?= isLinkActive('jenis-pekerja', 2) ?>"><a href="<?= route_to('jenis-pekerja') ?>"><i class="fa fa-square-o"></i> Jenis</a></li>
                    <!-- <li class="<?= isLinkActive('pekerjaan', 2) ?>"><a href="<?= route_to('pekerjaan') ?>"><i class="fa fa-gavel"></i> Pekerjaan</a></li> -->
                    <!-- <li class="<?= isLinkActive('tipe-berkas', 2) ?>"><a href="<?= route_to('tipe-berkas') ?>"><i class="fa fa-file"></i> Tipe Berkas</a></li> -->
                </ul>
            </li>
            <li class="<?= isLinkActive('tipe-berkas', 1) ?>">
                <a href="<?= route_to('tipe-berkas') ?>"><i class="fa fa-file"></i> <span>Master Data Tipe Berkas</span></a>
            </li>
            <li class="header">Data</li>
            <li class="<?= isLinkActive('pekerja', 1) ?>">
                <a href="<?= route_to('pekerja') ?>">
                    <i class="fa fa-user-o"></i> <span>Data Pekerja</span>
                </a>
            </li>
            <li class="<?= isLinkActive('wilayah', 1) ?>">
                <a href="<?=route_to('wilayah')?>">
                    <i class="ion ion-map"></i> <span>Data Per Wilayah</span>
                </a>
            </li>
            <li class="<?= isLinkActive('qrcode', 1) ?>">
                <a href="<?=route_to('qrcode')?>">
                    <i class="fa fa-qrcode"></i> <span>Data QRCode</span>
                </a>
            </li>
            <li class="treeview" style="height: auto;">
                <a href="#">
                    <i class="fa fa-vcard-o"></i> <span>Data Kartu</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu" style="display: <?= isMenuOpen('kartu2', 1) ?>;">
                    <li class="<?= isLinkActive('list', 2) ?>"><a href="<?= route_to('kartu') ?>"><i class="fa fa-square-o"></i> List</a></li>
                    <li class="<?= isLinkActive('generate', 2) ?>"><a href="<?= route_to('kartu.generate') ?>"><i class="fa fa-square-o"></i> Generate</a></li>
                </ul>
            </li>
            <li class="<?= isLinkActive('sk', 1) ?>">
                <a href="<?=route_to('sk')?>">
                    <i class="ion ion-document-text"></i> <span>Data SK</span>
                </a>
            </li>
            <li class="header">Lainnya</li>
            <li>
                <a href="#"><i class="ion ion-android-notifications-none"></i> <span>Notifikasi</span></a>
            </li>
            <li <?= isLinkActive('setting', 1) ?>>
                <a href="<?=route_to('setting')?>"><i class="ion ion-gear-a"></i> <span>Pengaturan</span></a>
            </li>
            <!-- <li class="header">Tools</li>
            <li>
                <a href="#"><i class="ion ion-ios-reverse-camera-outline"></i> <span>QR Scanner</span></a>
            </li> -->
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>