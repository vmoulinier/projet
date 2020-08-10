<h2 class="center"><?= $this->twig->translation('profil.advert.edit') ?></h2>
<br />

<form method="post" class="text-left create-advert" enctype="multipart/form-data">
    <div class="row">
        <div class="col-12">
            <?= $form->input('title', $this->twig->translation('advert.create.title'), ['type' => 'text', 'value' => $advert->getTitle()]); ?>
    </div>
        <div class="col-md-6">
            <select name="category" required>
                <option value=""><?= $this->twig->translation('advert.index.choose.categories') ?></option>
                <?php foreach ($advertsCategories as $advertsCategorie): ?>
                    <option <?= $this->twig->isSelected('category', $advertsCategorie->getId()) ?> <?php if($advert->getCategory()->getId() === $advertsCategorie->getId()): ?>selected<?php endif; ?> value="<?= $advertsCategorie->getId() ?>"><?= $advertsCategorie->getLabel() ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6">
            <?= $form->input('price', $this->twig->translation('advert.create.price'), ['type' => 'number', 'value' => $advert->getPrice()]); ?>
        </div>
        <div class="col-md-6">
            <?= $form->input('description', $this->twig->translation('advert.create.description'), ['type' => 'textarea', 'value' => $advert->getDescription()]); ?>
        </div>
        <div class="col-md-6">
            <?= $form->input('brand', $this->twig->translation('advert.create.brand'), ['type' => 'text', 'value' => $advert->getBrand()]); ?>
            <?= $form->input('shape', $this->twig->translation('advert.create.shape'), ['type' => 'text', 'value' => $advert->getShape()]); ?>
        </div>
        <div class="col-md-6">
            <?= $form->input('purchasedat', $this->twig->translation('advert.create.purchasedat'), ['type' => 'date', 'value' => $advert->getCreatedAt()->format('Y-m-d')]); ?>
        </div>
        <div class="col-md-6">
            <select name="expeditiontype" required>
                <option value=""><?= $this->twig->translation('advert.index.choose.expeditiontype') ?></option>
                <?php foreach ($expeditionTypes as $expeditionType): ?>
                    <option <?= $this->twig->isSelected('expeditiontype', $expeditionType->getId()) ?> <?php if($advert->getExpeditionType()->getId() === $expeditionType->getId()): ?>selected<?php endif; ?> value="<?= $expeditionType->getId() ?>"><?= $expeditionType->getLabel() ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6">
            <?= $form->input('guarantee', $this->twig->translation('advert.create.guarantee'), ['type' => 'checkbox', 'required' => 'false']); ?>
            <br />
        </div>
        <?php if($pictures): ?>
            <div class="col-md-12">
                <div class="row mb-2">
                    <?php foreach ($pictures as $picture): ?>
                        <div class="col-md-4 content">
                            <img id="img<?= $picture->getId() ?>" style="height: 240px; width: 240px" class="img-thumbnail img-advt" data-imgbigurl="<?= $picture->getLink() ?>" src="<?= $picture->getLink() ?>" alt="">
                            <div class="middle">
                                <div class="btn btn-sm btn-danger" id="delete<?= $picture->getId() ?>"><?= $this->twig->translation('img.delete') ?></div>
                                <div class="btn btn-sm btn-info" id="rotate<?= $picture->getId() ?>"><?= $this->twig->translation('img.rotate') ?></div>
                            </div>
                        </div>
                        <script>
                            let rotate<?= $picture->getId() ?> = 0;
                            $('#rotate<?= $picture->getId() ?>').click(function() {
                                rotate<?= $picture->getId() ?> += 90;
                                $('#img<?= $picture->getId() ?>').css({'transform' : 'rotate('+ rotate<?= $picture->getId() ?> +'deg)'});
                                $.ajax
                                ({
                                    data: {"rotation": rotate<?= $picture->getId() ?>, "img": <?= $picture->getId() ?>},
                                    type: 'post',
                                });
                            });
                            $('#delete<?= $picture->getId() ?>').click(function() {
                                if(confirm('Delete ?')) {
                                    $(this).parent().parent().hide();
                                    $.ajax
                                    ({
                                        data: {"delete": <?= $picture->getId() ?>},
                                        type: 'post',
                                    });
                                }
                            });
                        </script>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        <div class="col-md-12">
            <label><?= $this->twig->translation('advert.create.images') ?></label>
            <input name="files[]" type="file" id="input-id" multiple>
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