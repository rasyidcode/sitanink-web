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
                            <?php foreach ($dataReview as $dataReviewItem) : ?>
                                <tr>
                                    <td><?= $dataReviewItem->id ?></td>
                                    <td><?= $dataReviewItem->nik ?></td>
                                    <td><?= $dataReviewItem->nama ?></td>
                                    <td><span class="label label-<?= $dataReviewItem->status == 'pending' ? 'warning' : 'danger' ?>"><?= $dataReviewItem->status ?></span></td>
                                    <td>2022-05-22 11:00:12</td>
                                    <td>
                                        <form action="<?= route_to('review.cancel', $dataReviewItem->id) ?>" method="POST">
                                            <a href="<?= route_to('review.confirm', $dataReviewItem->id) ?>" class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i>&nbsp;Lihat Detail</a>
                                            <button <?= (!is_null($dataReviewItem->deleted_at) ? 'disabled' : '') ?> type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>&nbsp;Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
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