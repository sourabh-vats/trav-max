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
    .highlighted {
        border: 2px solid tomato;
        transition: all 0.2s;
    }
    @media only screen and (max-width: 767px) {
    .highlighted {
        border: none;
        transition: none;
    }
}
    
</style>

<body>
    <div class="container">
        <style>
            .plan:hover {
                filter: drop-shadow(2px 4px 6px black);
                cursor: pointer;
            }

            #pick_a_plan_selected_package_name {
                color: tomato;
                text-align: center;
                font-size: 20px;
            }

            @media (max-width: 767px) {
            .show-on-mobile {
                display: block !important;
            }

            .show-on-desktop {
            display: none !important;
        }
        }

    @media (min-width: 768px) {
            .show-on-mobile {
            display: none !important;
        }

        .show-on-desktop {
            display: flex !important;
        }
    }
        </style>
        <?php

        function get_package_data($id)
        {
            $db = db_connect();
            $builder = $db->table('package');
            $builder->select('*');
            $builder->where('id', $id);
            $query = $builder->get();
            return $query->getResultArray();
        }
        $package_id = $_GET['package'];
        $package_data = get_package_data($package_id);

        ?>

        <a class="d-block m-auto text-center mx-md-5 my-3" href="/"><img height="30px" src="/images/logo.png" alt="" srcset=""></a>
        <p id="pick_a_plan_selected_package_name">You have selected <?php echo $package_data[0]["display_name"]; ?></p>
        <h1 class="text-center">Please select your Partnership Plan.</h1>
        </div>
        <div class="show-on-mobile" style="margin:auto;justify-content:center ;width:80%">
        <div class="d-flex " >
            <div class="col">
                <img class="img-fluid " src="/images/choose/1a.jpg" alt="">
            </div>
            <div class="col">
                <img class="img-fluid" src="/images/choose/2a.jpg" alt="">
            </div>
            <div class="col">
                <img class="img-fluid" src="/images/choose/3a.jpg" alt="">
            </div>
            <div class="col">
                <img class="img-fluid" src="/images/choose/4a.jpg" alt="">
            </div>
        </div>
        <a href="/signup/choose_payment_plan?plan=micro1x<?php echo isset($_GET['package']) ? '&package=' . $_GET['package'] : ''; ?> " >
        <div class="d-flex img-fluid plan " onclick="handleImageClick(event)" >
            <div class="col">
                <img class="img-fluid " id="myImage" src="/images/choose/1x.jpg" >
            </div>
            <div class="col">
                <img class="img-fluid" id="myImage"  src="/images/choose/1.jpg" alt="">
            </div>
            <div class="col">
                <img class="img-fluid" id="myImage" src="/images/choose/11.jpg" alt="">
            </div>
            <div class="col">
                <img class="img-fluid" id="myImage" src="/images/choose/111.jpg" alt="">
            </div>
        </div>
    </a>
    <a href="/signup/choose_payment_plan?plan=micro2x<?php echo isset($_GET['package']) ? '&package=' . $_GET['package'] : ''; ?>">
        <div class="d-flex img-fluid plan" onclick="handleImageClick(event)">
            <div class="col">
                <img class="img-fluid" src="/images/choose/2x.jpg" alt="" >
            </div>
            <div class="col">
                <img class="img-fluid" src="/images/choose/2.jpg" alt="" >
            </div>
            <div class="col">
                <img class="img-fluid" src="/images/choose/22.jpg" alt="" >
            </div>
            <div class="col">
                <img class="img-fluid" src="/images/choose/222.jpg" alt="">
            </div>
        </div>  
    </a>
    <a href="/signup/choose_payment_plan?plan=micro3x<?php echo isset($_GET['package']) ? '&package=' . $_GET['package'] : ''; ?>">
        <div class="d-flex img-fluid plan" onclick="handleImageClick(event)">
            <div class="col">
                <img class="img-fluid" src="/images/choose/3x.jpg" alt="" >
            </div>
            <div class="col">
                <img class="img-fluid" src="/images/choose/3.jpg" alt="" >
            </div>
            <div class="col">
                <img class="img-fluid" src="/images/choose/33.jpg" alt="">
            </div>
            <div class="col">
                <img class="img-fluid" src="/images/choose/333.jpg" alt="">
            </div>
        </div>
    </a>
    <a href="/signup/choose_payment_plan?plan=micro4x<?php echo isset($_GET['package']) ? '&package=' . $_GET['package'] : ''; ?>">
        <div class="d-flex img-fluid plan" onclick="handleImageClick(event)">
            <div class="col">
                <img class="img-fluid" src="/images/choose/4x.jpg" alt="">
            </div>
            <div class="col">
                <img class="img-fluid" src="/images/choose/4.jpg" alt="" >
            </div>
            <div class="col">
                <img class="img-fluid" src="/images/choose/44.jpg" alt="" >
            </div>
            <div class="col">
                <img class="img-fluid" src="/images/choose/444.jpg" alt="" >
            </div>
        </div>
    </a>
    <a href="/signup/choose_payment_plan?plan=macro<?php echo isset($_GET['package']) ? '&package=' . $_GET['package'] : ''; ?>">
        <div class="d-flex img-fluid plan" onclick="handleImageClick(event)">
            <div class="col">
                <img class="img-fluid" src="/images/choose/5x.jpg" alt="">
            </div>
            <div class="col">
                <img class="img-fluid" src="/images/choose/5.jpg" alt="" >
            </div>
            <div class="col">
                <img class="img-fluid" src="/images/choose/55.jpg" alt="" >
            </div>
            <div class="col">
                <img class="img-fluid" src="/images/choose/555.jpg" alt="">
            </div>
        </div>
      </div>
    </a>

        <div class="show-on-desktop row g-0 my-3 " style="margin:auto;display:flex; justify-content:center; align-items:center;width:75%">
            <div class="col">
                <img class="img-fluid" src="/images/plans/features.jpg" alt="">
            </div>
            <div class="col img-fluid plan">
                <a href="/signup/choose_payment_plan?plan=micro1x<?php echo isset($_GET['package']) ? '&package=' . $_GET['package'] : ''; ?>">
                    <img class="img-fluid " plan="micro1x" src="/images/plans/microx.jpg" alt="" id="myImage" onclick="handleImageClick(event)">
                </a>
            </div>
            <div class="col">
                <a href="/signup/choose_payment_plan?plan=micro2x<?php echo isset($_GET['package']) ? '&package=' . $_GET['package'] : ''; ?>">
                    <img class="img-fluid plan" plan="micro2x" src="/images/plans/micro2x.jpg" alt="" onclick="handleImageClick(event)">
                </a>
            </div>
            <div class="col">
                <a href="/signup/choose_payment_plan?plan=micro3x<?php echo isset($_GET['package']) ? '&package=' . $_GET['package'] : ''; ?>">
                    <img class="img-fluid plan" plan="micro3x" src="/images/plans/micro3x.jpg" alt="" onclick="handleImageClick(event)">
                </a>
            </div>
            <div class="col">
                <a href="/signup/choose_payment_plan?plan=micro4x<?php echo isset($_GET['package']) ? '&package=' . $_GET['package'] : ''; ?>">
                    <img class="img-fluid plan" plan="micro4x" src="/images/plans/micro4x.jpg" alt="" onclick="handleImageClick(event)">
                </a>
            </div>
            <div class="col">
                <a href="/signup/choose_payment_plan?plan=macro<?php echo isset($_GET['package']) ? '&package=' . $_GET['package'] : ''; ?>">
                    <img class="img-fluid plan" plan="macro" src="/images/plans/macro.jpg" alt="" onclick="handleImageClick(event)">
                </a>
            </div>
        </div> 

         <div class="w-100 mt-3 text-center">
            <a onclick="handleContinueClick()" id="confirm_btn" class="primary_btn" style="display: none">Continue</a>
            <a href="/signup/select_package" class="secondary_btn">Back</a>
        </div>
    
    <script>
        

        var highlightedImage = null;

        function handleImageClick(event) {
            event.preventDefault();
            if (highlightedImage) {
                highlightedImage.classList.remove('highlighted');
            }
            var aTag = event.target.closest('a');
            savedHref = aTag.getAttribute('href');
            partnership = event.target.getAttribute("plan");
            event.target.classList.add('highlighted');
            highlightedImage = event.target;
            var continueButton = document.getElementById('confirm_btn');
            continueButton.style.display = 'inline-block';
        }

        function handleContinueClick() {
            if (savedHref) {
                let searchParams = new URLSearchParams(window.location.search)
                let package = searchParams.get('package');
                $.ajax('/api/set_partnership', {
                    dataType: 'json',
                    type: 'POST', // http method
                    data: {
                        packageId: package,
                        partnership: partnership,
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