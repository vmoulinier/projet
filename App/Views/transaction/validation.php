<div class="row">
    <div class="col-md-8">
        <div class="listing__details__text">
            <div class="listing__details__about">
                <h2><?= $this->twig->translation('transaction.validation') ?></h2>
                <br />
                <form method="POST">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card bg-light mb-5">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="radio">
                                                <p class="text-center">
                                                    <label class="pointer">
                                                        <input id="card" type="radio" name="method" value="1" checked="checked">
                                                        <img src="https://touschalets.com/img/cms/homepage/logo-paiement-securise-cb-1.jpg" width="170" height="60">
                                                    </label>
                                                    <br>Paiement sécurisé par Carte bancaire
                                                    <span id="test" data-toggle="tooltip" title="Cette méthode est sans surcoût. Vous recevrez immédiatement les coordonnées du vendeur par email"><i class="fa fa-info-circle pointer" aria-hidden="true"></i></span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="radio">
                                                <p class="text-center">
                                                    <label class="pointer">
                                                        <input id="paypal" type="radio" name="method" value="2">
                                                        <img src="http://pngimg.com/uploads/paypal/paypal_PNG21.png" width="170" height="60">
                                                    </label>
                                                    <br>Paiement par PayPal
                                                    <span data-toggle="tooltip" title="PayPal entraine un surcoût par rapport aux autres méthodes de paiement qui ne pourra faire l'objet de remboursement. Vous recevrez immédiatement les coordonnées du vendeur par email"><i class="fa fa-info-circle pointer" aria-hidden="true"></i></span>
                                                    <br>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="radio">
                                                <p class="text-center">
                                                    <label class="pointer">
                                                        <input id="transfert" type="radio" name="method" value="3">
                                                        <img src="https://www.occasion-dentaire.com/Public/images/icons/virement.png" width="170" height="60">
                                                    </label>
                                                    <br>
                                                    Virement bancaire
                                                    <span data-toggle="tooltip" html="true" title="Cette méthode est sans surcoût. Vous devez informer le site par email afin de bloquer l'annonce le temps de recevoir les fonds, avec l'accord du vendeur. Vous recevrez après les coordonnées du vendeur par email"><i class="fa fa-info-circle pointer" aria-hidden="true"></i></span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-7">
                            <p class="validation-txt mb-4"><?= $advert->getTitle() ?></p>
                        </div>
                        <div class="col-5 text-right">
                            <i class="fa fa-usd" aria-hidden="true"></i> <?= $transaction->getAmount() ?>
                        </div>
                    </div>
                    <?php if($transaction->getDeliveryAmount()): ?>
                        <div class="row">
                            <div class="col-7">
                                <p class="validation-txt mb-4"><?= $this->twig->translation('transaction.delivery.taxes') ?></p>
                            </div>
                            <div class="col-5 text-right">
                                <i class="fa fa-usd" aria-hidden="true"></i> <?= $transaction->getDeliveryAmount() ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row paypal-taxes" style="display: none;">
                        <div class="col-7">
                            <p class="validation-txt mb-4"><?= $this->twig->translation('transaction.paypal.taxes') ?></p>
                        </div>
                        <div class="col-5 text-right">
                            <i class="fa fa-usd" aria-hidden="true"></i> <?= $transaction->getPaypalTaxes() ?>
                        </div>
                    </div>
                    <hr class="my-4">
                    <div class="row">
                        <div class="col-5 offset-7 text-right mb-2">
                            <div class="row">
                                <div class="col-6">
                                    <p class="validation-txt mb-4"><b><?= $this->twig->translation('transaction.total') ?></b></p>
                                </div>
                                <div class="col-6">
                                    <i class="fa fa-usd" aria-hidden="true"></i> <span id="totalPrice"><?= $transaction->getAmount() + $transaction->getDeliveryAmount() ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-7">
                            <div class="row">
                                <div class="col-12">
                                    <label><input type="checkbox" id="cgu"> <?= $this->twig->translation('transaction.cgu') ?></label>
                                </div>
                                <div class="col-12">
                                    <?= $form->input('transaction', $transaction->getId(), ['type' => 'hidden']); ?>
                                    <?= $form->submit($this->twig->translation('transaction.validation')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <br />
        <br />
        <div class="listing__sidebar">
            <div class="listing__sidebar__contact">
                <div class="listing__sidebar__contact__text">
                    <?php if($advert->getExpeditionType()->getConditions() == 'followed'): ?>
                        <h5><?= $this->twig->translation('transaction.validation.followed') ?></h5>
                        <br />
                        <p>
                            <?= $contact->getAddress() ?><br />
                            <?= $contact->getAddress2() ?><br />
                            <?= $contact->getPostCode() ?> <?= $contact->getCity() ?><br />
                            <?= $contact->getCountry()->getLabel() ?> <br />
                        </p>
                    <?php else: ?>
                        <p>
                            <?= $this->twig->translation('transaction.validation.pickup') ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    let submit = $("button[name='submit']");
    submit.prop('disabled', true);
    $("#cgu").click(function () {
        submit.prop('disabled', true);
        if ($(this).is(':checked')) {
            submit.prop('disabled', false);
        }
    });
    $("input[name='method']").change(function(){
        let val = $("input[name='method']:checked").val();
        let paypal = $('.paypal-taxes');
        let totalPrice = '<?= $transaction->getAmount() + $transaction->getDeliveryAmount() ?>';
        let totalPricePayPal = '<?= $transaction->getAmount() + $transaction->getDeliveryAmount() + $transaction->getPaypalTaxes() ?>';
        let price = $('#totalPrice');

        price.text(totalPrice);
        paypal.hide();
        if (val == 2) {
            paypal.show();
            price.text(totalPricePayPal);
        }
    });
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
