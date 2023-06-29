<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/lib/bootstrap5.3/bootstrap.min.css">
    <link rel="stylesheet" href="/css/admin_style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="/lib/jquery/jquery-3.6.4.min.js"></script>
    <script src="/lib/bootstrap5.3/bootstrap.bundle.min.js"></script>
    <?php
    if (!empty($js)) {
        echo '<script src="' . $js . '"></script>';
    }
    if (!empty($css)) {
        echo '<link rel="stylesheet" href="' . $css . '">';
    }
    ?>
</head>
<style>

</style>

<body>
    <div class="container">
        <a class="d-block m-auto text-center my-3" href="/"><img height="30px" src="/images/logo.png" alt="" srcset=""></a>
        <div class="row d-flex align-items-center justify-content-center flex-wrap" id="select_package_section">
            <h1 class="text-center">Please select a package from the following and continue.</h1>
            <?php foreach ($all_packages as $package) { ?>
                <div class="col-md-4 d-flex justify-content-center p-3">
                    <div class="package_card">
                        <a href="/signup/choose_partnership?package=<?php echo $package['id']; ?>">
                            <img class="img-fluid select_package_id" src="/images/<?php echo $package['name']; ?>.jpg" alt="" title="<?php echo $package['id']; ?>">
                        </a>
                        <input type="hidden" name="package_information" class="package_information" value='<?php echo json_encode($package); ?>'>
                        <p class="package_title"><?php echo $package['name']; ?></p>
                        <a href="/terms_of_use">Terms And Conditions</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <script>

    </script>
</body>

</html>