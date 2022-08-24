<?php foreach ($requests as $request): ?>
    <?php $rate = $request->getUser()->getRating(); ?>
    <div class="listing__item">
        <div class="listing__item__pic set-bg" data-setbg="<?php if($request->getAdvertPictures()): ?><?= $request->getLinkFirstPictures() ?><?php else: ?><?= PATH ?>/Public/img/listing/list-1.jpg<?php endif; ?>">
            <div class="listing__item__pic__tag pointer" onclick="window.open('<?= $this->router->generate("request_view", ["id" => $request->getId()]) ?>')"><?= $request->getCategory()->getLabel() ?></div>
            <div class="listing__item__pic__btns">
                <a href="<?= $this->router->generate("request_view", ["id" => $request->getId()]) ?>" target="_blank"><span class="icon_zoom-in_alt"></span></a>
                <a href="#" id="map<?= $request->getId() ?>"><span class="icon_pin_alt"></span></a>
                <a href="#" id="fav<?= $request->getId() ?>"><span class="icon_heart_alt <?php if($this->twig->isBookmarked($request)): ?>icon_heart text-warning<?php endif; ?>"></span></a>
            </div>
        </div>
        <div class="listing__item__text">
            <div class="listing__item__text__inside">
                <h5 class="pointer" onclick="window.open('<?= $this->router->generate("request_view", ["id" => $request->getId()]) ?>')"><?= $request->getTitle() ?></h5>
                <div class="listing__item__text__rating">

                    <div class="listing__item__rating__star">
                        <?php if($rate): ?>
                        <div id="rateYo" class="rate<?= $request->getId() ?>"></div>
                        <?php endif; ?>
                    </div>
                    <h6><?= $request->getPrice()/100; ?>€</h6>
                </div>
                <p><?= $request->getDescription() ?></p>
                <ul>
                    <li>
                        <span class="icon_pin_alt"></span> <?= $request->getUser()->getPostCode(); ?>
                    </li>
                </ul>
            </div>
            <div class="listing__item__text__info">
                <div class="listing__item__text__info__left">
                    <span><?= $this->twig->translation($request->getExpeditionType()->getLabel()) ?></span>
                </div>
            </div>
        </div>
    </div>
    <script>
        <?php if($rate): ?>
        $(function () {
            $(".rate<?= $request->getId() ?>").rateYo({
                rating: <?= $rate ?>,
                starWidth: "14px",
                fullStar: true,
                readOnly: true
            });
        });
        <?php endif; ?>
        $( "#map<?= $request->getId() ?>" ).click(function() {
            let address = '<?= $request->getUser()->getPostCode() ?>' + '+' + '<?= $request->getUser()->getCountry()->getCode() ?>';
            console.log(address);
            let url = 'https://maps.google.com/maps?f=q&source=s_q&hl=en&geocode=&q=' + address + '&z=11&output=embed';
            $('#gmaps').prop('src', url);
        });
        $( "#fav<?= $request->getId() ?>" ).click(function() {
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
<?php endforeach; ?>

<script src="<?= PATH ?>/Public/js/theme/jquery.nice-select.min.js"></script>
<script src="<?= PATH ?>/Public/js/theme/jquery-ui.min.js"></script>
<script src="<?= PATH ?>/Public/js/theme/jquery.nicescroll.min.js"></script>
<script src="<?= PATH ?>/Public/js/theme/jquery.barfiller.js"></script>
<script src="<?= PATH ?>/Public/js/theme/jquery.magnific-popup.min.js"></script>
<script src="<?= PATH ?>/Public/js/theme/jquery.slicknav.js"></script>
<script src="<?= PATH ?>/Public/js/theme/owl.carousel.min.js"></script>
<script src="<?= PATH ?>/Public/js/theme/main.js"></script>
<script src="<?= PATH ?>/Public/js/jquery.rateyo.min.js"></script>
<script src="https://kit.fontawesome.com/d92432fce9.js" crossorigin="anonymous"></script>
