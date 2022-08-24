<?php

namespace App\Controller;

use App\Entity\Advert;
use App\Entity\Invoice;
use App\Entity\Transaction;
use App\Services\AdvertService;
use App\Services\TranslationsService;
use App\Services\UserService;
use Core\Controller\Controller;

class AdminController extends Controller
{
    public function __construct(\AltoRouter $router)
    {
        parent::__construct($router);
        //if is not logged admin, then acces denied in env prod
        if (ENV !== 'dev') {
            if(!$this->twig->loggedAdmin()){
                $this->denied();
            }
        }
    }

    public function index()
    {
        $this->template = 'admin';
        $this->render('admin/index');
    }

    public function translations()
    {
        if('POST' === $this->request->getMethod()) {
            /** @var TranslationsService $translationsService */
            $translationsService = $this->services->getService('translations');
            $id = $this->request->get('id');
            $id_delete = $this->request->get('id_delete');
            $search = $this->request->get('search');

            if($id) {
                $name = $this->request->get('name');
                $fr = $this->request->get('fr');
                $en = $this->request->get('en');
                $translationsService->updateTranslation($id, $name, $fr, $en);
            }

            if($this->request->get('add')) {
                $name = $this->request->get('name');
                $fr = $this->request->get('fr');
                $en = $this->request->get('en');
                $translationsService->addTranslation($name, $fr, $en);
            }

            if($id_delete) {
                $translationsService->removeTranslation($id_delete);
            }

            if($search) {
                $translations = $this->services->getRepository('translations')->findTranslation($search);
                $this->template = 'disable';
                $this->render('admin/translations-data-display', compact('translations'));
                die;
            }
        }

        $this->template = 'admin';
        $this->render('admin/translations');
    }

    public function users()
    {
        $userRepo = $this->services->getRepository('user');
        $userService = $this->services->getService('user');
        $users = [];

        if ('POST' === $this->request->getMethod()) {
            $id = $this->request->get('login');

            if(isset($id)) {
                $userService->loginAdmin($id);
                $this->redirect('index');
            }

            if($this->request->get('search')) {
                $name = $this->request->get('name');
                $email = $this->request->get('email');
                $id = $this->request->get('id');
                $users = $userRepo->search($name, $email, (int) $id);
            }
        }

        $this->template = 'admin';
        $this->render('admin/users', compact('users'));
    }

    public function adverts()
    {
        $advertRepo = $this->services->getRepository('advert');
        $adverts = $advertRepo->findBy(['status' => Advert::STATUS_PENDING]);

        if ('POST' === $this->request->getMethod()) {

            /** @var AdvertService */
            $advertService = $this->services->getService('advert');

            if ($this->request->get('validate')) {
                $advertService->validateAdmin($this->request->get('validate'));
            }

            if ($this->request->get('delete')) {
                $advertService->deleteAdmin($this->request->get('delete'));
            }

            if($this->request->get('user-login')) {
                /** @var UserService */
                $this->services->getService('user')->loginAdmin($this->request->get('user-login'));
                $this->redirect('index');
            }
        }

        $this->template = 'admin';
        $this->render('admin/adverts', compact('adverts'));
    }

    public function relog()
    {
        $_SESSION['user_id'] = $_SESSION['edit_admin_id'];
        unset($_SESSION['edit_admin_id']);
        $this->redirect('index');
    }

    public function invoices()
    {
        $invoices = $this->services->getRepository('invoice')->findBy(['status' => Invoice::STATUS_CLEARED]);
        $this->template = 'admin';
        $this->render('admin/invoices', compact('invoices'));
    }

