<?php foreach($transactions as $transaction): ?>
    <div class="card bg-light text-left">
        <div class="card-body">
            <h5 class="mt-2"><?= $transaction->getType() ?></h5>
            <p class="card-text"><?= $transaction->getCreatedAt()->format('Y-m-d') ?></p>
            <p class="card-text"><?= $transaction->getInvoice()->getType() ?></p>
            <p class="card-text"><?= $transaction->getInvoice()->getTotalAmount() ?> €</p>
            <a href="<?= $this->router->generate("user_invoice", ['id' => $transaction->getId()]) ?>" target="_blank">Invoice</a>
        </div>
    </div>
<?php endforeach; ?>
