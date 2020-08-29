<div class="container">
    <div class="row">
        <div class="col-8 offset-2">
            <div id="flashbag-user" class="alert alert-<?= $flashBag[1]; ?>">
                <?= $flashBag[0]; ?>
            </div>
        </div>
    </div>
</div>

<script>
    $("#flashbag-user").delay(5000).fadeOut(1500);
</script>
