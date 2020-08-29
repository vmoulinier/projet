<section class="listing-details spad-xl">
    <h2 class="center"><?= $this->twig->translation('contact.title') ?></h2>
    <br />
    <div class="row">
        <div class="col-lg-4 offset-lg-4">
            <form method="post">
                <?= $form->input('email', $this->twig->translation('login.email'), ['type' => 'email']); ?>
                <?= $form->input('password', $this->twig->translation('login.password'), ['type' => 'password']); ?>
                <?= $form->submit($this->twig->translation('login.login')); ?>
            </form>
            <br />
        </div>
    </div>
</section>