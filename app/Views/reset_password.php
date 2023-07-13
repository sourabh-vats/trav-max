<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Travmax">
    <meta name="description" content=" We offer flights, packages, hotels, corporate travel services, the best customized travel support and more.">
    <meta property="og:title" content="Travmax"/>
    <meta property="og:image" content="http://travmaxholidays.com/images/logo-social.jpg"/>
    <title>Signup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="/lib/jquery/jquery-1.11.1.min.js"></script>
    <style>
        body {
            height: 100vh;
        }

        .content_box {
            margin: 0px 20px;
            width: -webkit-fill-available;
            max-width: 450px;
        }

        #container_div {
            height: 100vh;
        }

        #loading_screen {
            position: fixed;
            width: 100%;
            background-color: rgba(255, 255, 255, .8);
            z-index: 10;
        }

        @media only screen and (max-width: 768px) {
            #container_div {
                height: 100%;
            }
        }
    </style>
</head>

<body>
    <div id="loading_screen" class="d-flex justify-content-center h-100 align-items-center d-none">
        <div class="spinner-border" role="status" style="width: 3rem; height:3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div class="row g-0">
        <div class="col-md-6 d-flex align-items-center justify-content-center" id="container_div">
            <div class="content_box">
                <div class="text-center my-2 my-md-3">
                    <a href="/">
                        <img height="40px" src="/images/logo.png" alt="">
                    </a>
                </div>
                <form id="register-form" action="/reset_password" method="POST">
                    <div class="alert alert-danger text-center d-none" id="signup_error" role="alert">

                    </div>
                    
                    <div class="row g-0 g-md-3">
                        <div class="col-md">
                            <div class="form-floating mb-3">
                                <input name="password" type="password" class="form-control" id="password" placeholder="*********" required>
                                <label for="password">Password</label>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-floating mb-3">
                                <input name="cpassword" type="password" class="form-control" id="cpassword" placeholder="*********" required>
                                <label for="password">Confirm Password</label>
                            </div>
                        </div>
                        <input type="hidden" class="form-control" id="token" name="token" placeholder="01234" required value="<?php echo isset($_GET['token']) ? $_GET['token'] : ''; ?>">
                    </div>
                    <button type="submit" class="btn btn-danger w-100 btn-lg">Reset Password</button>
                </form>
            </div>
        </div>
        <div class="col-md-6 d-none d-md-block" style="background-image: url(/images/macro.jpg); background-position:center; background-size:cover">
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
<script>
    jQuery("#register-form").submit(function(event) {
        event.preventDefault();
        jQuery("#loading_screen").removeClass("d-none");
        jQuery.ajax({
            type: "POST",
            url: "/reset_password",
            data: jQuery("#register-form").serialize(),
            success: function(data) {
                // console.log(data);
                if (data.status == "error") {
                    jQuery("#signup_error").removeClass("d-none");
                    jQuery("#signup_error").text(data.message);
                }else if(data.status == "success"){
                    jQuery("#signup_error").removeClass("d-none");
                    jQuery("#signup_error").removeClass("alert-danger");
                    jQuery("#signup_error").addClass("alert-primary");
                    jQuery("#signup_error").text(data.message);
                    // window.location.replace("");
                }
                jQuery("#loading_screen").addClass("d-none");
            }
        });
    });
</script>

</html>