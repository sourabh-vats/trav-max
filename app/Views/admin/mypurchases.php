<div class="page-heading">
    <h2>Partnership</h2>
</div>
<div id="partner_section" class="d-flex justify-content-between flex-wrap text-light">
    <div class="col-12 col-md-3 border p-3 shadow bg-primary">
        <h4>Package: </h4>
        <h3><strong><?= $partnership["package"] ?></strong></h3>
    </div>
    <div class="col-12 col-md-3 border p-3 shadow bg-primary">
        <h4>Partnership: </h4>
        <?php if ($partnership["type"] == "macro") : ?>
            <h3><strong>Pax 5</strong></h3>
        <?php else : ?>
        <h3><strong><?= "Pax " . substr($partnership["type"], -2, -1) ?></strong></h3>
        <?php endif; ?>
    </div>
    <div class="col-12 col-md-3 border p-3 shadow bg-primary">
        <h4>Plan: </h4>
        <h3><strong><?= $partnership["plan"] ?></strong></h3>
    </div>
</div>

<div class="page-heading mt-5">
    <h2>Purchases</h2>
</div>
<div class="col-md-12 col-sm-12 martintb table-hover">
    <div class="table-responsive table-scroll" data-mdb-perfect-scrollbar="true" style="position: relative; height: 700px">
        <table class="table table-striped mb-0">
            <thead style="background-color: #002d72;">
                <tr>
                    <th scope="col">Sr. No.</th>
                    <th scope="col">Date</th>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Booking Amount</th>
                    <th scope="col">Status</th> 
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($purchases as $purchase) : ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= date_format(new DateTime($purchase['purchase_date']),"D, d M Y"); ?></td>
                        <td><?= $purchase['package_name']; ?></td>
                        <td>Rs.<?= $purchase['total_amount']; ?></td>
                        <td>Rs.11000</td>
                        <td><?= ucfirst($purchase['purchase_status']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    if($("#user_role") == "micro"){
        $("#partner_section").hide();
    }
</script>