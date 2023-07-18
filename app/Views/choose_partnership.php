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
        <style>
            .plan:hover {
                filter: drop-shadow(2px 4px 6px black);
                cursor: pointer;
            }
        </style>
        <a class="d-block m-auto text-center my-3" href="/"><img height="30px" src="/images/logo.png" alt="" srcset=""></a>
        <h1 class="text-center">Please select your Partnership Plan.</h1>
        <div class="row g-0 my-3" style="margin:auto;display:flex; justify-content:center; align-items:center;">
            <div class="col">
                <img class="img-fluid" src="/images/plans/features.jpg" alt="">
            </div>
            <div class="col">
                <a href="/signup/choose_payment_plan?plan=microx<?php echo isset($_GET['package']) ? '&package=' . $_GET['package'] : ''; ?>">
                    <img class="img-fluid plan" src="/images/plans/microx.jpg" alt="">
                </a>
            </div>
            <div class="col">
                <a href="/signup/choose_payment_plan?plan=micro2x<?php echo isset($_GET['package']) ? '&package=' . $_GET['package'] : ''; ?>">
                    <img class="img-fluid plan" src="/images/plans/micro2x.jpg" alt="">
                </a>
            </div>
            <div class="col">
                <a href="/signup/choose_payment_plan?plan=micro3x<?php echo isset($_GET['package']) ? '&package=' . $_GET['package'] : ''; ?>">
                    <img class="img-fluid plan" src="/images/plans/micro3x.jpg" alt="">
                </a>
            </div>
            <div class="col">
                <a href="/signup/choose_payment_plan?plan=micro4x<?php echo isset($_GET['package']) ? '&package=' . $_GET['package'] : ''; ?>">
                    <img class="img-fluid plan" src="/images/plans/micro4x.jpg" alt="">
                </a>
            </div>
            <div class="col">
                <a href="/signup/choose_payment_plan?plan=macro<?php echo isset($_GET['package']) ? '&package=' . $_GET['package'] : ''; ?>">
                    <img class="img-fluid plan" src="/images/plans/macro.jpg" alt="">
                </a>
            </div>
        </div>
    </div>
    <script>

    </script>
</body>

</html>