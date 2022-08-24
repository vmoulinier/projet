<header class="header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="header__logo">
                    <a href="<?= $this->router->generate('index') ?>"><img src="<?= PATH ?>/Public/img/logo_OD.png" alt="" width="60px">
                        <?php if(!$this->twig->isMobile()):?><span>Occasion-</span>Dentaire<span>.com</span><?php endif; ?>
                    </a>
                </div>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="header__nav">
                    <nav class="header__menu mobile-menu">
                        <ul>
                            <li class="mr-0">
                                <a href="<?= $this->router->generate('home_lang', ['id' => 1]) ?>">
                                    <span class="flag-icon flag-icon-fr"></span>
                                </a>
                            </li>
                            <li class="mr-4">
                                <a href="<?= $this->router->generate('home_lang', ['id' => 2]) ?>">
                                    <span class="flag-icon flag-icon-gb"></span>
                                </a>
                            </li>
                            <li class="<?php if(empty($_GET)): ?>active<?php endif; ?>"><a href="<?= $this->router->generate('index') ?>"><?= $this->twig->translation('home.index') ?></a></li>
                            <li class="<?= $this->twig->isNavActive(['advert', 'request']) ?>"><a href="<?= $this->router->generate('advert_index') ?>"><?= $this->twig->translation('advert.index') ?></a>
                                <ul class="dropdown">
                                    <li><a href="<?= $this->router->generate('advert_index') ?>"><?= $this->twig->translation('advert.list.advert') ?></a></li>
                                    <li><a href="#"><?= $this->twig->translation('advert.list.ask') ?></a></li>
                                    <li><a href="#"><?= $this->twig->translation('advert.latest.sales') ?></a></li>
                                </ul>
                            </li>
                            <li><a href="#"><?= $this->twig->translation('home.help') ?></a>
                                <ul class="dropdown">
                                    <li><a href="<?= $this->router->generate('home_terms') ?>"><?= $this->twig->translation('footer.terms') ?></a></li>
                                    <li><a href="#"><?= $this->twig->translation('footer.privacy.policy') ?></a></li>
                                    <li><a href="<?= $this->router->generate('home_about') ?>"><?= $this->twig->translation('help.transaction') ?></a></li>
                                    <li><a href="#"><?= $this->twig->translation('home.faq') ?></a></li>
                                </ul>
                            </li>
                            <li class="<?= $this->twig->isNavActive(['contact']) ?>"><a href="<?= $this->router->generate('home_contact') ?>"><?= $this->twig->translation('home.contact') ?></a></li>
                            <li><a href="<?= $this->router->generate('admin_index') ?>"><?= $this->twig->translation('home.admin') ?></a></li>
                        </ul>
                    </nav>
                    <div class="header__menu__right">
                        <a href="<?= $this->router->generate('user_profil') ?>" class="login-btn"><i class="fa fa-user mt-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div id="mobile-menu-wrap"></div>
    </div>
</header>