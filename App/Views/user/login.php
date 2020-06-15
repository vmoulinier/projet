<section class="listing-details spad-xl">
    <h2 class="center"><?= $this->twig->translation('login.title') ?></h2>
    <br />
    <div class="row">
        <div class="col-lg-4 offset-lg-4">
            <form method="post">
                <?= $form->input('email', $this->twig->translation('login.email'), ['type' => 'email']); ?>
                <?= $form->input('password', $this->twig->translation('login.password'), ['type' => 'password']); ?>
                <?= $form->submit($this->twig->translation('login.login')); ?>
            </form>
            <a href="<?= $this->router->generate('user_login', ['fb' => 'loginfb']) ?>" class="btn-sm btn-social btn-facebook">
                <span class="fa fa-facebook"></span>
                <?= $this->twig->translation('login.facebook') ?>
            </a>
            <br />
            <p class="text-center mt-4">
                <a class="text-dark" href="<?= $this->router->generate('user_register') ?>">
                    <?= $this->twig->translation('not.registered') ?>
                </a>
            </p>
        </div>
    </div>
</section>


