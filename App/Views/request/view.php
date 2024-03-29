<?php $rate = $request->getUser()->getRating(); ?>
<div class="bg-advert"></div>
<section class="listing-hero set-bg-advert" data-setbg="<?php if($pictures): ?><?= $request->getLinkFirstPictures() ?><?php else: ?><?= PATH ?>/Public/img/app_bg2.jpg<?php endif; ?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="listing__hero__option">
                    <div class="listing__hero__text">
                        <h2><?= $request->getTitle() ?>
                            <br /><small><?= $request->getBrand() ?></small>
                        </h2>
                        <?php if($rate): ?>
                        <div class="listing__hero__widget">
                            <div id="rateYo"></div> <span class="text-white"><?= count($request->getUser()->getTransactionRates()) ?> - <?= $this->twig->translation('view.review') ?></span>
                        </div>
                        <?php endif; ?>
                        <p><span class="icon_pin_alt"></span> <?= $request->getUser()->getPostCode() ?>, <?= $request->getUser()->getCountry()->getLabel() ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <?php if($this->twig->logged()): ?>
                <div class="listing__item__pic__btns">
                    <a id="fav<?= $request->getId() ?>" class="pointer"><span class="icon_heart_alt <?php if($this->twig->isBookmarked($request)): ?>icon_heart text-warning<?php endif; ?>"></span></a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<section class="listing-details spad-sm">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="listing__details__text">
                    <div class="listing__details__about">
                        <h4>Overview</h4>
                        <p><?= $request->getDescription(); ?></p>
                        <br />
                        <p><small><?= $this->twig->translation('purchase.date') ?> <?= $request->getPurchasedAt()->format('Y-m-d') ?></small></p>
                    </div>
                    <?php if($pictures): ?>
                    <div class="listing__details__gallery">
                        <h4>Gallery</h4>
                        <div class="listing__details__gallery__pic">
                            <div class="listing__details__gallery__item">
                                <img class="listing__details__gallery__item__large" <?php if($this->twig->isMobile()): ?>style="height: 350px"<?php else: ?>style="height: 450px"<?php endif; ?>
                                     src="<?= $request->getLinkFirstPictures() ?>" alt="">
                                <span><i class="fa fa-camera"></i> <?= count($pictures) ?> <?= $this->twig->translation('view.images') ?></span>
                            </div>
                            <div class="listing__details__gallery__slider owl-carousel">
                                <?php foreach ($pictures as $picture): ?>
                                    <img <?php if($this->twig->isMobile()): ?>style="height: 65px"<?php else: ?>style="height: 120px"<?php endif; ?> id="<?= $picture->getId() ?>" data-imgbigurl="<?= $picture->getLink() ?>" src="<?= $picture->getLink() ?>" alt="">
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="listing__details__comment">
                        <h4><?= $this->twig->translation('view.discussion.title') ?></h4>
                        <?php foreach ($questions as $question): ?>
                        <div class="listing__details__comment__item">
                            <div class="listing__details__comment__item__pic">
                                <img src="<?= PATH ?>/Public/img/404image_CV_M.png" alt="">
                            </div>
                            <div class="listing__details__comment__item__text">
                                <span><?= $question->getCreatedAt()->format('Y-m-d') ?></span>
                                <h5><?= $question->getUser()->getName() ?></h5>
                                <div class="alert alert-secondary"><?= $question->getMessage() ?></div>
                                <?php if($question->getAnswers()): ?>
                                    <?php foreach ($question->getAnswers() as $answer): ?>
                                        <span class="ml-5"><i class="fa fa-share text-dark" aria-hidden="true"></i> <?= $answer->getCreatedAt()->format('Y-m-d') ?></span>
                                        <div class="alert alert-secondary bg-light ml-4"><?= $answer->getMessage() ?></div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <?php if($this->twig->logged() && ($request->getUser() === $this->twig->getCurrentUser())): ?>
                                <form method="post" class="ml-4">
                                    <div class="form-group mt-2">
                                        <textarea rows="3" name="answer" class="form-control" placeholder="<?= $this->twig->translation('placeholder.answer') ?>" required=""></textarea>
                                    </div>
                                    <input type="hidden" name="question_id" value="<?= $question->getId() ?>">
                                    <div class="form-group">
                                        <button name="submitAnswer" type="submit" value="1" class="site-btn"><?= $this->twig->translation('button.send') ?></button>
                                    </div>
                                </form>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="listing__details__review">
                        <h4><?= $this->twig->translation('view.review.tilte') ?></h4>
                        <form method="POST">
                            <textarea placeholder="<?= $this->twig->translation('placeholder.message') ?>" name="message"></textarea>
                            <button type="submit" class="site-btn" value="1" name="submitReview"><?= $this->twig->translation('button.submit') ?></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="listing__sidebar">
                    <div class="listing__sidebar__contact">
                        <div class="listing__sidebar__contact__map">

                            <iframe id="gmaps" height="200" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                            <script>
                                let address = '<?= $request->getUser()->getPostCode() ?>' + '+' + '<?= $request->getUser()->getCountry()->getLabel() ?>';
                                let url = 'https://maps.google.com/maps?f=q&source=s_q&hl=en&geocode=&q=' + address + '&z=11&output=embed';
                                $('#gmaps').prop('src', url);
                            </script>
                            <img src="<?= PATH ?>/Public/img/listing/details/map-icon.png" alt="">
                        </div>
                        <div class="listing__sidebar__contact__text">
                            <h4><?= $this->twig->translation('view.about.title') ?></h4>
                            <ul>
                                <li><span class="icon_book_alt"></span> <?= $this->twig->translation('view.about.advert') ?> <?= $request->getId() ?></li>
                                <li><span class="icon_search"></span> <?= $request->getViews() ?> <?= $this->twig->translation('view.about.views') ?></li>
                                <li><span class="fa fa-truck"></span> <?= $this->twig->translation($request->getExpeditionType()->getLabel()) ?></li>
                                <li><span class="icon_mail_alt"></span> <a href="#"><?= $this->twig->translation('view.about.contact') ?></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php if($rate): ?>
                <div class="listing__sidebar">
                    <div class="listing__sidebar__contact">
                        <div class="listing__sidebar__contact__text">
                            <h4><?= $this->twig->translation('view.rate.title') ?></h4>
                            <?php foreach ($request->getUser()->getTransactionRates() as $transactionRate): ?>
                                <hr />
                                <span class="d-inline-flex align-items-baseline mb-0 bold">
                                    <?= $transactionRate->getUser()->getName(); ?> <?= $transactionRate->getUser()->getFirstName(); ?> - <div id="rating<?= $transactionRate->getId(); ?>"></div>
                                </span>

                                <div class="alert alert-primary mt-2">
                                    <p><?= $transactionRate->getRate()->getComment(); ?></p>
                                </div>
                                <script>
                                    $(function () {
                                        $("#rating<?= $transactionRate->getId(); ?>").rateYo({
                                            rating: <?= $transactionRate->getRate()->getRate() ?>,
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
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<script>
    <?php if($rate): ?>
    $(function () {
        $("#rateYo").rateYo({
            rating: <?= $rate ?>,
            starWidth: "14px",
            readOnly: true
        });
    });
    <?php endif; ?>
    $( '#fav<?= $request->getId() ?>' ).click(function () {
        $.ajax
        ({
            data: {"fav": <?= $request->getId() ?>},
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