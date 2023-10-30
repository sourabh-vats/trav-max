<?= $this->include('includes/admin/header'); ?>
<main id="main" class="col-md-9 ms-sm-auto col-lg-10 px-3 px-md-5">
    <?php if($profile[0]["status"] == "hold") {
        echo '
        <div class="alert alert-primary" role="alert">
            <strong>Your confirmation is pending we are working on it.</strong>
        </div>';
    } ?>
    <?= $this->include($main_content); ?>
</main>
<?= $this->include('includes/admin/footer'); ?>