<?php require_once 'App/Views/templates/partials/header.php'; ?>

<body>
<div id="preloder">
    <div class="loader"></div>
</div>

<?php require_once 'App/Views/templates/partials/navbar-advert.php'; ?>
<?php if($flashBag): ?>
    <?php require_once 'App/Views/templates/partials/flashbag.php'; ?>
<?php endif; ?>


<?= $content; ?>

<?php require_once 'App/Views/templates/partials/footer.php'; ?>

</body>
