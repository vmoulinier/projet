<form method="POST" action="<?= $this->router->generate("transaction_validation_post") ?>">
    <div class="row">
        <div class="col-md-8">
            <?= $form->input('address', $this->twig->translation('contact.address'), ['type' => 'text']); ?>
        </div>
        <div class="col-md-3">
            <?= $form->input('address2', $this->twig->translation('contact.address2'), ['type' => 'text', 'required' => false]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <?= $form->input('postcode', $this->twig->translation('contact.postcode'), ['type' => 'number']); ?>
        </div>
        <div class="col-md-6">
            <?= $form->input('city', $this->twig->translation('contact.city'), ['type' => 'text']); ?>
        </div>
        <div class="col-md-3">
            <br />
            <select name="country" class="mt-1" required>
                <option value=""><?= $this->twig->translation('contact.country') ?></option>
                <?php foreach ($countries as $country): ?>
                    <option <?= $this->twig->isSelected('country', $country->getId()) ?> value="<?= $country->getId() ?>"><?= $this->twig->translation($country->getLabel()) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <?= $form->input('phone', $this->twig->translation('contact.phone'), ['type' => 'number']); ?>
        </div>
        <div class="col-md-12">
            <?= $form->input('advert', $advert->getId(), ['type' => 'hidden']); ?>
            <?= $form->submit($this->twig->translation('contact.create')); ?>
        </div>
    </div>
</form>