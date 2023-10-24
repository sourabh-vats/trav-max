<div class="page-heading">
    <h2>Reward</h2>
</div>
<style>
    td {
        text-align: center;
    }
</style>
<div class="table-responsive">
    <table id="example" class="table table-bordered table-hover category-table">
        <thead>
            <tr>
                <th>Sr. No.</th>
                <th>Transaction ID</th>
                <th>Amount</th>
                <th>Type</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            foreach ($rewards as $reward) {
                echo '<tr>';
                echo '<td>'.$i.'</td>';
                echo '<td>'.$reward["transaction_id"].'</td>';
                echo '<td>'.$reward["amount"].'</td>';
                echo '<td>'.$reward["transaction_type"].'</td>';
                echo '</tr>';
                $i++;
            }
            ?>
        </tbody>
    </table>
</div>