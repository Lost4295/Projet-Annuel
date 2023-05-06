<?php
session_start();
require " ../conf.inc.php " ;
require " fonctions.php ";


redirectIfNotAdmin();


$connect = connectToDB();
$queryPrepared = $connect-> prepare (" DELETE FROM ". PREFIX ."users WHERE id=:id ");
$queryPrepared -> execute ([" id "=> $_GET[ 'id' ]]);

header(" location : users.php");