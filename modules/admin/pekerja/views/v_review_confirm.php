<?= $renderer->extend('modules/shared/core/views/layout') ?>

<?= $renderer->section('content') ?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-warning">
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <h4 class="no-margin-top badge">Biodata</h4>
                        </div>
                        <div class="col-xs-3">
                            <img class="img-responsive foto-css center-block" src="<?= site_url('uploads/'.$berkasData['foto']->filename) ?>" alt="Photo">
                        </div>
                        <div class="col-xs-5">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th style="width:50%">NIK</th>
                                            <td><?= $reviewData->nik ?></td>
                                        </tr>
                                        <tr>
                                            <th>Nama Lengkap</th>
                                            <td><?= $reviewData->nama ?></td>
                                        </tr>
                                        <tr>
                                            <th>TTL</th>
                                            <td><?= $reviewData->ttl ?></td>
                                        </tr>
                                        <tr>
                                            <th>Alamat</th>
                                            <td><?= $reviewData->alamat ?></td>
                                        </tr>
                                        <tr>
                                            <th>Domisili</th>
                                            <td><?= $reviewData->domisili ?></td>
                                        </tr>
                                        <tr>
                                            <th>Pekerjaan</th>
                                            <td><?= $reviewData->pekerjaan ?></td>
                                        </tr>
                                        <tr>
                                            <th>Lokasi Kerja</th>
                                            <td><?= $reviewData->lokasi_kerja ?></td>
                                        </tr>
                                        <tr>
                                            <th>Jenis Pekerja</th>
                                            <td><?= $reviewData->jenis_pekerja ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="with-divider"></div>
                    <div class="row">
                        <div class="col-xs-12">
                            <h4 class="no-margin-top badge">Foto KTP</h4>
                            <img class="img-responsive ktp-css" src="<?= site_url('uploads/'.$berkasData['ktp']->filename) ?>" alt="KTP">
                        </div>
                    </div>
                    <div class="with-divider"></div>
                    <div class="row">
                        <div class="col-xs-12">
                            <h4 class="no-margin-top badge">Surat Pernyataan</h4>
                            <img class="img-responsive sp-css" src="<?= site_url('uploads/'.$berkasData['sp']->filename) ?>" alt="SP">
                        </div>
                    </div>
                    <div class="with-divider"></div>
                    <div class="row">
                        <div class="col-xs-12 pull-right">
                            <button class="btn btn-primary btn-sm pull-right" style="margin-left: 8px;"><i class="fa fa-check"></i>&nbsp;Konfirmasi</button>
                            <button class="btn btn-danger btn-sm pull-right"><i class="fa fa-times"></i>&nbsp;Batalkan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $renderer->endSection() ?>

<?= $renderer->section('custom-css') ?>
<style>
    .foto-css {
        width: calc(354px * 0.7);
        height: calc(472px * 0.7);
        object-fit: cover;
    }

    .ktp-css {
        width: 640px;
        height: 320px;
        object-fit: cover;
    }

    .with-divider {
        margin: 16px 0px;
        border-bottom: 1px solid #d2d6de;
        color: #666;
    }
    
    .no-margin-top {
        margin-top: 0px;
    }
</style>
<?= $renderer->endSection() ?>