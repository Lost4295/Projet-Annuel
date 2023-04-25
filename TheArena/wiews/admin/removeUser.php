<?php
session_start();
require " ../conf.inc.php " ;
require " fonctions.php ";


whoIsConnected();


$connect = connectToDB();
$queryPrepared = $connect-> prepare (" DELETE FROM ". PREFIX ."users WHERE id=:id ");
$queryPrepared -> execute ([" id "=> $_GET[ 'id' ]]);

header(" location : users.php");