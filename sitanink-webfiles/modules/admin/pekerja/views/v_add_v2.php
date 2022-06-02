<?= $renderer->extend('modules/shared/core/views/layout') ?>

<?php
$fdErr = session()->getFlashdata('error');
$errIcon = '<i class="fa fa-times-circle-o"></i>';
?>

<?= $renderer->section('content') ?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Form Tambah Pekerja</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-offset-3 col-xs-6">
                            <form id="form-add-pekerja" action="<?= route_to('pekerja.create-v2') ?>" method="POST" role="form" enctype="multipart/form-data">
                                <?= csrf_field() ?>
                                <div class="row">
                                    <div class="col-xs-4">
                                        <div class="form-group <?= isset($fdErr['nik']) ? 'has-error' : '' ?>">
                                            <label class="control-label"><?= isset($fdErr['nik']) ? $errIcon : '' ?>&nbsp;NIK (<span style="color: #dd4b39;">*</span>)</label>
                                            <input type="text" name="nik" class="form-control" placeholder="Masukkan nik ..." value="<?= old('nik') ?? '' ?>">
                                            <?php if (isset($fdErr['nik'])) : ?>
                                                <span class="help-block"><?= $fdErr['nik'] ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group <?= isset($fdErr['nama']) ? 'has-error' : '' ?>">
                                            <label class="control-label"><?= isset($fdErr['nama']) ? $errIcon : '' ?>&nbsp;Nama Lengkap (<span style="color: #dd4b39;">*</span>)</label>
                                            <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap ..." value="<?= old('nama') ?? '' ?>">
                                            <?php if (isset($fdErr['nama'])) : ?>
                                                <span class="help-block"><?= $fdErr['nama'] ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group <?= isset($fdErr['tempat_lahir']) || isset($fdErr['tgl_lahir']) ? 'has-error' : '' ?>">
                                    <label class="control-label"><?= isset($fdErr['tempat_lahir']) || isset($fdErr['tgl_lahir']) ? $errIcon : '' ?>&nbsp;TTL (<span style="color: #dd4b39;">*</span>)</label>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input type="text" name="tempat_lahir" class="form-control" placeholder="Masukkan tempat lahir ..." value="<?= old('tempat_lahir') ?? '' ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" name="tgl_lahir" class="form-control pull-right" id="datepicker" placeholder="Masukkan tanggal lahir ..." value="<?= old('tgl_lahir') ?? '' ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <?php if (isset($fdErr['tempat_lahir'])) : ?>
                                        <span class="help-block"><?= $fdErr['tempat_lahir'] ?></span>
                                    <?php endif; ?>
                                    <?php if (isset($fdErr['tgl_lahir'])) : ?>
                                        <span class="help-block"><?= $fdErr['tgl_lahir'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group <?= isset($fdErr['alamat']) ? 'has-error' : '' ?>">
                                    <label class="control-label"><?= isset($fdErr['alamat']) ? $errIcon : '' ?>&nbsp;</i>Alamat (<span style="color: #dd4b39;">*</span>)</label>
                                    <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat lengkap ..."><?= old('alamat') ?? '' ?></textarea>
                                    <?php if (isset($fdErr['alamat'])) : ?>
                                        <span class="help-block"><?= $fdErr['alamat'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group <?= isset($fdErr['id_domisili']) ? 'has-error' : '' ?>"">
                                    <label class=" control-label"><?= isset($fdErr['id_domisili']) ? $errIcon : '' ?>&nbsp;Domisili (<span style="color: #dd4b39;">*</span>)</label>
                                    <select name="id_domisili" class="form-control">
                                        <option value="">-- Pilih salah satu --</option>
                                        <?php $oldDomisili = old('id_domisili'); ?>
                                        <?php foreach ($ddData['domisili'] as $domisiliItem) : ?>
                                            <option value="<?= $domisiliItem->value ?>" <?= isset($oldDomisili) ? ($oldDomisili == $domisiliItem->value ? 'selected' : '') : '' ?>><?= $domisiliItem->text ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if (isset($fdErr['id_domisili'])) : ?>
                                        <span class="help-block"><?= $fdErr['id_domisili'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group <?= isset($fdErr['id_lokasi_kerja']) ? 'has-error' : '' ?>"">
                                    <label class=" control-label"><?= isset($fdErr['id_lokasi_kerja']) ? $errIcon : '' ?>&nbsp;Lokasi Kerja (<span style="color: #dd4b39;">*</span>)</label>
                                    <select name="id_lokasi_kerja" class="form-control">
                                        <option value="">-- Pilih salah satu --</option>
                                        <?php $oldLokasikerja = old('id_lokasi_kerja'); ?>
                                        <?php foreach ($ddData['lokasi_kerja'] as $lokasikerjaItem) : ?>
                                            <option value="<?= $lokasikerjaItem->value ?>" <?= isset($oldLokasikerja) ? ($oldLokasikerja == $lokasikerjaItem->value ? 'selected' : '') : '' ?>><?= $lokasikerjaItem->text ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if (isset($fdErr['id_lokasi_kerja'])) : ?>
                                        <span class="help-block"><?= $fdErr['id_lokasi_kerja'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group <?= isset($fdErr['id_pekerjaan']) ? 'has-error' : '' ?>"">
                                    <label class=" control-label"><?= isset($fdErr['pekerjaan']) ? $errIcon : '' ?>&nbsp;Pekerjaan (<span style="color: #dd4b39;">*</span>)</label>
                                    <select name="id_pekerjaan" class="form-control">
                                        <option value="">-- Pilih salah satu --</option>
                                        <?php $oldPekerjaan = old('id_pekerjaan'); ?>
                                        <?php foreach ($ddData['pekerjaan'] as $pekerjaanItem) : ?>
                                            <option value="<?= $pekerjaanItem->value ?>" <?= isset($oldPekerjaan) ? ($oldPekerjaan == $pekerjaanItem->value ? 'selected' : '') : '' ?>><?= $pekerjaanItem->text ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if (isset($fdErr['id_pekerjaan'])) : ?>
                                        <span class="help-block"><?= $fdErr['id_pekerjaan'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group <?= isset($fdErr['id_jenis_pekerja']) ? 'has-error' : '' ?>"">
                                    <label class=" control-label"><?= isset($fdErr['jenis_pekerja']) ? $errIcon : '' ?>&nbsp;Jenis Pekerja (<span style="color: #dd4b39;">*</span>)</label>
                                    <select name="id_jenis_pekerja" class="form-control">
                                        <option value="">-- Pilih salah satu --</option>
                                        <?php $oldJenisPekerja = old('id_jenis_pekerja'); ?>
                                        <?php foreach ($ddData['jenis_pekerja'] as $jenisPekerjaItem) : ?>
                                            <option value="<?= $jenisPekerjaItem->value ?>" <?= isset($oldJenisPekerja) ? ($oldJenisPekerja == $jenisPekerjaItem->value ? 'selected' : '') : '' ?>><?= $jenisPekerjaItem->text ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if (isset($fdErr['id_jenis_pekerja'])) : ?>
                                        <span class="help-block"><?= $fdErr['id_jenis_pekerja'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group <?= isset($fdErr['foto']) ? 'has-error' : '' ?>"">
                            <label for=" foto"><?= isset($fdErr['foto']) ? $errIcon : '' ?>&nbsp;Foto (<span style="color: #dd4b39;">*</span>)</label>
                                    <input type="file" name="foto">
                                    <p><strong>500 KB</strong></p>
                                    <?php if (isset($fdErr['foto'])) : ?>
                                        <span class="help-block"><?= $fdErr['foto'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group <?= isset($fdErr['ktp']) ? 'has-error' : '' ?>"">
                            <label for=" ktp"><?= isset($fdErr['ktp']) ? $errIcon : '' ?>&nbsp;KTP</label>
                                    <input type="file" name="ktp">
                                    <p>Max. <strong>1 MB</strong></p>
                                    <?php if (isset($fdErr['ktp'])) : ?>
                                        <span class="help-block"><?= $fdErr['ktp'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group <?= isset($fdErr['sp']) ? 'has-error' : '' ?>"">
                            <label for=" foto"><?= isset($fdErr['sp']) ? $errIcon : '' ?>&nbsp;Kartu Keluarga</label>
                                    <input type="file" name="sp">
                                    <p class="help-block">Max. <strong>1 MB</strong></p>
                                    <?php if (isset($fdErr['sp'])) : ?>
                                        <span class="help-block"><?= $fdErr['sp'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group <?= isset($fdErr['sp']) ? 'has-error' : '' ?>"">
                            <label for=" foto"><?= isset($fdErr['sp']) ? $errIcon : '' ?>&nbsp;Surat Permohohan Ijin Usaha</label>
                                    <input type="file" name="sp">
                                    <p class="help-block">Max. <strong>1 MB</strong></p>
                                    <?php if (isset($fdErr['sp'])) : ?>
                                        <span class="help-block"><?= $fdErr['sp'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group <?= isset($fdErr['sp']) ? 'has-error' : '' ?>"">
                            <label for=" foto"><?= isset($fdErr['sp']) ? $errIcon : '' ?>&nbsp;Surat Pernyataan</label>
                                    <input type="file" name="sp">
                                    <p class="help-block">Max. <strong>1 MB</strong></p>
                                    <?php if (isset($fdErr['sp'])) : ?>
                                        <span class="help-block"><?= $fdErr['sp'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $renderer->endSection() ?>

<?= $renderer->section('custom-css') ?>
<link rel="stylesheet" href="<?= site_url('adminlte2/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') ?>">
<?= $renderer->endSection() ?>

<?= $renderer->section('custom-js') ?>
<script src="<?= site_url('adminlte2/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') ?>"></script>
<script src="<?= site_url('adminlte2/plugins/input-mask/jquery.inputmask.js') ?>"></script>
<script>
    $(function() {
        $('#datepicker').datepicker({
            autoclose: true
        });

        $('#form-add-pekerja input[name="nik"]').inputmask('9999-9999-9999-9999');
    });
</script>
<?= $renderer->endSection() ?>