<?php
    require $_SERVER['DOCUMENT_ROOT'].'/wiews/admin/header.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $db=connectToDB();
    $id = strip_tags($_GET['id']);
    $query = $db->prepare("SELECT * FROM ".PREFIX."forums WHERE `author`=:id;");
    $query->execute([':id'=> $id]);
    $resultv = $query->fetch(PDO::FETCH_ASSOC);
    $user =$db->prepare("SELECT scope FROM ".PREFIX."users WHERE id=:id");
    $user->execute([':id'=> $resultv['author']]);
    $result3 = $user->fetch(PDO::FETCH_ASSOC);
    $scope = $result3['scope'];
    $attr = whoIsConnected();
    if ($attr[0]==SUPADMIN || $scope != SUPADMIN){
    } else {
        $_SESSION['message'] = "Vous n'êtes pas autorisé à modifier cet élément.";
        $_SESSION['message_type'] = "danger";
        header("Location: /admin/forums");
    }
    $query = $db->prepare( "DELETE FROM ".PREFIX."forums WHERE `id`=:id;");
    $query->execute([':id'=>$id]);
}
?> <h3 class="text-center m-4"> La modification a été effectuée.</h3>
<a href="admin_forums" class='btn-primary btn my-5'> Retourner à la page de gestion des forums</a>


<?php 
    require $_SERVER['DOCUMENT_ROOT'].'/wiews/admin/footer.php';
