<!DOCTYPE html>
<html>

<head>
    <title>Update Profile</title>
</head>

<body>
    <div id="loading_screen" class="d-flex justify-content-center align-items-center d-none" style="height: 150%;">
        <div class="spinner-border" role="status" style="width: 3rem; height:3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div class="page-heading">
        <h2>Update Profile</h2>
    </div><br>
    <?php if (session()->has('flash_message')) : ?>
        <div class="alert alert-success">
            <?= session('flash_message') ?>
        </div>
    <?php endif; ?>

    <form id="update-profile" action="/admin/update_profile" method="POST">
    <div class="alert alert-danger text-center d-none" id="signup_error" role="alert"></div>
        <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" class="form-control" id="first_name" name="first_name" value="<?= $profile[0]['f_name'] ?>">
        </div><br>

        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="<?= $profile[0]['l_name'] ?>">
        </div><br>

        <div class="form-group">
            <label for="email">Email Address:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= $profile[0]['email'] ?>">
        </div><br>
        <div class="form-floating mb-3 d-none" id="otp_field">
                        <input name="otp" type="text" class="form-control" id="otp" placeholder="Enter The OTP">
                        <label for="otp">OTP</label>
                    </div>
        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</body>

</html>
<script>
    jQuery("#update-profile").submit(function(event) {
        event.preventDefault();
        jQuery("#loading_screen").removeClass("d-none");
        jQuery.ajax({
            type: "POST",
            url: "/admin/update_profile",
            data: jQuery("#update-profile").serialize(),
            success: function(data) {
                // console.log(data);
                if (data.status == "error") {
                    if (data.message == "Enter the otp") {
                        jQuery("#loading_screen").addClass("d-none");
                        jQuery("#signup_error").removeClass("d-none");
                        jQuery("#signup_error").removeClass("alert-danger");
                        jQuery("#signup_error").addClass("alert-primary");
                        jQuery("#signup_error").text(data.message);
                        jQuery("#otp_field").removeClass("d-none");
                    } else {
                        jQuery("#signup_error").removeClass("d-none");
                        jQuery("#signup_error").text(data.message);
                    }
                } else if (data.status == "success") {
                    jQuery("#signup_error").removeClass("d-none");
                    jQuery("#signup_error").removeClass("alert-danger");
                    jQuery("#signup_error").addClass("alert-primary");
                    jQuery("#signup_error").text(data.message);
                    window.location.replace("/admin");
                }
                jQuery("#loading_screen").addClass("d-none");
            }
        });
    });
</script>