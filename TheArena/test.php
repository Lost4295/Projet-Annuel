<?php

// TODO Fais le wkhtmltopdf ylan
$html = '<html><body><h1>Contenu du PDF</h1></body></html>'; // Le contenu HTML à convertir en PDF

$message= $header.$body.$footer;

sendEmail($email, 'Validation du compte The arena', $message);
