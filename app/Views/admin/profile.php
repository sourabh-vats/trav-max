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
    <label>Current Profile Picture:</label><br>
    <img class="img-fluid" width="90px" src="/images/user_profile/<?php echo $id; ?>.png" alt="Profile Picture"
        onerror="this.src='/images/user_profile/avatar.png';"><br><br>

    <form action="/admin/profile" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Upload New Profile Picture:</label><br>
            <input type="file" name="profile_image">
        </div><br>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update Profile Picture</button>
        </div>
    </form>

</body>

</html>
