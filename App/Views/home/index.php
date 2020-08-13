<section class="hero set-bg" data-setbg="<?= PATH ?>/Public/img/app_bg2.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-1">
                <div class="hero__text">
                    <div class="section-title">
                        <h2 class="center"><?= $this->twig->translation('index.title') ?></h2>
                    </div>
                    <div class="hero__search__form">
                        <form method="GET" action="<?= $this->router->generate('advert_index') ?>">
                            <input type="text" placeholder="<?= $this->twig->translation('advert.index.search') ?>" name="name">
                            <div class="select__option">
                                <select name="category">
                                    <option value=""><?= $this->twig->translation('advert.index.choose.categories') ?></option>
                                    <?php foreach ($advertsCategories as $advertsCategorie): ?>
                                        <option value="<?= $advertsCategorie->getCategory()->getId() ?>"><?= $advertsCategorie->getCategory()->getLabel() ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="select__option">
                                <select name="location">
                                    <option value=""><?= $this->twig->translation('advert.index.choose.location') ?></option>
                                    <?php foreach ($usersLocations as $usersLocation): ?>
                                        <option value="<?= $usersLocation->getPostCode() ?>"><?= $usersLocation->getPostCode() ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" name="search" value="1"><?= $this->twig->translation('advert.filter.result') ?></button>
                        </form>
                    </div>
                    <ul class="hero__categories__tags">
                        <li><a href="#"><span class="fa fa-book red"></span> <?= count($allAdverts) ?> <?= $this->twig->translation('advert.index') ?></a></li>
                        <li><a href="#"><span class="fa fa-question-circle green"></span> <?= count($allRequests) ?> <?= $this->twig->translation('request.index') ?></a></li>
                        <li><a href="#"><span class="fa fa-user-circle blue"></span> <?= count($allUsers) ?> <?= $this->twig->translation('home.registered') ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="categories spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <p class="center"><?= $str ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="most-search spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>The Most Searched Services</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="tab-content">
                    <div class="tab-pane active" id="tabs-1" role="tabpanel">
                        <div class="row">

                            <?php foreach ($premiumAdverts as $advert): ?>
                                <div class="col-lg-3 col-md-6">
                                    <div class="listing__item">
                                        <div class="listing__item__pic set-bg h-200" data-setbg="<?php if($advert->getAdvertPictures()): ?><?= $advert->getLinkFirstPictures() ?><?php else: ?><?= PATH ?>/Public/img/listing/list-1.jpg<?php endif; ?>">
                                            <div class="listing__item__pic__tag pointer" onclick="window.open('<?= $this->router->generate("advert_view", ["id" => $advert->getId()]) ?>')"><?= $advert->getCategory()->getLabel() ?></div>
                                            <div class="listing__item__pic__btns">
                                                <a href="<?= $this->router->generate("advert_view", ["id" => $advert->getId()]) ?>" target="_blank"><span class="icon_zoom-in_alt"></span></a>
                                            </div>
                                        </div>
                                        <div class="listing__item__text pb-2">
                                            <div class="listing__item__text__inside">
                                                <h5 class="pointer" onclick="window.open('<?= $this->router->generate("advert_view", ["id" => $advert->getId()]) ?>')"><?= $advert->getTitle() ?></h5>
                                                <div class="listing__item__text__rating">

                                                    <div class="listing__item__rating__star">
                                                        <div id="rateYo" class="rate<?= $advert->getId() ?>"></div>
                                                    </div>
                                                    <h6><?= $advert->getPrice()/100; ?>€</h6>
                                                </div>
                                                <p><?= $advert->getDescription() ?></p>
                                                <ul class="mb-2">
                                                    <li>
                                                        <span class="icon_pin_alt"></span> <?= $advert->getUser()->getPostCode(); ?>
                                                    </li>
                                                </ul>
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
                                </script>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
