<?php
session_start();
require $_SERVER['DOCUMENT_ROOT']."/core/functions.php";
require $_SERVER['DOCUMENT_ROOT']."/core/constantes.php";
$db=connectToDB();
$query = $db->prepare("UPDATE ".PREFIX."users SET avatar =:avatar WHERE `id`=:id;");

$query->execute([':id'=>$id,
                ':avatar'=>$_SESSION['avatar']
                ]);

