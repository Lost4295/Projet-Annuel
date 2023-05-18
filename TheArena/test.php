<?php

require 'core/templateMail/verificationMail.php';
require 'core/functions.php';

$message= $header.$body.$footer;
sendEmail($email, 'Validation du compte The arena', $message);