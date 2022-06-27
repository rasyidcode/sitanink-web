<?= $renderer->extend('modules/shared/core/views/layout') ?>

<?= $renderer->section('content') ?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title">Detail Pekerja</h3>
                </div>
                <div class="box-body">
                    <div style="margin-bottom: 16px;" class="row">
                        <div class="col-xs-12">
                            <!-- <h3 style="margin-top: 0">Data Personal</h3> -->
                            <div class="row">
                                <div class="col-xs-2">
                                    <div class="foto-css add-border center-block">
                                        <?php if (!is_null($data->foto ?? null)) : ?>
                                            <img class="foto-css center-block" src="<?= site_url('uploads/' . $data->foto) ?>" alt="Photo">
                                        <?php else : ?>
                                            <p class="text-left text-danger">Berkas Foto tidak ada!</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <th>NIK</th>
                                                    <td>:</td>
                                                    <td><?= $data->nik ?? '' ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Nama</th>
                                                    <td>:</td>
                                                    <td><?= $data->nama ?? ''?></td>
                                                </tr>
                                                <tr>
                                                    <th>TTL</th>
                                                    <td>:</td>
                                                    <td><?= $data->ttl ?? ''?></td>
                                                </tr>
                                                <tr>
                                                    <th>Alamat</th>
                                                    <td>:</td>
                                                    <td><?= $data->alamat ?? '' ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Pekerjaan</th>
                                                    <td>:</td>
                                                    <td><?=$data->pekerjaan ?? ''?></td>
                                                </tr>
                                                <tr>
                                                    <th>Lokasi Kerja</th>
                                                    <td>:</td>
                                                    <td><?=$data->lokasi_kerja ?? ''?></td>
                                                </tr>
                                                <tr>
                                                    <th>Jenis Pekerja</th>
                                                    <td>:</td>
                                                    <td><?=$data->jenis_pekerja ?? ''?></td>
                                                </tr>
                                                <tr>
                                                    <th>KTP</th>
                                                    <td>:</td>
                                                    <td>
                                                        <a style="cursor: pointer;" 
                                                            data-toggle="modal" 
                                                            data-target="#modal-show-image" 
                                                            data-tipe-berkas="2"
                                                            onclick="return false"><i class="fa fa-eye"></i> Lihat</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>KK</th>
                                                    <td>:</td>
                                                    <td>
                                                        <a style="cursor: pointer;" 
                                                            data-toggle="modal" 
                                                            data-target="#modal-show-image" 
                                                            data-tipe-berkas="3"
                                                            onclick="return false"><i class="fa fa-eye"></i> Lihat</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Surat Permohonan Ijin Usaha</th>
                                                    <td>:</td>
                                                    <td>
                                                        <a style="cursor: pointer;" 
                                                            data-toggle="modal" 
                                                            data-target="#modal-show-image" 
                                                            data-tipe-berkas="4"
                                                            onclick="return false"><i class="fa fa-eye"></i> Lihat</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Surat Perijinan</th>
                                                    <td>:</td>
                                                    <td>
                                                        <a style="cursor: pointer;" 
                                                            data-toggle="modal" 
                                                            data-target="#modal-show-image"
                                                            data-tipe-berkas="5"
                                                            onclick="return false"><i class="fa fa-eye"></i> Lihat</a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- div end -->
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-show-image">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <img class="center-block img-responsive" src="#" alt="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</section>

<?= $renderer->endSection() ?>

<?= $renderer->section('custom-js') ?>
<script>
    $(function() {
        $('#modal-show-image').on('show.bs.modal', function(e) {
            var relatedTarget = $(e.relatedTarget).data();
            var tipe = relatedTarget.tipeBerkas;
            console.log(tipe);
            var $thisElement = $(this);
            $.ajax({
                type: 'get',
                url: `<?= route_to('api.pekerja.get-berkas', $data->id ?? '0') ?>?tipe=${tipe}`,
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('Authorization', 'Basic ' + btoa('sitaninkadmin:admin123'));
                },
                success: function(res) {
                    console.log(res);

                    if (res.data) {
                        $thisElement.find('img')
                               .attr('src', `<?= site_url('uploads') ?>/${res.data.filename}`)
                               .attr('alt', tipe);
                    } else {
                        alert('Failed to show image!');
                    }
                },
                error: function(err) {
                    console.log(err);

                    alert('Failed to show image!');
                }
            })
        });
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