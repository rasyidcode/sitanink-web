<?= $renderer->extend('modules/shared/core/views/layout') ?>

<?= $renderer->section('content') ?>
<section class="content">

    <div class="error-page">
        <h2 class="headline text-red">405</h2>

        <div class="error-content">
            <h3><i class="fa fa-warning text-red"></i> Not Allowed.</h3>

            <p>
                User anda tidak diperbolehkan untuk mengakses halaman ini, silahkan <a href="<?=route_to('admin')?>">kembali ke dashboard</a>
            </p>
        </div>
    </div>

</section>
<?= $renderer->endSection() ?>