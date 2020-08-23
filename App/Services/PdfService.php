<?php

namespace App\Services;


use Spipu\Html2Pdf\Exception\ExceptionFormatter;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Html2Pdf;

class PdfService extends Service
{

    public function create($template, array $datas)
    {
        try {
            ob_start();
            include 'App/Views/' . $template . '.php';
            $content = ob_get_clean();

            $html2pdf = new Html2Pdf('P', 'A4', 'fr');
            $html2pdf->pdf->SetAuthor('DOE John');
            $html2pdf->pdf->SetTitle('Devis 14');
            $html2pdf->pdf->SetSubject('Création d\'un Portfolio');
            $html2pdf->pdf->SetKeywords('HTML2PDF, Devis, PHP');
            $html2pdf->setDefaultFont('Arial');
            $html2pdf->writeHTML($content);
            $html2pdf->output('example00.pdf');
        } catch (Html2PdfException $e) {
            $html2pdf->clean();

            $formatter = new ExceptionFormatter($e);
            echo $formatter->getHtmlMessage();
        }
    }
}
