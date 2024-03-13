<?php if ($partnership['role'] == "partner") {
    $role = 'Pending';
} else if ($partnership['role'] == "micro") {
    $role = 'Free';
} else if ($partnership['role'] == "macro") {
    $role = 'Pax 5';
} else {
    $role = "Pax " . substr($partnership['role'], -2, -1);
}
$partnership['role'] = $role;
?>
<div class="page-heading">
    <h2>Travel Center</h2>
    <p>Here you can see how much you have earned for your travel.</p>
</div>
<div id="travel-center-top-section" class="row align-items-center">
    <img class="img-fluid col-md-5 mb-md-3" src="/images/<?php echo $partnership["name"]; ?>.jpg" alt="">
    <div class="col">
        <h3>Booking Details:</h3>
        <h4>Package Name:<strong> <?php echo $partnership["name"]; ?></strong></h4>
        <h4>Price Per Person:<strong> Rs. <?php echo $partnership["total"]; ?></strong> +taxes</h4>
        <h4>Partnership:<strong> <?php echo $partnership["role"]; ?></strong></h4>
        <h4>Toal Cost for <?php echo $partnership["role"]; ?>: <strong>Rs. <?php echo $partnership["total"] * substr($partnership["role"],-1); ?></strong> +taxes</h4>
        <h4>Payment Plan:<strong> <?php echo $partnership["plan"]; ?></strong></h4>
        <h4>Booking Amount:<strong> Rs.<?php echo 11000 * substr($partnership["role"],-1) ?></strong></h4>
    </div>
</div>
<?php if ($incomes) { ?>
    <div class="col-md-12 col-sm-12 martintb table-hover">
        <div class="table-responsive table-scroll" data-mdb-perfect-scrollbar="true" style="position: relative; height: 700px">
            <table class="table table-striped mb-0">
                <thead style="background-color: #002d72;">
                    <tr>
                        <th scope="col">Sr. No.</th>
                        <th scope="col">Date</th>
                        <th scope="col">Booking Amount</th>
                        <th scope="col">Earned Amount</th>
                        <th scope="col">Due Amount</th>
                        <th scope="col">Type</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $due = $partnership["total"] - 11000;
                    foreach ($incomes as $income) {
                        $due = $due - $income["travel_center_income"];
                        echo '<tr>';
                        echo '<td>' . $i . '</td>';
                        echo '<td>' . date_format(new DateTime($income['income_date']),"D, d M Y") . '</td>';
                        echo '<td>Rs.' . '11000' . '</td>';
                        echo '<td>Rs.' . $income["travel_center_income"] . '</td>';
                        echo '<td>Rs.' . $due . '</td>';
                        echo '<td>' . ucfirst($income["income_type"]) . '</td>';
                        echo '<td>' . ucfirst($income["income_status"]) . '</td>';
                        echo '</tr>';
                        $i++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
<?php } ?>