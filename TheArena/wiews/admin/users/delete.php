<?php
    require $_SERVER['DOCUMENT_ROOT'].'/core/functions.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = strip_tags($_GET['id']);
    $sql = "DELETE FROM `liste` WHERE `id`=:id;";

    $query = $db->prepare($sql);

    $query->execute([':id'=>$id]);

    header('Location: index.php');
}

require_once('close.php');
