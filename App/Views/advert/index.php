<form method="GET">
    <div class="filter">
        <div class="filter__title">
            <h5><i class="fa fa-filter"></i> <?= $this->twig->translation('advert.index.filter') ?></h5>
        </div>
        <div class="filter__search">
            <input type="text" name="name" value="<?= $this->twig->postExist('name', null) ?>">
        </div>
        <div class="filter__select">
            <select name="category">
                <option value=""><?= $this->twig->translation('advert.index.choose.categories') ?></option>
                <?php foreach ($advertsCategories as $advertsCategorie): ?>
                    <option <?= $this->twig->isSelected('category', $advertsCategorie->getCategory()->getId()) ?> value="<?= $advertsCategorie->getCategory()->getId() ?>"><?= $advertsCategorie->getCategory()->getLabel() ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="filter__select">
            <select name="location">
                <option value=""><?= $this->twig->translation('advert.index.choose.location') ?></option>
                <?php foreach ($usersLocations as $usersLocation): ?>
                    <option <?= $this->twig->isSelected('location', $usersLocation->getPostCode()) ?> value="<?= $usersLocation->getPostCode() ?>"><?= $usersLocation->getPostCode() ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="filter__price">
            <p><?= $this->twig->translation('advert.index.min.price') ?></p>
            <div class="price-range-wrap">
                <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content">
                    <div class="ui-slider-range ui-corner-all ui-widget-header"></div>
                    <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                </div>
                <div class="range-slider">
                    <div class="price-input">
                        <input type="text" id="minamount" name="price">
                        <input type="hidden" id="hiddenprice" value="<?= $this->twig->postExist('price', 40) ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="filter__btns">
            <button type="submit" name="search" value="1"><?= $this->twig->translation('advert.filter.result') ?></button>
        </div>
    </div>
</form>

<section class="listing">
    <div class="listing__text__top">
        <div class="listing__text__top__left">
            <h5><?= $this->twig->translation('advert.index') ?></h5>
        </div>
    </div>
    <div class="listing__list">
        <div id="load_data" style="width: 100%"></div>
    </div>
    <br />
    <br />
    <center><div id="load_data_message"></div></center>
</section>

<script src="<?= PATH ?>/App/Views/js/load-advert.js"></script>
<script>
    init("<?= $this->twig->translation('advert.index.data.message.1') ?>", "<?= $this->twig->translation('advert.index.data.message.2') ?>")
</script>

<?php if(!$this->twig->isMobile() && $adverts): ?>
    <div class="listing__map">
        <iframe id="gmaps" width="100%" height="170" frameborder="0"></iframe>
    </div>
    <script>
        let address = '<?= $adverts[0]->getUser()->getPostCode() ?>' + '+' + '<?= $adverts[0]->getUser()->getCountry()->getLabel() ?>';
        let url = 'https://maps.google.com/maps?f=q&source=s_q&hl=en&geocode=&q=' + address + '&z=11&output=embed';
        $('#gmaps').prop('src', url);
    </script>
<?php endif; ?>
