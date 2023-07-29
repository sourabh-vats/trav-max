<hr>
<div class="page-heading">
  <h2>Travel Money</h2>
</div>
<?php
//flash messages
$session = session();
?>
<div class="col-md-12 col-sm-12 martintb">
            <div class="table-responsive">
                <div>
                    <table cellspacing="0" rules="all" class="table table-bordered table-striped" border="1" id="ContentPlaceHolder1_GridView1" style="border-collapse:collapse;width: 100%">
                        <tbody>
                            <tr>
                                <th scope="col">S.No</th>
                                <th scope="col">Trav ID</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Partner Trav ID</th>
                                <th scope="col">Partner</th>
                                <th scope="col">DOJ</th>
                            </tr>
                            <?php $no_user_found = 'true';
                            if (!empty($travmoney)) { 
                                $i = 1;
                                $no_user_found = 'false';
                                foreach ($travmoney as $money) {

                                    echo '<tr align="center"><td>' . $i . '</td><td>';
                                    echo $money->user_id . '<!--/a--></td><td>' . $money->amount . '</td>';

                                    echo '<td>' . $money->user_send_by . '</td><td>' . $money->f_name . '</td><td>' . date('d F Y', strtotime($money->rdate)) . '</td></tr>';
                                    $i++;
                      
                                }
                            }
                            if ($no_user_found == 'true') {
                                echo '<tr><td colspan="9">No user found</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><span id="ContentPlaceHolder1_Label2" style="color:Red;font-weight:bold;display: none;"></span>
    </div>
<script src="http://cdn.tinymce.com/4/tinymce.min.js"></script>
