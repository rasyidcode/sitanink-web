<?= $renderer->extend('modules/shared/core/views/layout') ?>

<?= $renderer->section('content') ?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title">Data Setting</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-6">
                            <form action="<?= route_to('setting.tipe-berkas.pas-foto') ?>" method="POST" class="form-horizontal">
                                <?= csrf_field() ?>
                                <div class="form-group">
                                    <label for="id_pas_foto" class="col-sm-6 control-label">Berkas Pas Foto</label>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <select name="id_pas_foto" class="form-control">
                                                <option value="">-- Pilih salah satu --</option>
                                                <?php foreach ($berkasTypes as $berkasTypesItem) : ?>
                                                    <option value="<?= $berkasTypesItem->value ?>" <?= $berkasTypesItem->value == ($idPasFoto->value ?? '') ? 'selected' : '' ?>><?= $berkasTypesItem->text ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="value" class="col-sm-6 control-label">NIP Kepala</label>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" name="nip_kepala" class="form-control" placeholder="Masukkan NIP Kepala ..." value="<?= $nipKepala->value ?? '' ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="value" class="col-sm-6 control-label">Nama Kepala</label>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" name="nama_kepala" class="form-control" placeholder="Masukkan Nama Kepala ..." value="<?= $namaKepala->value ?? '' ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-sm pull-right">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
</section>
<?= $renderer->endSection() ?>