    public function xml() {

        $transactions = $this->services->getRepository('transactions')->findBy([Transaction::STATUS_FINISHED]);
        if(isset($_POST['xml'])) {
            if(isset($_POST['id_paiement'])) {
                $total = 0;

                $d = new \DateTime();


                if(isset($_POST['date'])) {
                    $newdate = new \DateTime($_POST['date']);
                    $date = $newdate->format('Y-m-d');
                } else {
                    $date = $d->format('Y-m-d');
                }

                $content = '<?xml version="1.0" encoding="UTF-8"?>
<Document xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="urn:iso:std:iso:20022:tech:xsd:pain.001.001.03">
 <CstmrCdtTrfInitn>
  <GrpHdr>
   <MsgId>SCT REMITT '.$d->format('Ymd').'</MsgId>
   <CreDtTm>'.$d->format('Y-m-d\TH:i:s').'</CreDtTm>
   <NbOfTxs>'.count($_POST['id_paiement']).'</NbOfTxs>
   <CtrlSum>'.number_format($total,2, '.', '').'</CtrlSum>
   <InitgPty>
    <Nm>CHIRDENT</Nm>
   </InitgPty>
  </GrpHdr>
  <PmtInf>
   <PmtInfId>'.$d->format('Y-m-d').' - Occasion-Dentaire.com</PmtInfId>
   <PmtMtd>TRF</PmtMtd>
   <BtchBookg>true</BtchBookg>
   <NbOfTxs>'.count($_POST['id_paiement']).'</NbOfTxs>
   <CtrlSum>'.number_format($total,2, '.', '').'</CtrlSum>
   <PmtTpInf>
    <SvcLvl>
     <Cd>SEPA</Cd>
    </SvcLvl>
   </PmtTpInf>
   <ReqdExctnDt>'.$date.'</ReqdExctnDt>
   <Dbtr>
    <Nm>CHIRDENT</Nm>
    <PstlAdr>
     <PstCd>33140</PstCd>
     <TwnNm>VILLENAVE ORNON</TwnNm>
     <Ctry>FR</Ctry>
     <AdrLine>7 rue Jules michelet</AdrLine>
    </PstlAdr>
    <CtryOfRes>FR</CtryOfRes>
   </Dbtr>
   <DbtrAcct>
    <Id>
     <IBAN>FR7615589335640685480234320</IBAN>
    </Id>
    <Ccy>EUR</Ccy>
   </DbtrAcct>
   <DbtrAgt>
    <FinInstnId>
     <BIC>CMBRFR2BARK</BIC>
    </FinInstnId>
   </DbtrAgt>
   <ChrgBr>SLEV</ChrgBr>';


                foreach ($_POST['id_paiement'] as $key => $id) {

                    $req = SPDO::getInstance()->prepare('SELECT * FROM od_paiementannonce WHERE etat_paiement = 3 AND virement IS NULL AND id_paiement = ? ORDER BY date_paiementannonceod');
                    $req->execute(array($id));
                    $data = $req->fetch(\PDO::FETCH_OBJ);
                    $transaction = New Transaction($data);
                    $user = $transaction->getVendeur();
                    $annonceod = $transaction->getAnnonceod();
                    $prix = $annonceod->getPrix_annonce();
                    if($annonceod->getCoutexpedition()) {
                        $acheteur = $annonceod->getPaiement()->getAcheteur();
                        $vendeur = $annonceod->getPersonne();
                        $array = $annonceod->getCoutexpedition()->getArraySurcoutExpe();
                        $paysrepo = new \App\Model\PaysRepository();
                        if($vendeur->getPays()->getIdPays() != $acheteur->getPays()->getIdPays()) {
                            foreach($array as $keyz => $value){
                                $sousPays = $paysrepo->getPaysFromContinent($keyz);
                                foreach($sousPays as $keys => $item) {
                                    if($keys != $acheteur->getPays()->getIdPays()) {
                                        $prix = $annonceod->getPrix_annonce() + $annonceod->getCoutexpedition()->getCoutFromContinent($keyz);
                                    }
                                }
                            }
                        }
                    }

                    $prixfac = round($prix*(COMSITE/100),2);

                    $req = SPDO::getInstance()->prepare('SELECT * FROM facture WHERE id_personne = ? AND prix LIKE "%'.$prixfac.'%" ');
                    $req->execute(array($transaction->getId_Vendeur()));
                    $res = $req->fetch(\PDO::FETCH_OBJ);

                    $prix = $prix - $prix*(COMSITE/100);

                    $content .= '   <CdtTrfTxInf>
    <PmtId>
     <InstrId>Virement vendeur</InstrId>
     <EndToEndId>Vente annonce '.$annonceod->getId_annonceod().'</EndToEndId>
    </PmtId>
    <Amt>
     <InstdAmt Ccy="EUR">'.number_format($prix,2, '.', '').'</InstdAmt>
    </Amt>
    <CdtrAgt>
     <FinInstnId>
      <BIC>'.$user->getBic().'</BIC>
     </FinInstnId>
    </CdtrAgt>
    <Cdtr>
     <Nm>'.$this->enleverCaracteresSpeciaux($user->getNom().' '.$user->getPrenom()).'</Nm>
     <PstlAdr>
      <PstCd>'.$user->getCodepostal().'</PstCd>
      <TwnNm> '.$this->enleverCaracteresSpeciaux($user->getVille()).'</TwnNm>
      <Ctry>'.strtoupper($user->getPays()->getCodePays()).'</Ctry>
      <AdrLine>'.$this->enleverCaracteresSpeciaux($user->getAdresse()).'</AdrLine>
      <AdrLine>'.$this->enleverCaracteresSpeciaux($user->getCodepostal().' '.$user->getVille()).'</AdrLine>
     </PstlAdr>
     <Id>
      <OrgId>
       <Othr>
        <Id>Id membre : '.$user->getId().'</Id>
        <SchmeNm>
         <Cd>SRET</Cd>
        </SchmeNm>
       </Othr>
      </OrgId>
     </Id>
     <CtryOfRes>'.strtoupper($user->getPays()->getCodePays()).'</CtryOfRes>
    </Cdtr>
    <CdtrAcct>
     <Id>
      <IBAN>'.$user->getIban().'</IBAN>
     </Id>
    </CdtrAcct>
   </CdtTrfTxInf>';
                }

                $content .= '
  </PmtInf>
 </CstmrCdtTrfInitn>
</Document>';
                $file = 'Public/xml/sepa_xml_'.$d->format('Ymd').'.xml';
                file_put_contents($file, $content);

                header('Content-type: text/xml');
                header('Content-Disposition: attachment; filename="sepa_xml_Virement_'.$d->format('Ymd').'.xml"');
                readfile($file);
                die;
            }
            if(isset($_POST['id_validpaiement'])) {

                foreach ($_POST['id_validpaiement'] as $id) {
                    //$adminrepo->setVirement($id);

                    $req = SPDO::getInstance()->prepare('SELECT * FROM od_paiementannonce WHERE id_paiement = ?');
                    $req->execute(array($id));
                    $data = $req->fetch(\PDO::FETCH_OBJ);
                    $transaction = New Transaction($data);
                    $personne = $transaction->getVendeur();

                    $mail= new \PHPMailer();
                    //$mail->isSMTP();
                    //$mail->SMTPAuth = true;
                    $mail->CharSet = 'UTF-8';
                    $mail->Debugoutput = 'html';
                    $mail->Host = HOSTMAIL;
                    $mail->Port = 587;
                    $mail->Username = USERMAIL;
                    $mail->Password = PASSWORDMAIL;
                    $mail->AddCustomHeader("List-Unsubscribe:<https://www.sites-chirdent.net>,<mailto:webmaster@sites-chirdent.net>");
                    $mail->setFrom('webmaster@sites-chirdent.net', '['.VARWEB.']');
                    $mail->addAddress($personne->getEmail(), $personne->getNom().' '.$personne->getPrenom());
                    $mail->Subject = 'Confirmation inscription ' . VARWEB;
                    $message = file_get_contents(PATH . '/App/Views/Mails/home.html');
                    $message = str_replace('%pub%', PUB, $message);
                    $message = str_replace('%unsubscribe%', PATH . '/home/index', $message);
                    $message = str_replace('%titre%', 'Virement suite à votre vente '.VARWEB.'', $message);
                    $message = str_replace('%content%', 'Cher(e) membre, <br /> Le virement pour la vente de votre annonce n° '.$transaction->getAnnonceod()->getId_annonceod().' va être effectué sur votre compte bancaire dans les prochains jours. <br /><br />Bien cordialement,', $message);
                    $mail->MsgHTML($message);
                    //send the message, check for errors
                    if (!$mail->send()) {
                        echo "Mailer Error: " . $mail->ErrorInfo;
                    }
                }
                header('Location: ' . PATH . '/admin/xml');
            }

        }

        $this->template = 'templateAdmin';
        $this->render('Admin/xml', compact('transactions'));
    }
}
