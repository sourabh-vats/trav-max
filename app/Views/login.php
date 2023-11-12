<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Travmax">
    <meta name="description" content="Login to your account at Travmax">
    <meta property="og:title" content="Travmax" />
    <meta property="og:image" content="http://travmaxholidays.com/images/logo-social.jpg" />
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="/lib/jquery/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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

        .radio-box {
            border: 1px solid #dee2e6;
            padding: 16px 12px;
        }

        #login_other_options {
            display: flex;
            align-items: center;
            justify-content: space-evenly;
            margin-top: 20px;
        }

        #login_other_options a {
            text-decoration: none;
        }


        .fa-eye,
        .fa-eye-slash {
            position: absolute;
            top: 40%;
            right: 4%;
            cursor: pointer;
            color: lightgray;
        }

        #error {
            display: none;
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
                <div id="error" class="alert alert-danger" role="alert">
                    A simple danger alert—check it out!
                </div>
                <form id="login-form" action="" method="POST">
                    <div class="alert alert-danger text-center d-none" id="login_error" role="alert">

                    </div>
                    <div id="login-msg-div"></div>
                    <div class="form-floating mb-3">
                        <input name="user_name" type="text" class="form-control" id="email" placeholder="name@example.com" aria-describedby="emailHelp" required>
                        <label for="email">User ID/Email/Phone</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input name="password" type="password" class="form-control" id="password" placeholder="*********" required>
                        <i class="fa-solid fa-eye" id="show-pass" onclick="togglePass()"></i>
                        <label for="password">Password</label>
                    </div>
                    <button type="submit" class="btn btn-danger w-100 btn-lg">Login</button>
                </form>
                <div id="login_other_options">
                    <a href="/signup">Create an account</a>
                    <span>|</span>
                    <a href="/forgot_password">I forgot my password</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 d-none d-md-block" style="background-image: url(/images/macro.jpg); background-position:center; background-size:cover">
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script>
        function togglePass() {
            const passwordInput = document.getElementById("password");
            const showPassIcon = document.getElementById("show-pass");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                showPassIcon.classList.remove("fa-eye");
                showPassIcon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                showPassIcon.classList.remove("fa-eye-slash");
                showPassIcon.classList.add("fa-eye");
            }
        }
    </script>

</body>


<script>
    function getQueryParameter(name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }

    jQuery("#login-form").submit(function(event) {
        event.preventDefault();
        jQuery("#loading_screen").removeClass("d-none");
        jQuery.ajax({
            type: "POST",
            url: "/login",
            data: jQuery("#login-form").serialize(),
            success: function(data) {
                data = JSON.parse(data);
                if (data.login == "true") {
                    if (data.role != "partner") {
                        window.location.replace("/admin");
                    } else {
                        $.ajax('/api/get_partnership', {
                            dataType: 'json',
                            type: 'POST', // http method
                            data: {
                                userId: data.id
                            }, // data to submit
                            success: function(response, status, xhr) {
                                if (response.status == "success") {
                                    if (response.data.type == "") {
                                        window.location.replace("/signup/choose_partnership?package=" + response.data.package_id);
                                    } else if (response.data.plan == "") {
                                        window.location.replace("/signup/choose_payment_plan?plan=" + response.data.type + "&package=" + response.data.package_id);
                                    }else{
                                        window.location.replace("/signup/confirm_plan?package="+response.data.package_id+"&plan="+response.data.type+"&payment_plan="+response.data.plan);
                                    }
                                } else if (response.status == "fail") {
                                    window.location.replace("/signup/select_package");
                                } else {
                                    console.log("Some error happend. Please come back.");
                                }
                            },
                            error: function(jqXhr, textStatus, errorMessage) {
                                console.log(errorMessage);
                            }
                        });

                    }
                } else if (data.login == "false") {
                    $("#error").text("The username or password you entered is incorrect.");
                    $("#error").show();
                    $("#loading_screen").addClass("d-none");
                } else {
                    $("#error").text("Some error occurred. Please try again later.");
                    $("#error").show();
                    $("#loading_screen").addClass("d-none");
                }
            }
        });
    });
</script>

</html>