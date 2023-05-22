<?php
session_start();
unset($_SESSION);
session_destroy();
session_start();
$_SESSION['message']="Vous avez été déconnecté.";  
header("Location:../../wiews/index.php");
