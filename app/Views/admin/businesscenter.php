<div class="page-heading">
    <h2>Business Center</h2>
    <p>These are your earnings which you can withdraw.</p>
</div>
<?php if ($incomes) { ?>
    <div class="col-md-12 col-sm-12 martintb table-hover">
        <div class="table-responsive table-scroll" data-mdb-perfect-scrollbar="true" style="position: relative; height: 700px">
            <table class="table table-striped mb-0">
                <thead style="background-color: #002d72;">
                    <tr>
                        <th scope="col">Sr. No.</th>
                        <th scope="col">Date</th>
                        <th scope="col">Type</th>
                        <th scope="col">Earned Amount</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($incomes as $income) {
                        echo '<tr>';
                        echo '<td>' . $i . '</td>';
                        echo '<td>' . date_format(new DateTime($income['income_date']), "D, d M Y") . '</td>';
                        echo '<td>' . ucfirst($income["income_type"]) . '</td>';
                        echo '<td>Rs.' . $income["travel_center_income"] . '</td>';
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