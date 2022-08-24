<div class="container clearfix mt-2">
    <h2 class="title-divider">
        <span>Création du <span class="font-weight-normal text-muted">fichier XML</span>
        <small>Permet de générer un fichier XML permettant le virement des sommes dues aux vendeurs (moins la commission de %. <br />
            Quand le virement est validé, un email est adressé au vendeur.<br /> Tester le fichier XML : <a href="https://www.mesfluxdepaiement.fr/testez-vos-fichiers-sepa" class="btn btn-primary btn-xs" target="_blank">Tester</a></small></span>
    </h2>
</div>
<form method="POST">
    <div class="row">
        <div class="col-12">
            <table class="table">
                <thead class="thead-inverse">
                <tr>
                    <th>Id vendeur</th>
                    <th>Nom vendeur</th>
                    <th>N° Annonce</th>
                    <th>Produit</th>
                    <th>Prix total</th>
                    <th>Rib</th>
                    <th>Action</th>
                    <th>Générer XML</th>
                    <th>Valider virement</th>
                </tr>
                </thead>
                <tbody>
                <?php /** @var $transaction \App\Entity\Transaction */ ?>
                <?php foreach($transactions as $transaction): ?>

                    <tr>
                        <td><?= $transaction->getSeller()->getId() ?></td>
                        <td><?= $transaction->getSeller()->getFirstname() ?> <?= $transaction->getSeller()->getName() ?><br><?= $transaction->getSeller()->getEmail() ?></td>
                        <?php if($transaction->getInvoice()->getAdvert()): ?>
                            <td><?= $transaction->getInvoice()->getAdvert()->getId() ?></td>
                        <?php else: ?>
                            <td>Pas de numéro.</td>
                        <?php endif; ?>
                        <?php if($transaction->getInvoice()->getAdvert()): ?>
                            <td><?= $transaction->getInvoice()->getAdvert()->getTitle() ?></td>
                        <?php else: ?>
                            <td>Pas d'annonce trouvée.</td>
                        <?php endif; ?>
                        <?php if($transaction->getInvoice()->getAdvert()): ?>
                            <td><?= $transaction->getInvoice()->getAdvert()->getPrice() ?>€</td>
                        <?php else: ?>
                            <td>Pas d'annonce trouvée.</td>
                        <?php endif; ?>
                        <td>
                            <?php if($transaction->getVendeur()->getIban() && $transaction->getVendeur()->getBic()): ?> <i class="fa fa-check green" aria-hidden="true"></i> <?= $transaction->getVendeur()->getIban() ?><br /><?= $transaction->getVendeur()->getBic() ?>
                            <?php else : ?> <i class="fa fa-times red" aria-hidden="true"></i> Champs à renseigner<br> Mon compte > Mes données > RIB
                            <?php endif; ?>
                        </td>
                        <td>
                            <a type="button" class="btn btn-icon btn-sm btn-primary text-white connectmembre edit" data-id="<?= $transaction->getVendeur()->getId() ?>" aria-hidden="true"  data-toggle="tooltip" title="Se connecter sur le membre" data-placement="bottom"><i class="fa fa-user-circle-o"></i></a>
                        </td>
                        <td><input class="check1" type="checkbox" name="id_paiement[]" value="<?= $transaction->getId_Paiement() ?>"></td>
                        <td><input class="check2" type="checkbox" name="id_validpaiement[]" value="<?= $transaction->getId_Paiement() ?>"></td>
                    </tr>
                    <script>
                        $('.connectmembre').click(function(){
                            var id_personne = $(this).data('id');
                            $.ajax
                            ({
                                data: {"id_personne": id_personne},
                                type: 'post',
                                success: function(response){
                                    window.location.href = "<?= PATH ?>/home/index";
                                }
                            });
                        });
                    </script>
                <?php endforeach; ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <img class="selectallarrow" width="30" height="20" src="<?= PATH ?>/Public/images/icons/arrow_ltr.png" alt="Pour la sélection : "> <label><input type="checkbox" id="checkAll"> &nbsp;Cocher</label>
                    </td>
                    <td>
                        <img class="selectallarrow" width="30" height="20" src="<?= PATH ?>/Public/images/icons/arrow_ltr.png" alt="Pour la sélection : "> <label><input type="checkbox" id="checkAll2"> &nbsp;Cocher</label>
                    </td>
                </tr>
                </tbody>
            </table>
            <br />
            <br />

            <button type="submit" class="btn btn-primary btn-block center" name="xml">Valider</button>
        </div>
    </div>
</form>
<br />
<div class="alert alert-info" role="alert"> <strong>PROCEDURE:</strong>
    <div class="col-md-6">
        <p>
        <ul>
            <li>Cocher dans &laquo;Générer XML&raquo; les membres à payer.</li>
            <li>S'ils n'ont pas leur RIB rentré correctement, se connecter sur le membre et le faire pour lui</li>
            <li>Cliquer sur le grand bouton &laquo;Valider&raquo; pour générer le fichier XML</li>
        </ul></p>
    </div>
    <div class="col-md-6">

    </div>
</div>
<script>
    $("#checkAll").click(function(){
        $('.check1:checkbox').not(this).prop('checked', this.checked);
    });
    $("#checkAll2").click(function(){
        $('.check2:checkbox').not(this).prop('checked', this.checked);
    });
</script>