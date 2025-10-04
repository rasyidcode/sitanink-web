<?php $successMsg = session()->getFlashdata('success'); ?>
<?php if (isset($successMsg)) : ?>
    <span data-message="<?= $successMsg ?>"></span>
<?php endif; ?>