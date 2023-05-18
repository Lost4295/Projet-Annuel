<?php
    require $_SERVER['DOCUMENT_ROOT'].'/wiews/admin/header.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = strip_tags($_GET['id']);
    $db=connectToDB();
    $query = $db->prepare("UPDATE ".PREFIX."users SET visibility =-1, status=-1 WHERE `id`=:id;");

    $query->execute([':id'=>$id]);
}
?>
<h3 class="text-center m-4"> La modification a été effectuée.</h3>
<a href="/admin/users" class='btn-primary btn my-5'> Retourner à la page de gestion des utilisateurs</a>


