<div class="page-heading">
    <h2>My Income</h2>
</div>
<style>
    td {
        text-align: center;
    }
</style>
<div class="col-md-12 col-sm-12 martintb table-hover">
    <div class="table-responsive table-scroll" data-mdb-perfect-scrollbar="true" style="position: relative; height: 700px">
        <table class="table table-striped mb-0">
            <thead style="background-color: #002d72;">
                <tr>
                    <th scope="col">Sr. No.</th>
                    <th scope="col">Date</th>
                    <th scope="col">Product</th>
                    <th scope="col">Name</th>
                    <th scope="col">Trav ID</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($my_incomes as $income) : ?>
                    <?php if ($income['product_type'] == "partner") {
                        $product = 'Pending';
                    } else if ($income['product_type'] == "micro") {
                        $product = 'Free';
                    } else if ($income['product_type'] == "macro") {
                        $product = 'Pax 5';
                    } else {
                        $product = "Pax " . substr($income['product_type'], -2, -1);
                    }
                    ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= date_format(new DateTime($income['income_date']),"D, d M Y"); ?></td>
                        <td><?= $product; ?></td>
                        <td><?= $income['from_name']; ?></td>
                        <td><?= $income['from_id']; ?></td>
                        <td>Rs.<?= $income['income_amount']; ?></td>
                        <td><?= $income['income_status']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>