<?php
if (isset($_SESSION['upgrade']) && $_SESSION['upgrade'] === true) {
    echo '<div class="alert alert-success">You have successfully upgraded your account and became a partner.</div>';

    unset($_SESSION['upgrade']);
}
?>

<style>
    .heading {
        color: #326495;
        font-weight: 700;
    }

    .highlight {
        color: #326495;
    }
</style>

<div class="container">
    <div class="row d-flex justify-content-center flex-wrap">
        <div class="col-md-6 p-3 p-md-5 border-end text-center">
            <h2 class="heading">Congratulations!</h2>
            <br>
            <h4>You have selected <span class="highlight"><?= $package_name ?></span> Package for <span class="highlight">Rs. <?= $total ?></span>
                <?php if ($booking_packages_number > 1) {
                    echo ' per person for <span class="highlight">' . $booking_packages_number . ' persons</span>';
                } ?> and have taken the <span class="highlight"><?= $plan ?></span>.
                Please make a payment of <span class="highlight">Rs. <?= $payment_amount ?> (<?= $total . ' * ' . $booking_packages_number ?>)</span>
                and share the proof with us</h4>
            <img src="/images/travel_img.jpeg" alt="" class="img-fluid" style="background-color: grey;">
        </div>

        <div class="col-md-6 p-3 p-md-5 text-center">
            <h2 class="heading">Pay Here</h2>
            <br>
            <div class="d-flex justify-content-around">
                <div class="p-3">
                    <img src="/images/tarvmax_qr_code.jpeg" alt="" class="img-fluid" style="background-color: grey; display: block;">
                    <img src="/images/travmax_vpa.jpeg" alt="" class="img-fluid" style="background-color: grey; display: block; margin-top: 10px;">
                </div>
                <div class="p-3">
                    <h5>Travmax Holidays (Current Account)</h5>
                    <h5>Account No: 2221238344613985</h5>
                    <h5>Bank Name: AU Small Finance Bank</h5>
                    <h5>IFSC: AUBL0002383</h5>
                    <h5>Branch: Sector 8, Chandigarh</h5>
                </div>
            </div>
        </div>
        <p class="text-center">If you have made the payment via any mode, please click on upload proof.</p>
        <div class="d-flex flex-column flex-md-row justify-content-center gap-2 mb-3">
            <a class="btn btn-primary" href="/admin/request-fund">Upload Proof</a>
            <a class="btn btn-primary" href="/admin">Dashboard</a>
            <a class="btn btn-success" href="https://wa.me/9216003333"><i class="bi-whatsapp me-2"></i>WhatsApp</a>
        </div>
    </div>
</div>
