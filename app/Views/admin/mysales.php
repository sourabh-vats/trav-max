<div class="page-heading">
    <h2>My Sales</h2>
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
                <th>Trav ID</th>
                <th>Full Name</th>
                <th>Partnership</th>
                <th>Date </th>                
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            foreach ($mysales as $sale) {
                echo '<tr>';
                echo '<td>'.$i.'</td>';
                echo '<td>'.$sale["customer_id"].'</td>';
                echo '<td>'.$sale["f_name"].' '.$sale["l_name"].'</td>';
                echo '<td>'.$sale["role"].'</td>';
                echo '<td>'.$sale["rdate"].'</td>';                
                echo '</tr>';
                $i++;
            }
            ?>
        </tbody>
    </table>
</div>