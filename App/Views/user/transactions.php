<h2 class="center"><?= $this->twig->translation('profil.transactions') ?></h2>
<br/>
<br/>
<?php if($transactions): ?>
<?php else: ?>
<?php endif; ?>
<table class="table table-responsive-md">
    <thead class="table-info">
    <tr class="bold">
        <td><?= $this->twig->translation('transaction.date') ?></td>
        <td><?= $this->twig->translation('transaction.payment.mode') ?></td>
        <td><?= $this->twig->translation('transaction.payment.type') ?></td>
        <td><?= $this->twig->translation('transaction.total') ?></td>
        <td><?= $this->twig->translation('transaction.invoice') ?></td>
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
        <?php endforeach; ?>
    </tr>
    </tbody>
</table>
