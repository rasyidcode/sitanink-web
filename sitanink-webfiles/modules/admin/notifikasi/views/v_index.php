<?= $renderer->extend('modules/shared/core/views/layout') ?>

<?= $renderer->section('content') ?>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- The time line -->
            <ul class="timeline">
                <?php foreach ($activities as $date => $items) : ?>
                    <!-- timeline time label -->
                    <li class="time-label">
                        <span class="bg-green">
                            <?= $date ?>
                        </span>
                    </li>
                    <!-- /.timeline-label -->
                    <?php foreach ($items as $activity) : ?>
                        <!-- timeline item -->
                        <li>
                            <?php if ($activity->type === 'info') : ?>
                                <i class="fa fa-info bg-blue"></i>
                            <?php elseif ($activity->type == 'reminder') : ?>
                                <i class="fa fa-bell-o bg-orange"></i>
                            <?php endif; ?>
                            <div class="timeline-item">
                                <span class="time">
                                    <i class="fa fa-clock-o"></i> <?= $activity->time_ago ?>
                                </span>
                                <h3 class="timeline-header no-border">
                                    <?php if (!$activity->is_read): ?>
                                        <span style="cursor: pointer; margin-right: 8px;" class="label label-danger">Belum dibaca</span>
                                    <?php else: ?>
                                        <span style="cursor: pointer; margin-right: 8px;" class="label label-success">Sudah dibaca</span>
                                    <?php endif; ?>
                                    <?= $activity->message ?>
                                </h3>
                            </div>
                        </li>
                        <!-- END timeline item -->
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </ul>
        </div>
        <!-- /.col -->
    </div>
</section>
<?= $renderer->endSection() ?>

<?= $renderer->section('custom-js') ?>
<script>
$(function() {
    $('ul.timeline li').on('click', 'div.timeline-item h3 span', function(e) {
        console.log('clicked');
    });
});
</script>
<?= $renderer->endSection() ?>

<?= $renderer->section('custom-css') ?>
<?= $renderer->endSection() ?>