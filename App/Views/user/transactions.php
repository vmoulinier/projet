<h2 class="center"><?= $this->twig->translation('profil.transactions') ?></h2>
<br/>
<br/>
<?php if($transactions): ?>
    <table class="table table-responsive-md">
        <thead class="table-info">
        <tr class="bold">
            <td><?= $this->twig->translation('transaction.date') ?></td>
            <td><?= $this->twig->translation('transaction.payment.mode') ?></td>
            <td><?= $this->twig->translation('transaction.payment.type') ?></td>
            <td><?= $this->twig->translation('transaction.total') ?></td>
            <td><?= $this->twig->translation('transaction.invoice') ?></td>
            <td><?= $this->twig->translation('transaction.rating') ?></td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <?php foreach($transactions as $transaction): ?>
                <td><p class="card-text"><?= $transaction->getCreatedAt()->format('Y-m-d') ?></p></td>
                <td><p class="card-text"><?= $transaction->getType() ?></p></td>
                <td><p class="card-text"><?= $transaction->getInvoice()->getType() ?></p></td>
                <td><p class="card-text"><?= $transaction->getInvoice()->getTotalAmount()/100 ?> €</p></td>
                <td><a href="<?= $this->router->generate("user_invoice", ['id' => $transaction->getId()]) ?>" target="_blank">Invoice</a></td>
                <td>
                    <?php if($transaction->getRate()): ?>
                        <div id="rateYo<?= $transaction->getId() ?>"></div>
                        <script>
                            $(function () {
                                $("#rateYo<?= $transaction->getId() ?>").rateYo({
                                    rating: <?= $transaction->getRate()->getRate() ?>,
                                    starWidth: "14px",
                                    fullStar: true,
                                    readOnly: true
                                });
                            });
                        </script>
                    <?php else: ?>
                        <button class="btn primary-btn" data-toggle="modal" data-target="#rateModal<?= $transaction->getId() ?>"><?= $this->twig->translation('transaction.rate') ?></button>
                        <div class="modal fade" id="rateModal<?= $transaction->getId() ?>" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h2><?= $this->twig->translation('transaction.rate.title') ?></h2>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="POST">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <div id="rateYo<?= $transaction->getId() ?>"></div>
                                                <br />
                                                <br />
                                                <label><?= $this->twig->translation('transaction.rate.message') ?></label>
                                                <textarea rows="5" name="message" class="form-control" required></textarea>
                                                <input type="hidden" value="1" name="rate" id="rate<?= $transaction->getId(); ?>" />
                                                <input type="hidden" value="<?= $transaction->getId() ?>" name="transaction" />
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $this->twig->translation('transaction.rate.close') ?></button>
                                            <button id="submit<?= $transaction->getId() ?>" type="submit" name="submit" value="true" class="btn primary-btn" style="white-space: normal;" disabled>
                                                <?= $this->twig->translation('transaction.rate.submit') ?>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <script>
                            $(function () {
                                $("#rateYo<?= $transaction->getId() ?>").rateYo({
                                    rating:0,
                                    fullStar: true,
                                    onSet: function (rating, rateYoInstance) {
                                        if (rating > 0) {
                                            $("#submit<?= $transaction->getId() ?>").prop('disabled', false);
                                            $('#rate<?= $transaction->getId(); ?>').val(rating);
                                        }
                                    }
                                });
                            });
                        </script>
                    <?php endif; ?>
                </td>

            <?php endforeach; ?>
        </tr>
        </tbody>
    </table>
<?php else: ?>
<?php endif; ?>
