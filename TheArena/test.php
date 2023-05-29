<?php
phpinfo();

// Fais le wkhtmltopdf ylan
$html = '<html><body><h1>Contenu du PDF</h1></body></html>'; // Le contenu HTML à convertir en PDF

$pdfFilePath = $_SERVER['DOCUMENT_ROOT'].'test.pdf'; // Chemin de destination du fichier PDF

// Construction de la commande wkhtmltopdf
$command = "'C:\Program Files (x86)\wkhtmltopdf\bin\wkhtmltopdf.exe' --encoding UTF-8 --page-size A4 '".$html."' '".$pdfFilePath."'";

// Exécution de la commande
exec($command, $output, $returnVar);
if ($returnVar !== 0) {
    var_dump($output); // Affiche le résultat de la commande
    echo 'Erreur lors de la génération du PDF : ' . implode("\n", $output);
    exit;
}

// Envoi du fichier PDF en tant que réponse HTTP
header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="fichier.pdf"');
readfile($pdfFilePath);
