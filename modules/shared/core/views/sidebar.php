<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <div style="width: 50px; height: 50px; background-color: gray;" class="img-circle text-center">
                    <h1 style="color: white; margin: 0;"><?=session()->get('username')[0]?></h1>
                </div>
            </div>
            <div class="pull-left info">
                <p><?=session()->get('username')?></p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-warning"></i> <?=session()->get('level')?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">Master</li>
            <li class="<?=isLinkActive('user', 1)?>">
                <a href="<?=route_to('user')?>"><i class="fa fa-user"></i> <span>Data User</span></a>
            </li>
            <li class="header">Data</li>
            <!-- <li class="header">Master Data</li> -->
            <li>
                <a href="#"><i class="fa fa-users"></i> <span>Data Pekerja</span></a>
            </li>
            <li><a href="#">
                <i class="fa fa-map-marker"></i> <span>Data Per Wilayah</span>
            </a></li>
            <li class="header">Input Data</li>
            <li>
                <a href="#"><i class="fa fa-pencil"></i> <span>Input Data Pekerja</span></a>
            </li>
            <li class="header">Lainnya</li>
            <li>
                <a href="#"><i class="ion ion-android-notifications-none"></i> <span>Notifikasi</span></a>
            </li>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>