<?php require 'header.php' ?>
<?php 
    session_start();
    require 'functions.php';
?>
<?php 
    require 'constantes.php';
    isAdmin();
?>
<!-- Ici mettre toutes les infos concernant un signalement, et un form avec ce qu'on fait :  boutons (oui, ou non) ;
oui ==> modale select (pour les punitions), et textarea (explication de la sentence)  -->
<?php include 'footer.php'?>
