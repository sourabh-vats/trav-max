<div class="row gap-4 mb-5">
    <div class="col-md">
        <div class="row mb-4 gradient_parent">
            <div class="col text-center py-4">
                <h3 class="d-flex align-items-start justify-content-center">Total Income</h3>
                <span class="box_number_data">₹ <?php echo $total_income; ?></span>
            </div>
            <div class="col text-center py-4">
                <h3 class="d-flex align-items-start justify-content-center">Total Sales</h3>
                <span class="box_number_data"><?php echo $total_sales; ?></span>
            </div>
        </div>
        <div class="row gradient_parent">
            <div class="col text-center py-4">
                <a href="/admin/mysales">
                    <h3>MY SALES</h3>
                    <span class="box_number_data"><?php echo $my_sales; ?></span>
                </a>
            </div>
            <div class="col text-center py-4">
                <a href="/admin/teamsales">
                    <h3>TEAM SALES</h3>
                    <span class="box_number_data"><?php echo $team_sales; ?></span>
                </a>
            </div>
        </div>
    </div>
    <div class="col-md">
        <div class="row mb-4 gradient_parent">
            <div class="col text-center py-4">
                <a href="/admin/travelcenter">
                    <h3>TRAVEL CENTER</h3>
                    <span class="box_number_data">₹<?php echo round($travel_center_income, 0); ?></span>
                </a>
            </div>
            <div class="col text-center py-4">
                <a href="/admin/businesscenter">
                    <h3>BUSINESS CENTER</h3>
                    <span class="box_number_data">₹<?php echo round($business_center_income, 0); ?></span>
                </a>
            </div>
        </div>
        <div class="row gradient_parent">
            <div class="col text-center py-4">
                <a href="/admin/myincome">
                    <h3>MY INCOME</h3>
                    <span class="box_number_data">₹<?php echo (int)$direct_income; ?></span>
                </a>
            </div>
            <div class="col text-center py-4">
                <a href="/admin/teamincome">
                    <h3>TEAM INCOME</h3>
                    <span class="box_number_data">₹<?php echo $team_income; ?></span>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="row gap-5">
    <div class="col-md px-0">
        <div class="mb-4 col-md-12">
            <div class="h-100 card">
                <div class="d-flex align-items-center card-body">
                    <div class="gy-5 flex-fill row">
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="text-lg col-sm-2">
                                    <i class="bi bi-cash-coin text-success" style="font-size:30px"></i>
                                </div>
                                <div class="col-sm-10">
                                    <h2>Rs. <?= $amount_due ?></h2>
                                    <h6 class="text-muted fw-normal p-b-20 p-t-10">Remaining to Pay</h6>
                                    <div class="progress">
                                        <div role="progressbar" class="progress-bar bg-success" style="width:<?= $amount_due_percentage ?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="text-lg col-sm-2">
                                    <i class="bi bi-calendar-date text-danger" style="font-size:30px"></i>
                                </div>
                                <div class="col-sm-10">
                                    <?php if ($remaining_days > 0) { ?>
                                        <h2><?= $remaining_days ?> Days</h2>
                                    <?php } else { ?>
                                        <h2>Overdue</h2>
                                    <?php }; ?>
                                    <h6 class="text-muted fw-normal p-b-20 p-t-10">Left To Due Date</h6>
                                    <div class="progress">
                                        <div role="progressbar" class="progress-bar bg-danger" style="width:<?= $remaining_days_percentage ?>%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mx-0 mx-md-auto mb-md-2">
            <div class="col-auto border-end" id="hero_total_sales">
                <span class="big_number"><?php echo $total_sales; ?></span>
                <span class="big_number_title">Total Sales</span>
            </div>
            <div class="col" id="hero_total_income">
                <span class="big_number">₹ <?php echo $total_income; ?></span>
                <span class="big_number_title">Total Income</span>
            </div>
        </div>
        <hr>
        <div class="row container align-items-center mt-md-2">
            <div class="col">
                <span id="total_partners_number"><i class="bi-people-fill me-2"></i><?php echo $my_partners; ?></span>
            </div>
            <div class="col text-end">
                <a href="/admin/DistributorLevelInformation" class="my_partners_hero_link">MY PARTNERS<i class="bi-arrow-right-circle-fill ms-2"></i></a>
            </div>
        </div>
        <div class="row container align-items-center mt-md-2">
            <div class="col">
                <span id="total_purchases"><i class="bi-bag-check-fill me-2"></i><?php echo $total_purchases; ?></span>
            </div>
            <div class="col text-end">
                <a href="/admin/mypurchases" class="my_partners_hero_link">MY PURCHASES<i class="bi-arrow-right-circle-fill ms-2"></i></a>
            </div>
        </div>
    </div>
    <div class="col-md grey_bg px-4 py-4">
        <p class="text_1">Total Income</p>
        <hr>
        <div class="box_content">
            <p class="text_3">Total Income : <span>₹ <?php echo (int)$total_income; ?></p>
            <p class="text_3">My Income : <span>₹ <?php echo (int)$direct_income; ?></p>
            <p class="text_3">Team Income : <span>₹ <?php echo (int)$team_income; ?></p>
            <p class="text_3">Pending Income : <span>₹ <?php echo (int)$pending_income; ?></p>
            <p class="text_3">Reward : <span>₹ <?php echo $wallet["reward"]; ?></p>
            <p class="text_3">Bonus : <span>₹ <?php echo $wallet["bonus"]; ?></p>
            <p class="text_3">Moneyback : <span>₹ <?php echo $wallet["moneyback"]; ?></p>
            <p class="text_3">Cashback : <span>₹ <?php echo $wallet["cashback"]; ?></p>
        </div>
    </div>
</div>