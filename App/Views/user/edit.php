<section class="listing-details">
    <h2 class="center"><?= $this->twig->translation('profil.edit.title') ?></h2>
    <br />
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <form method="post">
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->input('name', $this->twig->translation('profil.name'), ['type' => 'text', 'value' => $user->getName()]); ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->input('firstname', $this->twig->translation('profil.firstname'), ['type' => 'text', 'value' => $user->getFirstname()]); ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->input('zip', $this->twig->translation('register.zip'), ['type' => 'text', 'value' => $user->getPostCode()]); ?>
                    </div>
                    <div class="col-md-6">
                        <br />
                        <select name="country" class="mt-1" required>
                            <option value=""><?= $this->twig->translation('contact.country') ?></option>
                            <?php foreach ($countries as $country): ?>
                                <option <?php if($user->getCountry() && $user->getCountry()->getId() == $country->getId()): ?>selected<?php endif; ?> value="<?= $country->getId() ?>"><?= $this->twig->translation($country->getLabel()) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <?= $form->submit($this->twig->translation('profil.submit')); ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>


