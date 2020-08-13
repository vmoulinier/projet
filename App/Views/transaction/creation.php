<div class="row">
    <div class="col-md-8">
        <div class="listing__details__text">
            <div class="listing__details__about">
                <h2><?= $this->twig->translation('transaction.creation') ?></h2>
                <br />
                <?php if($contact): ?>
                    <?php require_once 'App/Views/transaction/partials/form-contact-edit.php'; ?>
                <?php else: ?>
                    <?php require_once 'App/Views/transaction/partials/form-contact-create.php'; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <br />
        <br />
        <div class="listing__sidebar">
            <div class="listing__sidebar__contact">
                <div class="listing__sidebar__contact__text">
                    <ul>
                        <li><span class="icon_book_alt"></span> <?= $this->twig->translation('view.about.advert') ?> <?= $advert->getId() ?></li>
                        <li><span class="fa fa-truck"></span> <?= $advert->getExpeditionType()->getLabel() ?></li>
                        <li><span class="fa fa-usd"></span> <b><?= $advert->getPrice() ?></b></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>