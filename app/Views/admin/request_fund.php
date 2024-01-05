<hr>
<meta name="viewport" content="width=device-width, initial-scale=1">

<div class="page-content">
  <div class="col-sm-8">
    <div class="page-heading">
      <h2>Add Payment proof</h2>
    </div>
    <?php
    //flash messages
    $session = session();
    if ($session->getFlashdata('flash_message')) {
      if ($session->getFlashdata('flash_message') == 'updated') {
        echo '<div class="alert alert-success">';
        echo '<strong>Well done!</strong> We have received your request and will confirm it. Our team will contact you within 24 to 48 hours.';
        echo '</div>';
      } else {
        echo '<div class="alert alert-danger">';
        echo '<a class="close" data-dismiss="alert">×</a>';
        echo '<strong>Oh snap!</strong> change a few things up and try submitting again.';
        echo '</div>';
      }
    }
    ?>

    <?php
    helper('form');
    //form data
    $attributes = array('class' => 'form', 'id' => '');

    echo form_open_multipart('admin/request-fund', $attributes);
    ?>

    <div class="pin-box">
      <div class="col-sm-11">
        <style>
          .heading {
            padding: 2px;
            /* Add padding as desired */
          }

          .page-content {
            display: flex;
            flex-wrap: wrap;
          }

          .col-sm-8 {
            width: 50%;
            margin-right: 0;
          }

          .col-sm-4 {
            width: 20%;
            /* Set the width to 50% for both columns */
          }

          @media (max-width: 768px) {
            .col-sm-8 {
              width: 100%;
              /* Use the full width on smaller screens */
            }

            .col-sm-4 {
              display: none;
              /* Hide the 20% column on smaller screens */
            }
          }


          /* Rest of your CSS rules */
        </style>
        <fieldset>
          <div class="form-group col-sm-12 d-flex justify-content-between">
            <div>
              <label> Amount</label>
              <?php if (!empty($payment_amount)) {
                echo '<input type="number" class="form-control w-auto" name="amount" value="' . $payment_amount . '" >';
                echo '<input type="hidden" name="subject" value="installment">';
              } else {
                echo '<input type="number" class="form-control w-auto" name="amount">';
                echo '<input type="hidden" name="subject" value="fund">';
              } ?>
            </div>
            <div>
              <p>Booking Amount Remaining</p>
              <p class="h4">Rs <?= $amount_due?></p>
            </div>
          </div>

          <div class="form-group col-sm-12">
            <label> Payment Mode </label>
            <select class='form-select cash' name="mode" class="form-control" id="sel1">
              <option value="UPI">UPI</option>
              <option value="Card">Credit/Debit Card</option>
              <option value="NEFT">NEFT</option>
              <option value="RTGS">RTGS</option>
              <option value="IMPS">IMPS</option>
              <option value="Cash Deposit">Cash Deposit</option>
              <option value="ByCash"> ByCash</option>
              <option value="Other">Other</option>
            </select>
          </div>

          <div class="form-group col-sm-12 utr">
            <label class='name'> Bank Name</label>
            <select class='form-select cash' name="mode" class="form-control" id="sel1">
              <option value="State Bank of India">State Bank of India</option>
              <option value="HDFC Bank">HDFC Bank</option>
              <option value="ICICI Bank">ICICI Bank</option>
              <option value="Punjab National Bank">Punjab National Bank</option>
              <option value="Bank of Baroda"> Bank of Baroda</option>
              <option value="Axis Bank">Axis Bank</option>
              <option value="Others">Others</option>
            </select>

            <!-- <input type="text" class="form-control" name="bank_name" value="<?php if (!empty($_POST['bank_name'])) {
                                                                                    echo $_POST['bank_name'];
                                                                                  }  ?>"> -->


          </div>
          <!--<div class="form-group col-sm-12">
            <label>Bank branch</label>
              <input type="text" class="form-control"  name="bank_branch" value="<?php if (!empty($_POST['bank_branch'])) {
                                                                                    echo $_POST[')bank_branch'];
                                                                                  }  ?>" >
          </div>-->
          <div class="form-group col-sm-12 utr">
            <label class='one'> Reference Number</label>
            <input type="text" class="form-control" name="neft">
          </div>
          <div class="form-group col-sm-12 utr">
            <label class='two'>Image</label>
            <input class="form-control" type="file" name="image" value="<?php if (!empty($_POST['file'])) {
                                                                          echo $_POST['file'];
                                                                        }  ?>">
          </div>



          <div class="form-group col-sm-12">
            <label>Description</label>
            <textarea class="form-control" required="required" name="description" value="<?php if (!empty($_POST['description'])) {
                                                                                            echo $_POST['description'];
                                                                                          }  ?>"></textarea>
          </div>

          <div class="col-lg-12 col-md-12" style="padding-top: 20px;">
            <div class="form-group">
              <button class="btn btn-primary" type="submit">Upload</button> &nbsp;
            </div>
          </div>
        </fieldset>
      </div>
    </div>
  </div>
  <!-- / -->
  <div class="col-sm-8">
    <div class="page-heading" style="text-align: center;">
      <h2>Pay Here</h2>
    </div>
    <div style="display: flex; flex-wrap: wrap; flex-direction: column; align-items: center;">
      <div class="p-3" style="display: flex; flex-direction: column; align-items: center;">
        <img src="/images/tarvmax_qr_code.jpeg" alt="" width="200px" style="background-color: grey; display: block;">
        <img src="/images/travmax_vpa.jpeg" alt="" width="200px" style="background-color: grey; display: block; margin-top: 10px;">
      </div>
      <div class="p-2" style="text-align: center;">
        <h5>Travmax Holidays (Current Account)</h5>
        <h5>Account No: 2221238344613985</h5>
        <h5>Bank Name: AU Small Finance Bank</h5>
        <h5>IFSC: AUBL0002383</h5>
        <h5>Branch: Sector 8, Chandigarh</h5>
      </div>

    </div>
  </div>



</div>






<?php echo form_close(); ?>
<script src="http://cdn.tinymce.com/4/tinymce.min.js"></script>


<script>
  tinymce.init({
    selector: '.textarea-editor',
    browser_spellcheck: true
  });
  jQuery('.cash').change(function() {

    var cash = jQuery(this).val();
    if (cash == 'ByCash') {
      jQuery('.utr').hide();

    } else {

      jQuery('.utr').show();
    }

  });
</script>