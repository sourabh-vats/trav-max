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
    .package_card:not(.highlighted) .primary_btn,
    .package_card:not(.highlighted) .secondary_btn {
        display: none;
    }

    .highlighted {
        border: 2px solid tomato;
        transition: all 0.2s;
    }
</style>

<body>
    <div class="container">
        <a class="d-block m-auto text-center my-5" href="/"><img height="30px" src="/images/logo.png" alt="" srcset=""></a>
        <div class="row d-flex align-items-center justify-content-center flex-wrap" id="select_package_section">
            <h1 class="text-center">Please select a package from the following and continue.</h1>
            <?php if (isset($_GET['upgrade']) && $_GET['upgrade'] == 'true') :
                $_SESSION['upgrade'] = true;
            endif; ?>
            <h2 class="text-center" style="padding-top: 30px;">International Packages</h2>
            <?php foreach ($international as $package) { ?>
                <div class="col-md-4 d-flex justify-content-center p-3">
                    <div class="package_card" packageId="<?php echo $package['id']; ?>">
                        <a href="/signup/choose_partnership?package=<?php echo $package['id']; ?>">
                            <img onclick="handleImageClick(event)" class="img-fluid select_package_id" src="/images/<?php echo $package['name']; ?>.jpg" alt="" title="<?php echo $package['id']; ?>">
                        </a>
                        <input type="hidden" name="package_information" class="package_information" value='<?php echo json_encode($package); ?>'>
                        <p class="package_title"><?php echo $package['display_name']; ?></p>
                        <a href="/terms_of_use">Terms And Conditions</a>
                        <div class="w-100 mt-3 text-center">
                            <a onclick="handleContinueClick()" id="confirm_btn" class="primary_btn" style="display: none">Continue</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <h2 class="text-center" style="padding-top: 30px;">Domestic Packages</h2>

            <?php foreach ($national as $package) { ?>
                <div class="col-md-4 d-flex justify-content-center p-3">
                    <div class="package_card" packageId="<?php echo $package['id']; ?>">
                        <a href="/signup/choose_partnership?package=<?php echo $package['id']; ?>">
                            <img onclick="handleImageClick(event)" class="img-fluid select_package_id" src="/images/<?php echo $package['name']; ?>.jpg" alt="" title="<?php echo $package['id']; ?>">
                        </a>
                        <input type="hidden" name="package_information" class="package_information" value='<?php echo json_encode($package); ?>'>
                        <p class="package_title"><?php echo $package['display_name']; ?></p>
                        <a href="/terms_of_use">Terms And Conditions</a>
                        <div class="w-100 mt-3 text-center">
                            <a onclick="handleContinueClick()" id="confirm_btn" class="primary_btn" style="display: none">Continue</a>
                        </div>
                    </div>

                </div>
            <?php } ?>
        </div>
        <div class="w-100 mt-5 text-center">
            <?php
            if (isset($_SESSION['upgrade']) && $_SESSION['upgrade'] == true) {
                echo '<div class="w-100 mt-5 text-center"><a href="/admin" class="secondary_btn">Back</a></div>';
            }
            ?>
        </div>
    </div>
    <script>
        var highlightedPackageCard = null;
        const packageCards = document.querySelectorAll('.package_card');
        packageCards.forEach(packageCard => {
            const confirmBtn = packageCard.querySelector('#confirm_btn');

            confirmBtn.style.display = 'none';

            packageCard.addEventListener('click', event => {
                if (highlightedPackageCard) {
                    highlightedPackageCard.querySelector('#confirm_btn').style.display = 'none';
                }
                confirmBtn.style.display = 'inline-block';
                highlightedPackageCard = packageCard;
            });

        });

        function handleImageClick(event) {
            event.preventDefault();
            if (highlightedPackageCard) {
                highlightedPackageCard.classList.remove('highlighted');
            }
            var aTag = event.target.closest('a');
            savedHref = aTag.getAttribute('href');
        }

        function handleContinueClick() {
            if (highlightedPackageCard) {
                $.ajax('/api/set_partnership', {
                    dataType: 'json',
                    type: 'POST', // http method
                    data: {
                        packageId: highlightedPackageCard.getAttribute("packageid"),
                        partnership: "",
                        plan: ""
                    }, // data to submit
                    success: function(response, status, xhr) {
                        console.log(response);
                        if (response.status == "success") {
                            window.location.replace(savedHref);
                        } else if (response.status == "fail") {
                            alert("Unable to handle request 1.")
                        } else {
                            alert("Unable to handle request 2.")
                        }
                    },
                    error: function(jqXhr, textStatus, errorMessage) {
                        console.log(errorMessage);
                    }
                });
            }
        }
    </script>
</body>

</html>