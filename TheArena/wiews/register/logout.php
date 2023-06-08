<?php
session_start();
session_destroy();
session_unset();
session_start();
$_SESSION['message']="Vous avez été déconnecté.";
header("Location: /");
