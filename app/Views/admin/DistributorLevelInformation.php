<div class="page-heading">
    <h2>My Partners</h2>
</div>

<?php
helper('form');
$request = \Config\Services::request();
//flash messages
$session = session();
if ($session->getFlashdata('flash_message')) {
    if ($session->getFlashdata('flash_message') == 'updated') {
        echo '<div class="alert alert-success">';
        echo '<a class="close" data-dismiss="alert">×</a>';
        echo '<strong>Well done!</strong> order updated with success.';
        echo '</div>';
    } else {
        echo '<div class="alert alert-danger">';
        echo '<a class="close" data-dismiss="alert">×</a>';
        echo '<strong>Oh snap!</strong> change a few things up and try submitting again.';
        echo '</div>';
    }
}
//print_r($restaurants);
?>
<?php
//form data
$attributes = array('class' => 'form form-inline', 'id' => '');

//form validation
// echo validation_errors();
//print_r($editor);

//echo form_open('admin/category/', $attributes);
?><div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="row">
            <div class="col-md-5">
                <strong><div class="form-group"><label class="control-label " style="text-dec;">Trav ID :  </label></strong><?php echo " ".$profile[0]['customer_id']; ?>
                    
                </div>
            </div>
            <div class="col-md-5">
                <strong><div class="form-group"><label class="control-label ">Parent Trav ID : </label></strong><?php echo " ".$profile[0]['parent_customer_id']; ?>
                    <div class="col-md-6"><span id="ContentPlaceHolder1_lblsponserid" class="form-control" style="font-weight: bold; font-size: 12px; border: none;"></span></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-5">
                <strong><div class="form-group"><label class="control-label">Partner Name : </label></strong><?php echo " ".$profile[0]['f_name'] . ' ' . $profile[0]['l_name']; ?>
                    <div class="col-md-6"><span id="ContentPlaceHolder1_txtName" class="form-control" style="font-weight: bold;                                    font-size: 12px; border: none;"></span></div>
                </div>
            </div>
            <div class="col-md-5">
                <strong><div class="form-group"><label class="control-label">Parent Name : </label></strong><?php if (!empty($parent_profile)) {
                                                                                                                                                                        echo " ".$parent_profile[0]['f_name'] . ' ' . $parent_profile[0]['l_name'];
                                                                                                                                                                    } ?>
                    <div class="col-md-6"><span id="ContentPlaceHolder1_txtUpName" class="form-control" style="font-weight: bold;font-size: 12px; border: none;"></span></div>
                </div>
            </div>
        </div>

        <h2 class="page-title">Team</h2>

        <!--<div id="ContentPlaceHolder1_List">
	  <div class="controls-row">
	  <h1 class="page-title"><span id="ContentPlaceHolder1_LevelNo">Details Of: <?php echo $current_user; ?></span> 
	  <?php if ($show_inner == 'true') {
            echo '<a class="btn btn-primary flr" href="' . base_url() . 'admin/DistributorLevelInformation">Back</a>';
        } ?></h1>
	  </div>
	  </div>-->
        <div class="col-md-12 col-sm-12 martintb">
            <div class="table-responsive">
                <div>
                    <table cellspacing="0" rules="all" class="table table-bordered table-striped" border="1" id="ContentPlaceHolder1_GridView1" style="border-collapse:collapse;width: 100%">
                        <tbody>
                            <tr>
                                <th scope="col">S.No</th>
                                <th scope="col">Trav ID</th>
                                <th scope="col">Partner Name</th>
                                <th scope="col">Parent Trav ID</th>
                                <th scope="col">Partner</th>
                                <th scope="col">DOJ</th>
                            </tr>
                            <?php $no_user_found = 'true';
                            if (!empty($myfriends)) { //echo '<pre>'; print_r($myfriends); echo '</pre>';
                                $i = 1;
                                $no_user_found = 'false';
                                foreach ($myfriends as $friend) {

                                    if ($friend['macro'] > 0) {
                                        $status = 'Macro';
                                    } else {
                                        $status = 'Micro';
                                    }
                                    echo '<tr align="center"><td>' . $i . '</td><td>';
                                    //echo '<a href="'.base_url().'admin/DistributorLevelInformation/'.$friend['customer_id'].'">';
                                    echo $friend['customer_id'] . '<!--/a--></td><td>' . $friend['f_name'] . ' ' . $friend['l_name'] . '</td>';

                                    echo '<td>' . $friend['direct_customer_id'] . '</td><td>' . $friend['role'] . '</td><td>' . date('d F Y', strtotime($friend['rdate'])) . '</td></tr>';
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
    <div class="wrap-table100">
<div class="table100">
<table>
<thead>
<tr class="table100-head">
<th class="column1">Date</th>
<th class="column2">Order ID</th>
<th class="column3">Name</th>
<th class="column4">Price</th>
<th class="column5">Quantity</th>
<th class="column6">Total</th>
</tr>
</thead>
<tbody>
<tr>
<td class="column1">2017-09-29 01:22</td>
<td class="column2">200398</td>
<td class="column3">iPhone X 64Gb Grey</td>
<td class="column4">$999.00</td>
<td class="column5">1</td>
<td class="column6">$999.00</td>
</tr>
<tr>
<td class="column1">2017-09-28 05:57</td>
<td class="column2">200397</td>
<td class="column3">Samsung S8 Black</td>
<td class="column4">$756.00</td>
<td class="column5">1</td>
<td class="column6">$756.00</td>
</tr>
<tr>
<td class="column1">2017-09-26 05:57</td>
<td class="column2">200396</td>
<td class="column3">Game Console Controller</td>
<td class="column4">$22.00</td>
<td class="column5">2</td>
<td class="column6">$44.00</td>
</tr>
<tr>
<td class="column1">2017-09-25 23:06</td>
<td class="column2">200392</td>
<td class="column3">USB 3.0 Cable</td>
<td class="column4">$10.00</td>
<td class="column5">3</td>
<td class="column6">$30.00</td>
</tr>
<tr>
<td class="column1">2017-09-24 05:57</td>
<td class="column2">200391</td>
<td class="column3">Smartwatch 4.0 LTE Wifi</td>
<td class="column4">$199.00</td>
<td class="column5">6</td>
<td class="column6">$1494.00</td>
</tr>
<tr>
<td class="column1">2017-09-23 05:57</td>
<td class="column2">200390</td>
<td class="column3">Camera C430W 4k</td>
<td class="column4">$699.00</td>
<td class="column5">1</td>
<td class="column6">$699.00</td>
</tr>
<tr>
<td class="column1">2017-09-22 05:57</td>
<td class="column2">200389</td>
<td class="column3">Macbook Pro Retina 2017</td>
<td class="column4">$2199.00</td>
<td class="column5">1</td>
<td class="column6">$2199.00</td>
</tr>
<tr>
<td class="column1">2017-09-21 05:57</td>
<td class="column2">200388</td>
<td class="column3">Game Console Controller</td>
<td class="column4">$999.00</td>
<td class="column5">1</td>
<td class="column6">$999.00</td>
</tr>
<tr>
<td class="column1">2017-09-19 05:57</td>
<td class="column2">200387</td>
<td class="column3">iPhone X 64Gb Grey</td>
<td class="column4">$999.00</td>
<td class="column5">1</td>
<td class="column6">$999.00</td>
</tr>
<tr>
<td class="column1">2017-09-18 05:57</td>
<td class="column2">200386</td>
<td class="column3">iPhone X 64Gb Grey</td>
<td class="column4">$999.00</td>
<td class="column5">1</td>
<td class="column6">$999.00</td>
</tr>
<tr>
<td class="column1">2017-09-22 05:57</td>
<td class="column2">200389</td>
<td class="column3">Macbook Pro Retina 2017</td>
<td class="column4">$2199.00</td>
<td class="column5">1</td>
<td class="column6">$2199.00</td>
</tr>
<tr>
<td class="column1">2017-09-21 05:57</td>
<td class="column2">200388</td>
<td class="column3">Game Console Controller</td>
<td class="column4">$999.00</td>
<td class="column5">1</td>
<td class="column6">$999.00</td>
</tr>
<tr>
<td class="column1">2017-09-19 05:57</td>
<td class="column2">200387</td>
<td class="column3">iPhone X 64Gb Grey</td>
<td class="column4">$999.00</td>
<td class="column5">1</td>
<td class="column6">$999.00</td>
</tr>
<tr>
<td class="column1">2017-09-18 05:57</td>
<td class="column2">200386</td>
<td class="column3">iPhone X 64Gb Grey</td>
<td class="column4">$999.00</td>
<td class="column5">1</td>
<td class="column6">$999.00</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
<?php //echo form_close(); 
?>