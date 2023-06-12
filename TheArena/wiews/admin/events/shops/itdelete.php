<?php
    require $_SERVER['DOCUMENT_ROOT'].'/wiews/admin/header.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $db=connectToDB();
    $id = strip_tags($_GET['id']);
    $query = $db->prepare( "DELETE FROM ".PREFIX."products WHERE `id`=:id;");
    $query->execute([':id'=>$id]);
}
?> <h3 class="text-center m-4"> La modification a été effectuée.</h3>
<a href="/admin_shops" class='btn-primary btn my-5'> Retourner à la page de gestion des shops</a>

<?php 
    require $_SERVER['DOCUMENT_ROOT'].'/wiews/admin/footer.php';