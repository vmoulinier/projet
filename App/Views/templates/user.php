<?php require_once 'App/Views/templates/partials/header.php'; ?>

<body>
<div id="preloder">
    <div class="loader"></div>
</div>

<?php require_once 'App/Views/templates/partials/navbar-user.php'; ?>

<div class="container user-container">
    <div class="row">
        <?php if($this->twig->isMobile()):?>
        <div class="col-md-3">
            <ul class="nav nav-pills nav-fill p-2">
                <li class="nav-item">
                    <a class="nav-link primary-btn" href="#">Active</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
            </ul>
        </div>
        <?php else: ?>
            <?php if($this->twig->logged()):?>
                <div class="col-md-3">
                    <div class="list-group mb-2">
                        <a class="list-group-item list-group-item-action <?= $this->twig->isNavActive(['profil', 'edit_profil']) ?>" href="<?= $this->router->generate('user_profil') ?>">
                            <?= $this->twig->translation('user.nav.profil') ?>
                        </a>
                        <a class="list-group-item list-group-item-action <?= $this->twig->isNavActive(['user_adverts', 'create_advert', 'edit_advert', 'user_requests', 'create_request', 'edit_request']) ?>" href="<?= $this->router->generate('user_adverts') ?>">
                            <?= $this->twig->translation('user.nav.adverts') ?>
                        </a>
                        <a class="list-group-item list-group-item-action <?= $this->twig->isNavActive(['bookmarks']) ?>" href="<?= $this->router->generate('user_bookmarks') ?>">
                            <?= $this->twig->translation('user.nav.bookmarks') ?>
                        </a>
                        <a class="list-group-item list-group-item-action <?= $this->twig->isNavActive(['user_transactions']) ?>" href="<?= $this->router->generate('user_transactions') ?>">
                            <?= $this->twig->translation('user.nav.transactions') ?>
                        </a>
                        <a class="list-group-item list-group-item-action" href="<?= $this->router->generate('user_logout') ?>">
                            <?= $this->twig->translation('user.logout') ?>
                        </a>

                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <div class="<?php if($this->twig->logged()):?>col-md-9<?php else: ?>offset-md-1 col-md-10<?php endif; ?>">
            <?php if($flashBag): ?>
                <?php require_once 'App/Views/templates/partials/flashbag-user.php'; ?>
            <?php endif; ?>
            <div class="work__item">
                <?= $content; ?>
            </div>
        </div>
    </div>
</div>


<?php require_once 'App/Views/templates/partials/footer.php'; ?>

</body>
