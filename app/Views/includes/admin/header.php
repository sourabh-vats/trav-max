<?php
$session = session();
$user = $profile[0];
$full_name = $user['f_name'] . " " . $user['l_name'];
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <script src="https://cdn.logr-ingest.com/LogRocket.min.js" crossorigin="anonymous"></script>
    <script>
        window.LogRocket && window.LogRocket.init('bgyhu3/travmax');
    </script>
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
    <link rel="stylesheet" href="/lib/bootstrap5.3/bootstrap.min.css">
    <link rel="stylesheet" href="/css/admin_style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="/lib/jquery/jquery-3.6.4.min.js"></script>
    <script src="/lib/bootstrap5.3/bootstrap.bundle.min.js"></script>
    <script src="/js/dashboard.js"></script>
    <?php
    if (!empty($js)) {
        echo '<script src="' . $js . '"></script>';
    }
    if (!empty($css)) {
        echo '<link rel="stylesheet" href="' . $css . '">';
    }
    ?>
    <script>
        $(document).ready(function() {
            $(".nav-link").each(function() {
                var active_url = window.location.pathname;
                if ($(this).attr("href") == active_url) {
                    $(this).addClass("active");
                }
            });
        });
    </script>
</head>
<style>
    .profile-picture {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        object-fit: cover;
    }
</style>

<body>
    <input type="hidden" id="user_role" value="<?= $profile["0"]["role"] ?>">
    <input type="hidden" id="user_id" value="<?= $profile["0"]["id"] ?>">
    <header id="header_navbar" class="navbar navbar-light sticky-top flex-md-nowrap p-0">
        <a class="navbar-brand text-center col-md-3 col-lg-2 me-0 px-3 fs-6" href="/"><img class="img-fluid" width="200" src="/images/logo_white.png"></a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-nav w-100 d-flex flex-row justify-content-between wrap px-md-5">
            <div class="nav-item text-nowrap">
                <p class="px-1" id="header_date"><i class="bi-calendar-fill"></i> <?php echo strtoupper(date("l, d M")); ?></p>
            </div>
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" id="header_right_btn" href="/admin/update_profile">Profile<i class="bi-person-fill-gear"></i></a>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="pt-2 pt-md-3 d-flex d-md-flex flex-column align-items-center">
                    <a href="/admin/profile">
                        <div class="profile-picture-container">
                            <img class="profile-picture img-fluid" src="/images/user_profile/<?php echo $session->trav_id; ?>.png" alt="Profile Picture" onerror="this.src='/images/user_profile/avatar.png';">
                        </div>
                    </a>
                    <span class="mt-2" id="sidenav_name"><?php echo $full_name; ?></span>
                    <span id="sidenav_partnership_type">Partnership: <?php if ($profile["0"]["role"] == "macro") {
                                                                            echo "Pax 5";
                                                                        } else {
                                                                            echo "Pax" . substr($profile["0"]["role"], -2, -1);;
                                                                        } ?></span>
                    <span class="mb-md-3" id="sidenav_id">Trav ID: <?php echo $session->trav_id; ?></span>
                </div>
                <div class="position-sticky sidebar-sticky d-flex align-items-center justify-content-center">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/admin">
                                <i class="bi-house-fill"></i>
                                Dashboard
                            </a>
                        </li>
                        <?php if ($profile[0]["role"] == "micro") : ?>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="/signup/select_package?upgrade=true">
                                    <i class="bi-box-arrow-up"></i>
                                    Upgrade
                                </a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/admin/share_products">
                                <i class="bi bi-bag"></i>
                                Share Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/admin/kyc">
                                <i class="bi-bank2"></i>
                                Bank Details
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/admin/refer_and_earn/<?php echo $session->trav_id; ?>">
                                <i class="bi-share-fill"></i>
                                Refer & Earn
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/admin/marketing_materials/">
                                <i class="bi-megaphone-fill"></i>
                                Marketing Materials
                            </a>
                        </li>
                        <!-- <?php if ($profile[0]["role"] == "micro") {
                                } else { ?>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="/admin/installments">
                                    <i class="bi-calendar2-check-fill"></i>
                                    Installments
                                </a>
                            </li>
                        <?php } ?> -->
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/admin/mypurchases">
                                <i class="bi-bag-check-fill"></i>
                                My Purchases
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/admin/request-fund">
                                <i class="bi-cash"></i>
                                Payment
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/admin/DistributorLevelInformation">
                                <i class="bi-people-fill"></i>
                                My Partners
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/admin/support">
                                <i class="bi-info-circle-fill"></i>
                                Support/Help
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="d-flex align-items-center justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/admin/logout">
                            <i class="bi-box-arrow-left"></i>
                            Logout
                        </a>
                    </li>
                </div>
            </nav>