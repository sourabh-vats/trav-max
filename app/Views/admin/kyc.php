<style>
  .smry4 {
    background: url(../images/edit-ing.jpg) no-repeat scroll center;

  }

  .smry {
    font-size: 45px;
  }

  .smry {
    padding: 10px 0;
    line-height: normal;
    color: #fff;
  }

  .col-sm-10 {

    padding: 0 !important;
  }
</style>

<div class="smry smry4  text-center">
  <h2>Payment Details</h2>
</div>
<div class="col-sm-12">
  <?php
  $user = $profile[0];
  ?>




</div>
<div class="col-sm-12 right-bar">

  <?php
  helper('form');
  //flash messages
  $session = session();
  if ($session->getFlashdata('flash_message')) {
    if ($session->getFlashdata('flash_message') == 'updated') {
      echo '<div class="alert alert-success">';
      echo '<a class="close" data-dismiss="alert">×</a>';
      echo 'Kyc updated successfully.';
      echo '</div>';
    } else {
      $flashMessage = $session->getFlashdata('flash_message');
      echo '<div class="alert alert-danger">';
      echo $flashMessage;
      echo '<a class="close" data-dismiss="alert">×</a>';
      echo '</div>';
    }
  }

  if ($user['var_status'] == 'no') {
    echo '<div class="alert alert-danger">';
    echo '<a class="close" data-dismiss="alert">×</a>';
    echo 'Your profile is under review please wait 2 working days';
    echo '</div>';
  }

  // echo validation_errors(); 
  ?>
  <br>
<form id="update-profile" action="<?= base_url() ?>admin/kyc" method="POST">
    <div class="alert alert-danger text-center d-none" id="signup_error" role="alert"></div>

    <!-- PAN Card Section -->
    <div class="form-group row">
        <label for="pancard" class="col-sm-3 col-form-label">PAN Card No.</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="pancard" name="pancard" value="<?= ($_POST['pancard'] != '') ? $_POST['pancard'] : $user['pancard'] ?>">
        </div>
    </div>
    <br>
    <div class="form-group row">
        <label for="panimage" class="col-sm-3 col-form-label">PAN Proof</label>
        <div class="col-sm-9">
            <input type="file" class="form-control-file" id="panimage" name="panimage">
            <input type="hidden" value="<?= $user['panimage'] ?>" name="panimage_old">
            <div>
                <input type="checkbox" name="applied_pan" <?= ($user['applied_pan'] == 'yes') ? 'checked' : '' ?> value="yes"> Applied for PAN Card
            </div>
            <?php if ($user['panimage'] != ''): ?>
                <a href="<?= base_url() ?>images/user/<?= $user['panimage'] ?>" target="_blank">
                    <img src="<?= base_url() ?>images/user/<?= $user['panimage'] ?>" style="width: auto; max-width: 64px;">
                </a>
            <?php endif; ?>
        </div>
    </div>
    <br> 

    <!-- Aadhar Section -->
    <div class="form-group row">
        <label for="aadhar" class="col-sm-3 col-form-label">Aadhar No.</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="aadhar" name="aadhar" value="<?= ($_POST['aadhar'] != '') ? $_POST['aadhar'] : $user['aadhar'] ?>">
        </div>
    </div>
    <br>
    <div class="form-group row">
        <label for="aadharimage" class="col-sm-3 col-form-label">Aadhar Proof</label>
        <div class="col-sm-9">
            <input type="file" class="form-control-file" id="aadharimage" name="aadharimage">
            <input type="hidden" value="<?= $user['aadharimage'] ?>" name="aadharimage_old">
            <div>
                <input type="checkbox" name="applied_aadhar" <?= ($user['applied_aadhar'] == 'yes') ? 'checked' : '' ?> value="yes"> Applied for Aadhar Card
            </div>
            <?php if ($user['aadharimage'] != ''): ?>
                <a href="<?= base_url() ?>images/user/<?= $user['aadharimage'] ?>" target="_blank">
                    <img src="<?= base_url() ?>images/user/<?= $user['aadharimage'] ?>" style="width: auto; max-width: 64px;">
                </a>
            <?php endif; ?>
        </div>
    </div>
    <br> 

    <!-- Bank Details Section -->
    <h4 style="text-align: center; clear: both; padding-top: 20px; color: #3999a6;">Enter Bank Details</h4>
    <br>
    <div class="form-group row">
        <label for="bank_name" class="col-sm-3 col-form-label">Bank Name</label>
        <div class="col-sm-9">
            <input required type="text" id="bank_name" name="bank_name" value="<?= ($_POST['bank_name'] != '') ? $_POST['bank_name'] : $user['bank_name'] ?>" class="form-control">
        </div>
    </div>
    <br>
    <div class="form-group row">
        <label for="account_name" class="col-sm-3 col-form-label">Account Name</label>
        <div class="col-sm-9">
            <input required type="text" id="account_name" name="account_name" value="<?= ($_POST['account_name'] != '') ? $_POST['account_name'] : $user['account_name'] ?>" class="form-control">
        </div>
    </div>
    <br>
    <div class="form-group row">
        <label for="account_no" class="col-sm-3 col-form-label">Account No.</label>
        <div class="col-sm-9">
            <input required type="number" id="account_no" name="account_no" value="<?= ($_POST['account_no'] != '') ? $_POST['account_no'] : $user['account_no'] ?>" class="form-control">
        </div>
    </div>
    <br>
    <div class="form-group row">
        <label for="ifsc" class="col-sm-3 col-form-label">IFSC Code</label>
        <div class="col-sm-9">
            <input required type="text" id="ifsc" name="ifsc" value="<?= ($_POST['ifcs'] != '') ? $_POST['ifcs'] : $user['ifsc'] ?>" class="form-control">
        </div>
    </div>
    <br>
    <div class="form-group row">
        <label for="cheque_img" class="col-sm-3 col-form-label">Cancel Cheque image</label>
        <div class="col-sm-9">
            <input type="file" class="form-control-file" id="cheque_img" name="cheque_img">
            <input type="hidden" value="<?= $user['cheque_img'] ?>" name="cheque_img_old">
            <?php if ($user['cheque_img'] != ''): ?>
                <a href="<?= base_url() ?>images/user/<?= $user['cheque_img'] ?>" target="_blank">
                    <img src="<?= base_url() ?>images/user/<?= $user['cheque_img'] ?>" style="width: auto; max-width: 64px;">
                </a>
            <?php endif; ?>
        </div>
    </div>
    <br>

    <div class="form-group">
        <div class="form-check">
            <input required type="checkbox" name="declare" value="1" class="form-check-input">
            <label class="form-check-label">
                I hereby declare that the details furnished above are correct to the best of my knowledge and belief.
            </label>
        </div>
    </div>
    <br>

    <div class="form-group">
        <?php if ($user['var_status'] != 'yes'): ?>
            <button class="btn btn-primary" type="submit">Update</button>
        <?php else: ?>
            <h2>If you want to make changes to your profile, <a href="https://www.realwater.in/contact_us">click here</a> to contact us.</h2>
        <?php endif; ?>
    </div>
</form>
</div>