<?php

require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

$dompdf = new Dompdf();

// TODO: PDF Ok

$image= file_get_contents('bullet.gif');

$imageData = base64_encode($image);

$html = '<html><body><h1>Contenu du PDF</h1><img src="'.$imageData.'"></body></html>'; // Le contenu HTML à convertir en PDF


$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');

$dompdf->render();

$dompdf->stream('fichier.pdf', ['Attachment' => false]);
