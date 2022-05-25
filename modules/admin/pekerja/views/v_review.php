<?= $renderer->extend('modules/shared/core/views/layout') ?>

<?= $renderer->section('content') ?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-warning">
                <div class="box-header">
                    <h3 class="box-title">List Data Review Pekerja</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th width="3%">ID</th>
                                <th width="10%">NIK</th>
                                <th width="15%">Nama</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>201203310221223481</td>
                                <td>Pekerja 1</td>
                                <td><span class="label label-warning">Tertunda</span></td>
                                <td>2022-05-22 11:00:12</td>
                                <td>
                                    <button class="btn btn-success btn-xs"><i class="fa fa-check"></i>&nbsp;Konfirmasi</button>
                                    <button class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i>&nbsp;Detail</button>
                                    <button class="btn btn-warning btn-xs"><i class="fa fa-times"></i>&nbsp;Abaikan</button>
                                    <button class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>&nbsp;Hapus</button>
                                </td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>201203310221223481</td>
                                <td>Pekerja 1</td>
                                <td><span class="label label-warning">Tertunda</span></td>
                                <td>2022-05-22 11:00:12</td>
                                <td>
                                    <button class="btn btn-success btn-xs"><i class="fa fa-check"></i>&nbsp;Konfirmasi</button>
                                    <button class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i>&nbsp;Detail</button>
                                    <button class="btn btn-warning btn-xs"><i class="fa fa-times"></i>&nbsp;Abaikan</button>
                                    <button class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>&nbsp;Hapus</button>
                                </td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>201203310221223481</td>
                                <td>Pekerja 1</td>
                                <td><span class="label label-danger">Diabaikan</span></td>
                                <td>2022-05-22 11:00:12</td>
                                <td>
                                    <!-- <button class="btn btn-success btn-xs"><i class="fa fa-check"></i>&nbsp;Konfirmasi</button> -->
                                    <button class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i>&nbsp;Detail</button>
                                    <!-- <button class="btn btn-warning btn-xs"><i class="fa fa-times"></i>&nbsp;Abaikan</button> -->
                                    <button class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>&nbsp;Hapus</button>
                                </td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>201203310221223481</td>
                                <td>Pekerja 1</td>
                                <td><span class="label label-warning">Tertunda</span></td>
                                <td>2022-05-22 11:00:12</td>
                                <td>
                                    <button class="btn btn-success btn-xs"><i class="fa fa-check"></i>&nbsp;Konfirmasi</button>
                                    <button class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i>&nbsp;Detail</button>
                                    <button class="btn btn-warning btn-xs"><i class="fa fa-times"></i>&nbsp;Abaikan</button>
                                    <button class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>&nbsp;Hapus</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<?= $renderer->endSection() ?>

<?= $renderer->section('custom-js') ?>

<?= $renderer->endSection() ?>