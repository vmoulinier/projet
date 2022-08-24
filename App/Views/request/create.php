<h2 class="center"><?= $this->twig->translation('profil.advert.create') ?></h2>
<br />

<form method="post" class="text-left create-advert" enctype="multipart/form-data">
    <div class="row">
        <div class="col-12">
            <?= $form->input('title', $this->twig->translation('advert.create.title'), ['type' => 'text']); ?>
        </div>
        <div class="col-md-6">
            <select name="category" required>
                <option value=""><?= $this->twig->translation('advert.index.choose.categories') ?></option>
                <?php foreach ($advertsCategories as $advertsCategorie): ?>
                    <option <?= $this->twig->isSelected('category', $advertsCategorie->getId()) ?> value="<?= $advertsCategorie->getId() ?>"><?= $advertsCategorie->getLabel() ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6">
            <?= $form->input('price', $this->twig->translation('advert.create.price'), ['type' => 'number']); ?>
        </div>
        <div class="col-md-6">
            <?= $form->input('description', $this->twig->translation('advert.create.description'), ['type' => 'textarea']); ?>
        </div>
        <div class="col-md-6">
            <?= $form->input('brand', $this->twig->translation('advert.create.brand'), ['type' => 'text']); ?>
            <?= $form->input('shape', $this->twig->translation('advert.create.shape'), ['type' => 'text']); ?>
        </div>
        <div class="col-md-6">
            <?= $form->input('purchasedat', $this->twig->translation('advert.create.purchasedat'), ['type' => 'date']); ?>
        </div>
        <div class="col-md-6">
            <select name="expeditiontype" required>
                <option value=""><?= $this->twig->translation('advert.index.choose.expeditiontype') ?></option>
                <?php foreach ($expeditionTypes as $expeditionType): ?>
                    <option <?= $this->twig->isSelected('expeditiontype', $expeditionType->getId()) ?> value="<?= $expeditionType->getId() ?>"><?= $expeditionType->getLabel() ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6">
            <?= $form->input('guarantee', $this->twig->translation('advert.create.guarantee'), ['type' => 'checkbox', 'required' => 'false']); ?>
            <br />
        </div>
        <div class="col-md-12">
            <label><?= $this->twig->translation('advert.create.images') ?></label>
            <input name="files[]" type="file" id="input-id" multiple required>
            <br />
        </div>
        <div class="col-12">
            <?= $form->submit($this->twig->translation('advert.submit')); ?>
        </div>
    </div>
</form>
<script src="<?=PATH?>/Public/js/piexif.js" type="text/javascript"></script>
<script src="<?=PATH?>/Public/js/sortable.js" type="text/javascript"></script>
<script src="<?=PATH?>/Public/js/purify.js" type="text/javascript"></script>
<script src="<?=PATH?>/Public/js/fileinput.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.1.2/js/locales/<?= DEFAULT_LANGAGE ?>.js"></script>
<script>
    $("#input-id").fileinput({
        'showCaption':false,
        'showCancel':false,
        'showUpload':false,
        'uploadAsync':false,
        allowedFileExtensions: ["jpg", "png", "jpeg"],
        language: "fr",
        'maxFileSize':8000
    });
    $('#input-id').on('fileerror', function(event, data, msg) { });
    $('.kv-upload-progress').hide();
</script>