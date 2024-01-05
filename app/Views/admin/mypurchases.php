<div class="page-heading">
    <h2>Partnership</h2>
</div>
<div id="partner_section" class="d-flex justify-content-between flex-wrap text-light">
    <div class="col-12 col-md-3 border p-3 shadow bg-primary">
        <h4>Package: </h4>
        <h3><strong><?= $partnership["package"] ?></strong></h3>
    </div>
    <div class="col-12 col-md-3 border p-3 shadow bg-primary">
        <h4>Partnership: </h4>
        <h3><strong><?= "Pax " . substr($partnership["type"], -2, -1) ?></strong></h3>
    </div>
    <div class="col-12 col-md-3 border p-3 shadow bg-primary">
        <h4>Plan: </h4>
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