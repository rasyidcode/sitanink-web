<?= $renderer->extend('modules/shared/core/views/layout') ?>

<?= $renderer->section('content') ?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title">Tipe Berkas</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-6">
                            <form action="<?= route_to('setting.tipe-berkas.pas-foto') ?>" method="POST" class="form-horizontal">
                                <?= csrf_field() ?>
                                <div class="form-group">
                                    <label for="value" class="col-sm-6 control-label">Berkas Pas Foto</label>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <select name="value" class="form-control">
                                                <option value="">-- Pilih salah satu --</option>
                                                <?php foreach ($berkasTypes as $berkasTypesItem) : ?>
                                                    <option value="<?= $berkasTypesItem->value ?>" <?= $berkasTypesItem->value == ($pasFotoId->value ?? '') ? 'selected' : '' ?>><?= $berkasTypesItem->text ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <input type="hidden" name="related_table" value="berkas_types">
                                        <input type="hidden" name="key" value="id_pas_foto">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-sm pull-right">Simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title">Pekerja</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
</section>
<?= $renderer->endSection() ?>