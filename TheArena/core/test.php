<?php

require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

$dompdf = new Dompdf();

// TODO  FAIRE LE PDF


$html = '<html><body><h1>Contenu du PDF</h1><p><img src="/img/placeholder_item.jpg"/></p></body></html>'; // Le contenu HTML à convertir en PDF


$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');

$dompdf->render();

$dompdf->stream('fichier.pdf', ['Attachment' => false]);
