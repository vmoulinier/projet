<form method="POST" action="<?= $this->router->generate("transaction_validation_post") ?>">
    <div class="row">
        <div class="col-md-8">
            <?= $form->input('address', $this->twig->translation('contact.address'), ['type' => 'text', 'value' => $contact->getAddress()]); ?>
        </div>
        <div class="col-md-3">
            <?= $form->input('address2', $this->twig->translation('contact.address2'), ['type' => 'text', 'required' => false, 'value' => $contact->getAddress2()]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <?= $form->input('postcode', $this->twig->translation('contact.postcode'), ['type' => 'number', 'value' => $contact->getPostCode()]); ?>
        </div>
        <div class="col-md-6">
            <?= $form->input('city', $this->twig->translation('contact.city'), ['type' => 'text', 'value' => $contact->getCity()]); ?>
        </div>
        <div class="col-md-3">
            <br />
            <select name="country" class="mt-1" required>
                <option value=""><?= $this->twig->translation('contact.country') ?></option>
                <?php foreach ($countries as $country): ?>
                    <option <?php if($contact->getCountry()->getId() == $country->getId()): ?>selected<?php endif; ?> value="<?= $country->getId() ?>"><?= $this->twig->translation($country->getLabel()) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <?= $form->input('phone', $this->twig->translation('contact.phone'), ['type' => 'number', 'value' => $contact->getPhoneNumber()]); ?>
        </div>
        <div class="col-md-12">
            <?= $form->input('advert', $advert->getId(), ['type' => 'hidden']); ?>
            <?= $form->submit($this->twig->translation('contact.edit')); ?>
        </div>
    </div>
</form>