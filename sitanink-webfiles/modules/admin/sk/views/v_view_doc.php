
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
                    <h3 class="box-title">Lihat SK</h3>
                </div>
                <div class="box-body">
                    <iframe src="https://docs.google.com/gview?url=<?=site_url('docs_gen/'.$sk->filename)?>&embedded=true"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $renderer->endSection() ?>

<?= $renderer->section('custom-js') ?>
<?= $renderer->endSection() ?>

<?= $renderer->section('custom-css') ?>
<?= $renderer->endSection() ?>