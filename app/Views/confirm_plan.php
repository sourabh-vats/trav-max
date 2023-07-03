<?php
$package = $package_data[0];
?>
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
        <a class="d-block m-auto text-center my-5" href="/"><img height="30px" src="/images/logo.png" alt="" srcset=""></a>
        <div class="row" id="wrapper">
            <div id="content_box">
                <p class="text_1">
                    <span>You've selected</span>
                    <span class="heading_1"><?php echo $package["name"]; ?></span><br>
                    <span><?php echo $package["nights"] ." ". $package["days"];?></span>
                    <br>
                    <br>
                    <span>The Plan you have selected is <span class="heading_1"><?php echo $_GET["plan"]; ?></span></span>
                    <br>
                    <br>
                    <span>You need to make a payment of <span class="heading_1">Rs <?php echo $payment_amount; ?></span></span>
                    <p class="h4">+GST 5%</p>
                    <p class="h5">TCS as applicable at the time.</p>
                </p>
                <br>
            </div>
        </div>
        <?php
        helper('form');
        $user = $profile[0];
        $attributes = array('class' => 'form');
        echo form_open_multipart(base_url('signup/confirm_plan'), $attributes);
        ?>
        <input type="hidden" name="package_id" value="<?= $package['id']; ?>">
        <input type="hidden" name="plan" value="<?php echo $_GET["plan"]; ?>">
        <input type="hidden" name="payment_plan" value="<?php echo $_GET["payment_plan"]; ?>">
        <div class="d-flex justify-content-center">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                <label class="form-check-label" for="invalidCheck">
                    <strong>Agree to <a href="/terms_of_use" target="_blank">terms and conditions</a></strong>
                </label>
                <div class="invalid-feedback">
                    You must agree before submitting.
                </div>
            </div>
        </div>
        <div class="text-center">
            <button class="primary_btn my-3" id="book_package_btn" type="submit">Confirm</button>
            <a href="/signup/choose_payment_plan?plan=<?php echo $_GET["plan"]; ?>&package=<?php echo $_GET["package"]; ?>" class="primary_btn">Change Plan</a>
        </div>
        <?= form_close(); ?>
    </div>
    <script>

    </script>
</body>

</html>