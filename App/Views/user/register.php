<section class="listing-details spad-sm">
    <h2 class="center"><?= $this->twig->translation('register.title') ?></h2>
    <br />
    <div class="row">
        <div class="col-lg-6 offset-lg-3 text-left">
            <form method="post">
                <div class="row">
                    <div class="col-md-12">
                        <?= $form->input('email', $this->twig->translation('register.email'), ['type' => 'email']); ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->input('name', $this->twig->translation('register.name'), ['type' => 'text']); ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->input('firstname', $this->twig->translation('register.firstname'), ['type' => 'text']); ?>
                    </div>
                    <div class="col-md-12">
                        <?= $form->input('password', $this->twig->translation('register.password'), ['type' => 'password']); ?>
                    </div>
                    <div class="col-md-12">
                        <?= $form->input('password_verif', $this->twig->translation('register.password.verif'), ['type' => 'password']); ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->input('zip', $this->twig->translation('register.zip'), ['type' => 'text']); ?>
                    </div>
                    <div class="col-md-6">
                        <br />
                        <select name="country" class="mt-1" required>
                            <option value=""><?= $this->twig->translation('contact.country') ?></option>
                            <?php foreach ($countries as $country): ?>
                                <option value="<?= $country->getId() ?>"><?= $this->twig->translation($country->getLabel()) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <br />
                        <?= $form->submit($this->twig->translation('register.register')); ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>