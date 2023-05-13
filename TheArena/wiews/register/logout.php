<?php
session_start();
unset($_SESSION['email']);
unset($_SESSION['login']);
session_unset();
header("Location:../../wiews/index.php");
