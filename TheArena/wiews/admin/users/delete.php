<?php
    require $_SERVER['DOCUMENT_ROOT'].'/core/functions.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = strip_tags($_GET['id']);

    $query = $db->prepare("UPDATE FROM ".PREFIX."users SET visibility=-1 and status=-1 WHERE `id`=:id;");

    $query->execute([':id'=>$id]);

    header('Location: index.php');
}


