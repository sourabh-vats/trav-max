<div class="row gap-4 mb-5">
    <div class="col-md">
        <div class="row mb-4 gradient_parent">
            <div class="col text-center py-4">
                <a href="/admin/travelcenter">
                    <h3>MONEYBACK</h3>
                    <span class="box_number_data">₹<?php echo round($wallet["moneyback"], 0); ?></span>
                </a>
            </div>
            <div class="col text-center py-4">
                <a href="/admin/businesscenter">
                    <h3>CASHBACK</h3>
                    <span class="box_number_data">₹<?php echo round($wallet["cashback"], 0); ?></span>
                </a>
            </div>
        </div>
        <div class="row gradient_parent">
            <div class="col text-center py-4">
                <h3>BONUS</h3>
                <span class="box_number_data">₹<?php echo $wallet["bonus"]; ?></span>
            </div>
            <div class="col text-center py-4">
                <h3>REWARD</h3>
                <span class="box_number_data">₹<?php echo $wallet["reward"]; ?></span>
            </div>
        </div>
    </div>
    <div class="col-md">
        <div class="row mb-4 gradient_parent">
            <div class="col text-center py-4">
                <a href="/admin/travelcenter">
                    <h3>TRAVEL CENTER</h3>
                    <span class="box_number_data">₹<?php echo round($travmoney, 0); ?></span>
                </a>
            </div>
            <div class="col text-center py-4">
                <a href="/admin/businesscenter">
                    <h3>BUSSINESS CENTER</h3>
                    <span class="box_number_data">₹<?php echo round($travprofit, 0); ?></span>
                </a>
            </div>
        </div>
        <div class="row gradient_parent">
            <div class="col text-center py-4">
                <h3>MY INCOME</h3>
                <span class="box_number_data">₹<?php echo $active_income; ?></span>
            </div>
            <div class="col text-center py-4">
                <h3>TEAM INCOME</h3>
                <span class="box_number_data">₹<?php echo $team_income; ?></span>
            </div>
        </div>
    </div>
</div>
<div class="row gap-5">
    <div class="col-md-5 px-0">
        <div class="row mx-0 mx-md-auto mb-md-2">
            <div class="col-md-auto border-end" id="hero_total_sales">
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
                <span id="total_partners_number"><i class="bi-people-fill me-2"></i><?php echo $total_partners; ?></span>
            </div>
            <div class="col text-end">
                <a href="/admin/DistributorLevelInformation" class="my_partners_hero_link">MY PARTNERS<i class="bi-arrow-right-circle-fill ms-2"></i></a>
            </div>
        </div>
        <div class="row container align-items-center mt-md-2">
            <div class="col">
                <span id="total_partners_number"><i class="bi-bar-chart-line-fill me-2"></i><?php echo $my_sales; ?></span>
            </div>
            <div class="col text-end">
                <a href="/admin/mysales" class="my_partners_hero_link">MY SALES<i class="bi-arrow-right-circle-fill ms-2"></i></a>
            </div>
        </div>
        <div class="row container align-items-center mt-md-2">
            <div class="col">
                <span id="total_partners_number"><i class="bi-graph-up-arrow me-2"></i><?php echo $team_sales; ?></span>
            </div>
            <div class="col text-end">
                <a href="/admin/teamsales" class="my_partners_hero_link">TEAM SALES<i class="bi-arrow-right-circle-fill ms-2"></i></a>
            </div>
        </div>
    </div>
    <div class="col-md grey_bg px-4 py-4">
        <p class="text_1">My Income</p>
        <hr>
        <div class="box_content">
            <p class="text_3">Total Income : <span>₹ <?php echo $total_income; ?></p>
            <p class="text_3">Pending Income : <span>₹ <?php echo $pending_income; ?></p>
            <p class="text_3">Approved Income : <span>₹ <?php echo $approved_income; ?></p>
            <p class="text_3">Redemmed Income : <span>₹ <?php echo $redeemed_income; ?></p>
            <p class="text_3">Active Income : <span>₹ <?php echo $active_income; ?></p>
            <p class="text_3">Team Income : <span>₹ <?php echo $team_income; ?></p>
        </div>
    </div>
</div>