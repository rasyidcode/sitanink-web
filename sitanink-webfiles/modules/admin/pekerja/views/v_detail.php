<?= $renderer->extend('modules/shared/core/views/layout') ?>

<?= $renderer->section('content') ?>
<section class="content">
    <div class="row">
        <div class="col-xs-8">
            <div class="box box-warning">
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <h3 style="margin-top: 0">Data Personal</h3>
                            <div class="row">
                                <div class="col-xs-2">
                                    <?php if (!is_null($dataBerkas['foto'])) : ?>
                                        <img class="foto-css" src="<?= site_url('uploads/' . $dataBerkas['foto']->filename) ?>" alt="Photo">
                                    <?php else : ?>
                                        <div class="foto-css add-border">
                                            <p class="text-left text-danger">Berkas Foto tidak ada!</p>
                                        </div>
                                    <?php endif ?>
                                </div>
                                <div class="col-xs-10">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <th>NIK</th>
                                                    <td><?= $dataPekerja->nik ?? '' ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Nama</th>
                                                    <td><?= $dataPekerja->nama ?? '' ?></td>
                                                </tr>
                                                <tr>
                                                    <th>TTL</th>
                                                    <td><?= $dataPekerja->ttl ?? '' ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Alamat</th>
                                                    <td><?= $dataPekerja->alamat ?? '' ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Domisili</th>
                                                    <td><?= $dataPekerja->domisili ?? '' ?></td>
                                                </tr>
                                                <tr>
                                                    <th>KTP</th>
                                                    <td>
                                                        <?php if (!is_null($dataBerkas['ktp'])) : ?>
                                                            <img class="ktp-css" src="<?= site_url('uploads/' . $dataBerkas['ktp']->filename) ?>" alt="KTP">
                                                        <?php else : ?>
                                                            <div class="ktp-css add-border">
                                                                <p class="text-left text-danger">Berkas KTP tidak ada!</p>
                                                            </div>
                                                        <?php endif ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="col-xs-4">
                            <h3 style="margin-top: 0">Data Pekerjaan</h3>

                            <div class="table-responsive">
                                <table style="margin-bottom: 0;" class="table">
                                    <tbody>
                                        <tr>
                                            <th>Pekerjaan</th>
                                            <td><?= $dataPekerja->pekerjaan ?? '' ?></td>
                                        </tr>
                                        <tr>
                                            <th>Lokasi Kerja</th>
                                            <td><?= $dataPekerja->lokasi_kerja ?? '' ?></td>
                                        </tr>
                                        <tr>
                                            <th>Jenis Pekerja</th>
                                            <td><?= $dataPekerja->jenis_pekerja ?? '' ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th width="15%">Surat Perijinan</th>
                                            <td>
                                                <?php if (!is_null($dataBerkas['sp'])) : ?>
                                                    <img class="sp-css" src="<?= site_url('uploads/' . $dataBerkas['sp']->filename) ?>" alt="KTP">
                                                <?php else : ?>
                                                    <div class="sp-css add-border">
                                                        <p class="text-left text-danger">Berkas Surat Perijinan tidak ada!</p>
                                                    </div>
                                                <?php endif ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $renderer->endSection() ?>

<?= $renderer->section('custom-js') ?>
<script>
    $(function() {

    });
</script>
<?= $renderer->endSection() ?>

<?= $renderer->section('custom-css') ?>
<style>
    .foto-css {
        width: calc(354px * 0.5);
        height: calc(472px * 0.5);
        object-fit: cover;
    }

    .ktp-css {
        width: calc(640px * 0.8);
        height: calc(320px * 0.8);
        object-fit: cover;
    }

    .sp-css {
        width: 80%;
        height: 80%;
        object-fit: cover;
    }

    .add-border {
        border: 1px solid #aaa;
    }
</style>
<?= $renderer->endSection() ?>