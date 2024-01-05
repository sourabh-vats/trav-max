<div class="page-heading">
    <h2>My Sales</h2>
</div>
<div class="table-responsive table-scroll" data-mdb-perfect-scrollbar="true" style="position: relative; height: 700px">
        <table class="table table-striped mb-0">
            <thead style="background-color: #002d72;">
                <tr>
                    <th scope="col">Sr. No.</th>
                    <th scope="col">Photo</th>
                    <th scope="col">Trav ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Membership</th>
                    <th scope="col">DOJ</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($mysales as $partner) : ?>
                    <?php if ($partner['role'] == "partner") {
                        $status = 'Pending';
                    } else if ($partner['role'] == "micro") {
                        $status = 'Free';
                    } else {
                        $status = "Pax " . substr($partner['role'], -2, -1);
                    }
                    
                    if ($partner['image'] == "") {
                        $partner['image'] = 'avatar.png';
                    } else {
                        $partner['image'] = $partner['image'];
                    }
                    ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><img class="partner_img" src="<?= base_url('/images/user_profile/' . $partner['image']); ?>" width="50" height="50" /></td>
                        <td><?= $partner['customer_id']; ?></td>
                        <td><?= $partner['f_name'] . ' ' . $partner['l_name']; ?></td>
                        <td><?= $status; ?></td>
                        <td><?= $partner['rdate']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>