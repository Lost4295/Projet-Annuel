<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/core/functions.php';

launchComeBack();
$_SESSION["message_type"] = "success";
$_SESSION["message"] = "Les joueurs ont bien été relancés !";
header('Location: /admin_settings');