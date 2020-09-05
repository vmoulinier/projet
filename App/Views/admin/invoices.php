<h2 class="center"><?= $this->twig->translation('admin.users') ?></h2>
<div class="row mt-4">
    <div class="col-12">
        <table class="table table-bordered">
            <thead class="thead-light">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Date</th>
                <th scope="col">Vendeur</th>
                <th scope="col">Montant</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($invoices as $invoice): ?>
                <tr>
                    <td><?= $invoice->getId() ?></td>
                    <td><?= $invoice->getCreatedAt()->format('Y-m-d') ?></td>
                    <td><a href="<?= $this->router->generate("advert_view", ["id" => $invoice->getAdvert()->getId()]) ?>" target="_blank"><?= $invoice->getAdvert()->getUser()->getName() ?></a></td>
                    <td><?= $invoice->getTotalPrice() ?></td>
                    <td>

                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
