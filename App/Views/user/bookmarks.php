<h2 class="center"><?= $this->twig->translation('profil.bookmarks') ?></h2>
<br />
<div class="row">
    <?php foreach ($bookmarks as $bookmark): ?>
    <?php $advert = $bookmark->getAdvert(); ?>
        <div class="col-md-4">
            <div class="listing__item">
                <div class="listing__item__pic set-bg" data-setbg="<?php if($advert->getAdvertPictures()): ?><?= $advert->getLinkFirstPictures() ?><?php else: ?><?= PATH ?>/Public/img/listing/list-1.jpg<?php endif; ?>">
                    <div class="listing__item__pic__tag pointer" onclick="window.open('<?= $this->router->generate("advert_view", ["id" => $advert->getId()]) ?>')"><?= $advert->getCategory()->getLabel() ?></div>
                    <div class="listing__item__pic__btns">
                        <a href="<?= $this->router->generate("advert_view", ["id" => $advert->getId()]) ?>" target="_blank"><span class="icon_zoom-in_alt"></span></a>
                        <a href="#" id="fav<?= $advert->getId() ?>"><span class="icon_heart_alt <?php if($this->twig->isBookmarked($advert)): ?>icon_heart text-warning<?php endif; ?>"></span></a>
                    </div>
                </div>
                <div class="listing__item__text">
                    <div class="listing__item__text__inside">
                        <h5 class="pointer" onclick="window.open('<?= $this->router->generate("advert_view", ["id" => $advert->getId()]) ?>')"><?= $advert->getTitle() ?></h5>
                        <div class="listing__item__text__rating">

                            <div class="listing__item__rating__star">
                                <div id="rateYo" class="rate<?= $advert->getId() ?>"></div>
                            </div>
                            <h6><?= $advert->getPrice()/100; ?>€</h6>
                        </div>
                        <p><?= $advert->getDescription() ?></p>
                        <ul>
                            <li>
                                <span class="icon_pin_alt"></span> <?= $advert->getUser()->getPostCode(); ?>
                            </li>
                        </ul>
                    </div>
                    <div class="listing__item__text__info">
                        <div class="listing__item__text__info__left">
                            <span><?= $this->twig->translation($advert->getExpeditionType()->getLabel()) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(function () {
                $(".rate<?= $advert->getId() ?>").rateYo({
                    rating: 4.6,
                    starWidth: "14px",
                    fullStar: true,
                    readOnly: true
                });
            });
            $( "#fav<?= $advert->getId() ?>" ).click(function() {
                $.ajax
                ({
                    data: {"fav": <?= $advert->getId() ?>},
                    type: 'post',
                    url: '<?= $this->router->generate("add_bookmark_post") ?>'
                });
                if (!$(this).children().hasClass('text-warning')) {
                    $(this).children().addClass('text-warning');
                    $(this).children().addClass('icon_heart');
                } else {
                    $(this).children().removeClass('text-warning');
                    $(this).children().removeClass('icon_heart');
                }
            });
        </script>
    <?php endforeach; ?>
</div>
