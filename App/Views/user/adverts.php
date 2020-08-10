<h2 class="center"><?= $this->twig->translation('profil.adverts') ?></h2>
<br />
<a href="<?= $this->router->generate("create_advert") ?>" class="primary-btn btn-profil"><?= $this->twig->translation('profil.create.advert') ?></a>
<br />
<div class="row">
    <?php foreach ($adverts as $advert): ?>
        <div class="col-md-4 p-0 ">
            <div class="listing__item m-2">
                <div class="listing__item__pic set-bg" data-setbg="<?php if($advert->getPictures()): ?><?= $advert->getLinkFirstPictures() ?><?php else: ?><?= PATH ?>/Public/img/listing/list-1.jpg<?php endif; ?>">
                    <div class="listing__item__pic__tag pointer view-advt bg-success"><?= $this->twig->translation('user.advert.lock') ?></div>
                    <div class="listing__item__pic__tag pointer view-advt bg-info"><?= $this->twig->translation('user.advert.urgent') ?></div>
                    <div class="listing__item__pic__tag pointer view-advt bg-info"><?= $this->twig->translation('user.advert.up') ?></div>
                    <div class="listing__item__pic__tag pointer view-advt"><?= $this->twig->translation('user.advert.delete') ?></div>
                    <div class="listing__item__pic__btns">
                        <a class="btns-advt" href="<?= $this->router->generate("edit_advert", ["id" => $advert->getId()]) ?>" target="_blank"><span class="icon_tool green"></span></a>
                    </div>
                </div>
                <div class="listing__item__text">
                    <div class="listing__item__text__inside">
                        <h5 class="pointer mt-1" onclick="window.open('<?= $this->router->generate("edit_advert", ["id" => $advert->getId()]) ?>')"><?= $advert->getTitle() ?></h5>
                        <div class="listing__item__text__rating">
                            <h6 class="float-none"><?= $advert->getPrice()/100; ?>€</h6>
                        </div>
                        <p><?= $advert->getDescription() ?></p>
                        <br />
                    </div>
                    <div class="listing__item__text__info">
                        <div class="listing__item__text__info__left">
                            <span><?= $advert->getExpeditionType()->getLabel() ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
