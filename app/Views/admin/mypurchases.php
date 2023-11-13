<div class="page-heading">
    <h2>Partnership</h2>
</div>
<div id="partner_section" class="d-flex justify-content-around flex-wrap text-center text-light">
    <div class="col-12 col-md-3 border p-3 shadow bg-primary">
        <h3>Package: </h3>
        <h3><strong><?= $partnership["package"] ?></strong></h3>
    </div>
    <div class="col-12 col-md-3 border p-3 shadow bg-primary">
        <h3>Partnership: </h3>
        <h3><strong><?= $partnership["type"] ?></strong></h3>
    </div>
    <div class="col-12 col-md-3 border p-3 shadow bg-primary">
        <h3>Plan: </h3>
        <h3><strong><?= $partnership["plan"] ?></strong></h3>
    </div>
</div>

<div class="page-heading mt-5">
    <h2>Purchases</h2>
</div>

<script>
    if($("#user_role") == "micro"){
        $("#partner_section").hide();
    }
</script>