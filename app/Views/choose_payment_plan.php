<?php
$plan = "pax1";
if (!empty([$_GET["plan"]])) {
    $plan = $_GET["plan"];
}
switch ($plan) {
    case 'micro1x':
        $plan = "pax1";
        break;
    case 'micro2x':
        $plan = "pax2";
        break;
    case 'micro3x':
        $plan = "pax3";
        break;
    case 'micro4x':
        $plan = "pax4";
        break;
    case 'macro':
        $plan = "pax5";
        break;

    default:
        $plan = "pax1";
        break;
}
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
    .plan_box {
        max-width: 360px;
    }

    #partner {
        font-size: 24px;
        font-weight: 800;
    }

    #pick_a_plan_selected_package_name,
    #booking_packages_number {
        color: tomato;
    }
</style>

<body>
    <div class="container">
        <a class="d-block m-auto text-center my-5" href="/"><img height="30px" src="/images/logo.png" alt="" srcset=""></a>
        <div class="row" id="pick_a_plan_section">
            <h1 class="text-center mb-5">You have selected <span id="pick_a_plan_selected_package_name"><?php echo $package_data[0]["display_name"]; ?></span> package <?php if ($booking_packages_number != 1) {
                                                                                                                                                                            echo 'for&nbsp;<span id="booking_packages_number">' . $booking_packages_number . ' persons</span>';
                                                                                                                                                                        } ?>.<br> Please select a payment plan.</h1>
            <div class="card-group text-left justify-content-center">
                <div class="card plan_box" id="travnow_plan">
                    <div class="card-body">
                        <h5 class="card-title">trav<span style='color:#ea664f;'>now</h5>
                        <p>Package Name : <?php echo $package_data[0]['display_name']; ?></p>
                        <p>Price : ₹<?php echo $package_data[0]['total']; ?></p>
                        <p>Plan : <?php echo ucfirst($plan); ?></p>
                        <p>No. of Packages : <?php echo $booking_packages_number; ?></p>
                        <p>Total Amout : ₹<?php echo $package_data[0]['total'] . ' * ' . $booking_packages_number . ' = ' . $package_data[0]['total'] * $booking_packages_number; ?></p>
                        <p>Pay Now : ₹<?php echo $package_data[0]['total'] * $booking_packages_number; ?></p>
                    </div>
                    <div class="card-footer">
                        <?php if ($booking_packages_number == 1) {
                            echo '<h2>₹<span id="travnow_price">' . $package_data[0]['total'] . '</span></h2><p>Plus Taxes</p>';
                        } else {
                            echo '<h2>₹<span id="travnow_price">' . $package_data[0]['total'] * $booking_packages_number . '</span></h2><p>Plus Taxes</p>';
                        } ?>
                    </div>
                </div>
                <div class="card plan_box" id="travlater_plan">
                    <div class="card-body">
                        <h5 class="card-title">trav<span style="color: #ca3813;">later</h5>
                        <p>Package Name : <?php echo $package_data[0]['display_name']; ?></p>
                        <p>Price : ₹<?php echo $package_data[0]['total']; ?></p>
                        <p>Plan : <?php echo ucfirst($plan); ?></p>
                        <p>No. of Packages : <?php echo $booking_packages_number; ?></p>
                        <p>Total Amout : ₹<?php echo $package_data[0]['total'] . ' * ' . $booking_packages_number . ' = ₹' . $package_data[0]['total'] * $booking_packages_number; ?></p>
                        <p>Down Payment : ₹11000 per Person</p>
                        <p>Balance : In 12 equal EMIs</p>
                        <p>Pay Now : ₹<?php echo '11000 * ' . $booking_packages_number . ' = ₹' . 11000 * $booking_packages_number; ?></p>
                    </div>
                    <div class="card-footer">
                        <?php if ($booking_packages_number == 1) {
                            echo '<h2 id="travlater_price">₹11000</h2><p>Plus Taxes</p>';
                        } else {
                            echo '<h2 id="travlater_price">₹' . 11000 *  $booking_packages_number . '</h2><p>Plus Taxes</p>';
                        } ?>

                    </div>
                </div>
                <!-- <div class="card plan_box" id="traveasy_plan">
                    <div class="card-body">
                        <h5 class="card-title">trav<span style="color: #97030f;">easy</span></h5>
                        <p>Package Name : <?php echo $package_data[0]['display_name']; ?></p>
                        <p>Price : ₹<?php echo $package_data[0]['total']; ?></p>
                        <p>Plan : <?php echo ucfirst($plan); ?></p>
                        <p>No. of Packages : <?php echo $booking_packages_number; ?></p>
                        <p>Total Amout : ₹<?php echo $package_data[0]['total'] . ' * ' . $booking_packages_number . ' = ₹' . $package_data[0]['total'] * $booking_packages_number; ?></p>
                        <p>Down Payment : ₹5500 per Person</p>
                        <p>Pay Now : ₹<?php echo '5500 * ' . $booking_packages_number . ' = ₹' . 5500 * $booking_packages_number; ?></p>
                    </div>
                    <div class="card-footer">
                        <?php if ($booking_packages_number == 1) {
                            echo '<h2 id="travlater_price">₹5500</h2><p>Plus Taxes</p>';
                        } else {
                            echo '<h2 id="travlater_price">₹' . 5500 *  $booking_packages_number . '</h2><p>Plus Taxes</p>';
                        } ?>
                    </div>
                </div> -->
            </div>
            <div class="w-100 mt-5 text-center">
                <a href="/signup/confirm_plan?package=<?php echo $_GET["package"]; ?>&plan=<?php echo $_GET["plan"]; ?>&payment_plan=" id="confirm_btn" class="primary_btn d-none">Continue</a>
                <a href="/signup/choose_partnership?package=<?php echo $_GET["package"]; ?>" class="secondary_btn">Back</a>
            </div>
        </div>
    </div>
    <script>
        var link = $("#confirm_btn").attr("href");
        var original_link = $("#confirm_btn").attr("href");
        $(".plan_box").click(function() {
            $(".plan_box").each(function() {
                $(this).removeClass("selected");
            })
            $(this).addClass("selected");
            var planName = $(this).attr("id");
            $("input[name=payment_type]").val(planName);
            $("#book_package_btn").prop('disabled', false);
            link = original_link;
            link = link + planName;
            $("#confirm_btn").attr("href", link);
            $("#confirm_btn").attr("plan", planName);
            $("#confirm_btn").removeClass("d-none");
        });
        $("#confirm_btn").click(function(event) {
            event.preventDefault();
            let searchParams = new URLSearchParams(window.location.search)
            let package = searchParams.get('package');
            let partnership = searchParams.get('plan');
            $.ajax('/api/set_partnership', {
                dataType: 'json',
                type: 'POST', // http method
                data: {
                    packageId: package,
                    partnership: partnership,
                    plan: $("#confirm_btn").attr("plan")
                }, // data to submit
                success: function(response, status, xhr) {
                    console.log(response);
                    if (response.status == "success") {
                        window.location.replace($("#confirm_btn").attr("href"));
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
        });
    </script>
</body>

</html>