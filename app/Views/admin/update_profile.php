<!DOCTYPE html>
<html>

<head>
    <title>Update Profile</title>
</head>

<body>
    <div class="page-heading">
        <h2>Update Profile</h2>
    </div><br>
    <?php if (session()->has('flash_message')): ?>
    <div class="alert alert-success">
        <?= session('flash_message') ?>
    </div>
<?php endif; ?>

<form action="/admin/update_profile" method="POST">
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

    <button type="submit" class="btn btn-primary">Update Profile</button>
</form>
</body>

</html>
