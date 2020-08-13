<?php require_once 'App/Views/templates/partials/header.php'; ?>

<body>
<div id="preloder">
    <div class="loader"></div>
</div>

<?php require_once 'App/Views/templates/partials/navbar-user.php'; ?>
<?php if($flashBag): ?>
    <?php require_once 'App/Views/templates/partials/flashbag.php'; ?>
<?php endif; ?>

<section class="spad-xl">
    <div class="container">
        <ul id="subscription-nav">
            <li class="<?php if($this->twig->isNavActive(['creation'])): ?>active<?php endif; ?>">
                1
                <div class="step-name"><?= $this->twig->translation('step.creation') ?></div>
            </li>
            <li class="separator"></li>
            <li class="<?php if($this->twig->isNavActive(['validation'])): ?>active<?php endif; ?>">
                2
                <div class="step-name"><?= $this->twig->translation('step.validation') ?></div>
            </li>
            <li class="separator"></li>
            <li class="<?php if($this->twig->isNavActive(['summary'])): ?>active<?php endif; ?>">
                3
                <div class="step-name"><?= $this->twig->translation('step.summary') ?></div>
            </li>
            <li class="separator"></li>
            <li class="align-content-center">
                <div class="fas fa-check fa-2x mt-3"></div>
                <div class="step-name"></div>
            </li>
        </ul>
        <?= $content; ?>
    </div>
</section>


<?php require_once 'App/Views/templates/partials/footer.php'; ?>

</body>
