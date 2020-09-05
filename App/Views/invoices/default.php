<?php $contact = $datas['contact']; $invoice = $datas['transaction']->getInvoice(); $totalPrice = $invoice->getTotalPrice(); ?>
<style type="text/css">
    table {
        width: 100%;
        color: #717375;
        font-family: helvetica;
        line-height: 5mm;
        border-collapse: collapse;
    }
    h2 { margin: 0; padding: 0; }
    p { margin: 5px; }

    .border th {
        border: 1px solid #000;
        color: white;
        background: #000;
        padding: 5px;
        font-weight: normal;
        font-size: 14px;
        text-align: center;
    }

    .none {
        border: none;
        color: red;
    }

    .border td {
        border: 1px solid #CFD1D2;
        padding: 5px 10px;
        text-align: center;
    }
    .no-border {
        border-right: 1px solid #CFD1D2;
        border-left: none;
        border-top: none;
        border-bottom: none;
    }
    .no-boder-left {
        border-left: none;
    }
    .no-boder-right {
        border-right: none;
    }
    .space { padding-top: 100px; }

    .10p { width: 10%; } .15p { width: 15%; }
    .25p { width: 25%; } .50p { width: 50%; }
    .45p { width: 45%; } .60p { width: 60%; }
    .75p { width: 75%; }
</style>
<page backtop="10mm" backleft="10mm" backright="10mm" backbottom="10mm" footer="page;">

    <page_footer>
        <hr />
        <p>CHIRDENT SARL - Dental NetWorks.</p>
        <p>7, rue Jules Michelet 33140 Villenave d'Ornon (FRANCE).</p>
        <p>SIRET: 480-565-969-00015. APE: 6311-Z. </p>
    </page_footer>

    <table style="vertical-align: top;">
        <tr>
            <td class="75p">
                <strong>CHIRDENT SARL</strong>
                <br />
                7 Rue Jules Michelet
                <br />
                33140 Villenave d'Ornon (FRANCE)
                <br />
                +33 (0) 6 58 78 00 26
                <br />
                <strong>N°TVA :</strong> FR14 480 565 969
                <br />
            </td>
            <td class="25p">
                <strong><?= $contact->getUser()->getName(); ?> <?= $contact->getUser()->getFirstName(); ?> </strong><br />
                <?= $contact->getAddress(); ?>
                <br />
                <?= $contact->getPostCode(); ?> <?= $contact->getCity(); ?> (<?= $contact->getCountry()->getLabel(); ?>)
                <br />
            </td>
        </tr>
    </table>

    <table style="margin-top: 50px;">
        <tr>
            <td class="50p"><h2>Facture n°20200001</h2></td>
            <td class="50p" style="text-align: right;">Emis le 24/01/1992</td>
        </tr>
        <tr>
            <td style="padding-top: 15px;" colspan="2"><strong>RÉFÉRENCE:</strong> 20200001</td>
        </tr>
    </table>

    <table style="margin-top: 30px;" class="border">
        <thead>
        <tr>
            <th class="60p">Description</th>
            <th class="10p"></th>
            <th class="15p">Quantité</th>
            <th class="15p">Montant</th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <td class="no-boder-right">Truc</td>
                <td class="no-boder-left"></td>
                <td>1</td>
                <td>
                    <?= $totalPrice ?>€
                </td>
            </tr>

        <tr>
            <td class="no-boder-right space"></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" class="no-border"></td>
            <td style="text-align: center;" rowspan="3"><strong>Total:</strong></td>
            <td>HT : <?= ($totalPrice/1.2) ?>€</td>
        </tr>
        <tr>
            <td colspan="2" class="no-border"></td>
            <td>TVA :  <?= ($totalPrice - $totalPrice/1.2) ?>€</td>
        </tr>
        <tr>
            <td colspan="2" class="no-border"></td>
            <td>TTC :  <?= $totalPrice ?>€</td>
        </tr>
        </tbody>
    </table>
    <br />
    <br />
    <br />
    <br />
    <br />
    <table style="vertical-align: top;">
        <tr>
            <td class="100p">
                <strong>Ce montant correspond au prix d'une annonce urgente. Aucun remboursement n'est effectué. Voir condition d'utilisation.</strong>
                <br />
            </td>
        </tr>
    </table>

</page>