<?= $renderer->extend('modules/shared/core/views/layout') ?>

<?php
$fdErr = session()->getFlashdata('error');
$errIcon = '<i class="fa fa-times-circle-o"></i>';
?>

<?= $renderer->section('content') ?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-warning">
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-offset-3 col-xs-6">
                            <form id="form-add-pekerja" action="<?= route_to('pekerja.create') ?>" method="POST" role="form" enctype="multipart/form-data">
                                <?= csrf_field() ?>
                                <div class="row">
                                    <div class="col-xs-4">
                                        <div class="form-group <?= isset($fdErr['nik']) ? 'has-error' : '' ?>">
                                            <label class="control-label"><?= isset($fdErr['nik']) ? $errIcon : '' ?>&nbsp;NIK</label>
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
                                            <label class="control-label"><?= isset($fdErr['nama']) ? $errIcon : '' ?>&nbsp;Nama Lengkap</label>
                                            <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap ..." value="<?= old('nama') ?? '' ?>">
                                            <?php if (isset($fdErr['nama'])) : ?>
                                                <span class="help-block"><?= $fdErr['nama'] ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group <?= isset($fdErr['tempat_lahir']) || isset($fdErr['tgl_lahir']) ? 'has-error' : '' ?>">
                                    <label class="control-label"><?= isset($fdErr['tempat_lahir']) || isset($fdErr['tgl_lahir']) ? $errIcon : '' ?>&nbsp;TTL</label>
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
                                    <label class="control-label"><?= isset($fdErr['alamat']) ? $errIcon : '' ?>&nbsp;</i>Alamat</label>
                                    <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat lengkap ..."><?= old('alamat') ?? '' ?></textarea>
                                    <?php if (isset($fdErr['alamat'])) : ?>
                                        <span class="help-block"><?= $fdErr['alamat'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group <?= isset($fdErr['domisili']) ? 'has-error' : '' ?>"">
                            <label class=" control-label"><?= isset($fdErr['domisili']) ? $errIcon : '' ?>&nbsp;Domisili</label>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <select name="domisili" class="form-control">
                                                <option value="">-- Pilih salah satu --</option>
                                                <?php $oldDomisili = old('domisili'); ?>
                                                <?php $oldDomisili2 = old('domisili2'); ?>
                                                <?php foreach ($listDomisili as $domisiliItem) : ?>
                                                    <option value="<?= $domisiliItem->value ?>" <?= isset($oldDomisili) ? ($oldDomisili == $domisiliItem->value ? 'selected' : '') : '' ?>><?= $domisiliItem->text ?></option>
                                                <?php endforeach; ?>
                                                <option <?= isset($oldDomisili2) ? ($oldDomisili == 'lainnya' ? 'selected' : '') : '' ?> value="lainnya">Lainnya</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-6">
                                            <input style="visibility: <?= isset($oldDomisili2) && !empty($oldDomisili2) ? 'visible' : 'hidden' ?>;" type="text" name="domisili2" class="form-control" placeholder="Masukkan domisili ..." value="<?= old('domisili2') ?? '' ?>">
                                        </div>
                                    </div>
                                    <?php if (isset($fdErr['domisili'])) : ?>
                                        <span class="help-block"><?= $fdErr['domisili'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group <?= isset($fdErr['lokasi_kerja']) ? 'has-error' : '' ?>"">
                            <label class=" control-label"><?= isset($fdErr['lokasi_kerja']) ? $errIcon : '' ?>&nbsp;Lokasi Kerja</label>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <select name="lokasi_kerja" class="form-control">
                                                <option value="">-- Pilih salah satu --</option>
                                                <?php $oldLokasiKerja = old('lokasi_kerja'); ?>
                                                <?php $oldLokasiKerja2 = old('lokasi_kerja2'); ?>
                                                <?php foreach ($listLokasiKerja as $lokasiKerjaItem) : ?>
                                                    <option value="<?= $lokasiKerjaItem->value ?>" <?= isset($oldLokasiKerja) ? ($oldLokasiKerja == $lokasiKerjaItem->value ? 'selected' : '') : '' ?>><?= $lokasiKerjaItem->text ?></option>
                                                <?php endforeach; ?>
                                                <option <?= isset($oldLokasiKerja2) ? ($oldLokasiKerja == 'lainnya' ? 'selected' : '') : '' ?> value="lainnya">Lainnya</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-6">
                                            <input style="visibility: <?= isset($oldLokasiKerja2) && !empty($oldLokasiKerja2) ? 'visible' : 'hidden' ?>;" type="text" name="lokasi_kerja2" class="form-control" placeholder="Masukkan lokasi kerja ..." value="<?= old('lokasi_kerja2') ?? '' ?>">
                                        </div>
                                    </div>
                                    <?php if (isset($fdErr['lokasi_kerja'])) : ?>
                                        <span class="help-block"><?= $fdErr['lokasi_kerja'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group <?= isset($fdErr['jenis_pekerja']) ? 'has-error' : '' ?>"">
                            <label class=" control-label"><?= isset($fdErr['jenis_pekerja']) ? $errIcon : '' ?>&nbsp;Jenis Pekerja</label>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <select name="jenis_pekerja" class="form-control">
                                                <option value="">-- Pilih salah satu --</option>
                                                <?php $oldJenisPekerja = old('jenis_pekerja'); ?>
                                                <?php $oldJenisPekerja2 = old('jenis_pekerja2'); ?>
                                                <?php foreach ($listJenisPekerja as $jenisPekerjaItem) : ?>
                                                    <option value="<?= $jenisPekerjaItem->value ?>" <?= isset($oldJenisPekerja) ? ($oldJenisPekerja == $jenisPekerjaItem->value ? 'selected' : '') : '' ?>><?= $jenisPekerjaItem->text ?></option>
                                                <?php endforeach; ?>
                                                <option <?= isset($oldJenisPekerja2) ? ($oldJenisPekerja == 'lainnya' ? 'selected' : '') : '' ?> value="lainnya">Lainnya</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-6">
                                            <input style="visibility: <?= isset($oldJenisPekerja2) && !empty($oldJenisPekerja2) ? 'visible' : 'hidden' ?>;" type="text" name="jenis_pekerja2" class="form-control" placeholder="Masukkan jenis pekerja ..." value="<?= old('jenis_pekerjaan2') ?? '' ?>">
                                        </div>
                                    </div>
                                    <?php if (isset($fdErr['jenis_pekerja'])) : ?>
                                        <span class="help-block"><?= $fdErr['jenis_pekerja'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group <?= isset($fdErr['pekerjaan']) ? 'has-error' : '' ?>"">
                            <label class=" control-label"><?= isset($fdErr['pekerjaan']) ? $errIcon : '' ?>&nbsp;Pekerjaan</label>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <select name="pekerjaan" class="form-control">
                                                <option value="">-- Pilih salah satu --</option>
                                                <?php $oldPekerjaan = old('pekerjaan'); ?>
                                                <?php $oldPekerjaan2 = old('pekerjaan2'); ?>
                                                <?php foreach ($listPekerjaan as $pekerjaanItem) : ?>
                                                    <option value="<?= $pekerjaanItem->value ?>" <?= isset($oldPekerjaan) ? ($oldPekerjaan == $pekerjaanItem->value ? 'selected' : '') : '' ?>><?= $pekerjaanItem->text ?></option>
                                                <?php endforeach; ?>
                                                <option <?= isset($oldPekerjaan2) ? ($oldPekerjaan2 == 'lainnya' ? 'selected' : '') : '' ?> value="lainnya">Lainnya</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-6">
                                            <input style="visibility: <?= isset($oldPekerjaan2) && !empty($oldPekerjaan2) ? 'visible' : 'hidden' ?>;" type="text" name="pekerjaan2" class="form-control" placeholder="Masukkan pekerjaan ..." value="<?= old('pekerjaan2') ?? '' ?>">
                                        </div>
                                    </div>
                                    <?php if (isset($fdErr['pekerjaan'])) : ?>
                                        <span class="help-block"><?= $fdErr['pekerjaan'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group <?= isset($fdErr['foto']) ? 'has-error' : '' ?>"">
                            <label for=" foto"><?= isset($fdErr['foto']) ? $errIcon : '' ?>&nbsp;Foto</label>
                                    <input type="file" name="foto">
                                    <p>Ukuran 3x4, max. <strong>500 KB</strong></p>
                                    <?php if (isset($fdErr['foto'])) : ?>
                                        <span class="help-block"><?= $fdErr['foto'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group <?= isset($fdErr['ktp']) ? 'has-error' : '' ?>"">
                            <label for=" ktp"><?= isset($fdErr['ktp']) ? $errIcon : '' ?>&nbsp;Scan KTP</label>
                                    <input type="file" name="ktp">
                                    <p>Max. <strong>1 MB</strong></p>
                                    <?php if (isset($fdErr['ktp'])) : ?>
                                        <span class="help-block"><?= $fdErr['ktp'] ?></span>
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

        $('#form-add-pekerja select[name="domisili"]').on('change', function(e) {
            if ($(this).val() == 'lainnya') {
                $(this).parent().next().find('input').css('visibility', 'visible');
            } else {
                $(this).parent().next().find('input').css('visibility', 'hidden');
                $(this).parent().next().find('input').val('');
            }
        });

        $('#form-add-pekerja select[name="lokasi_kerja"]').on('change', function(e) {
            if ($(this).val() == 'lainnya') {
                $(this).parent().next().find('input').css('visibility', 'visible');
            } else {
                $(this).parent().next().find('input').css('visibility', 'hidden');
                $(this).parent().next().find('input').val('');
            }
        });

        $('#form-add-pekerja select[name="jenis_pekerja"]').on('change', function(e) {
            if ($(this).val() == 'lainnya') {
                $(this).parent().next().find('input').css('visibility', 'visible');
            } else {
                $(this).parent().next().find('input').css('visibility', 'hidden');
                $(this).parent().next().find('input').val('');
            }
        });

        $('#form-add-pekerja select[name="pekerjaan"]').on('change', function(e) {
            if ($(this).val() == 'lainnya') {
                $(this).parent().next().find('input').css('visibility', 'visible');
            } else {
                $(this).parent().next().find('input').css('visibility', 'hidden');
                $(this).parent().next().find('input').val('');
            }
        });
    });
</script>
<?= $renderer->endSection() ?>