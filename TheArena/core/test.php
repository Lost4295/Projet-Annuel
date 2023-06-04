<?php

require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

$dompdf = new Dompdf();

// TODO: PDF Ok

$html = '<html><body><h1>Contenu du PDF</h1></body></html>'; // Le contenu HTML à convertir en PDF

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');

$dompdf->render();

$dompdf->stream('fichier.pdf', ['Attachment' => false]);
