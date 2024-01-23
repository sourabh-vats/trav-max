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
                <strong>
                    <div class="form-group"><label class="control-label " >Trav ID : </label>
                </strong><?php echo " " . $profile[0]['customer_id']; ?>

            </div>
        </div>
        <div class="col-md-5">
            <strong>
                <div class="form-group"><label class="control-label ">Parent Trav ID : </label>
            </strong><?php echo " " . $profile[0]['parent_customer_id']; ?>
            <div class="col-md-6"><span id="ContentPlaceHolder1_lblsponserid" class="form-control" style="font-weight: bold; font-size: 12px; border: none;"></span></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-5">
        <strong>
            <div class="form-group"><label class="control-label">Partner Name : </label>
        </strong><?php echo " " . $profile[0]['f_name'] . ' ' . $profile[0]['l_name']; ?>
        <div class="col-md-6"><span id="ContentPlaceHolder1_txtName" class="form-control" style="font-weight: bold;                                    font-size: 12px; border: none;"></span></div>
    </div>
</div>
<div class="col-md-5">
    <strong>
        <div class="form-group"><label class="control-label">Parent Name : </label>
    </strong><?php if (!empty($parent_profile)) {
                    echo " " . $parent_profile[0]['f_name'] . ' ' . $parent_profile[0]['l_name'];
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
    <div class="table-responsive table-scroll" data-mdb-perfect-scrollbar="true" style="position: relative; height: 700px">
        <table class="table table-striped mb-0">
            <thead style="background-color: #002d72;">
                <tr>
                    <th scope="col">Sr. No.</th>
                    <th scope="col">Photo</th>
                    <th scope="col">Trav ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Partnership</th>
                    <th scope="col">DOJ</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($myfriends as $partner) : ?>
                    <?php if ($partner['role'] == "partner") {
                        $status = 'Pending';
                    } else if ($partner['role'] == "micro") {
                        $status = 'Free';
                    } else if ($partner['role'] == "macro") {
                        $status = 'Pax 5';
                    } else {
                        $status = "Pax " . substr($partner['role'], -2, -1);
                    }
                    ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><img class="partner_img" src="<?= base_url('/images/user_profile/' . $partner['customer_id']) . '.png'; ?>" width="50" height="50" onerror="this.src='/images/user_profile/avatar.png';" /></td>
                        <td><?= $partner['customer_id']; ?></td>
                        <td><?= $partner['f_name'] . ' ' . $partner['l_name']; ?></td>
                        <td><?= $status; ?></td>
                        <td><?= date_format(new DateTime($partner['rdate']),"D, d M Y"); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<span id="ContentPlaceHolder1_Label2" style="color:Red;font-weight:bold;display: none;"></span>
</div>
</div>
<?php //echo form_close(); 
?>