<?php
    require $_SERVER['DOCUMENT_ROOT'].'/wiews/admin/header.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $db=connectToDB();
    $id = strip_tags($_GET['id']);
    $query = $db->prepare("SELECT * FROM ".PREFIX."events WHERE `id`=:id;");
    $query->execute([':id'=> $id]);
    $result2 = $query->fetch(PDO::FETCH_ASSOC);
    $user =$db->prepare("SELECT scope FROM ".PREFIX."users WHERE id=:id");
    $user->execute([':id'=> $result2['manager_id']]);
    $result3 = $user->fetch(PDO::FETCH_ASSOC);
    $scope = $result3['scope'];
    $attr = whoIsConnected();
    if ($attr[0]==SUPADMIN || $scope != SUPADMIN){
    $query = $db->prepare( "DELETE FROM ".PREFIX."events WHERE `id`=:id;");
    $query->execute([':id'=>$id]);
    } else {
        $_SESSION['message'] = "Vous n'êtes pas autorisé à modifier cet événement.";
        $_SESSION['message_type'] = "danger";
        header("Location: /admin/events");
    }

}
?> <h3 class="text-center m-4"> La modification a été effectuée.</h3>
<a href="/admin/events" class='btn-primary btn my-5'> Retourner à la page de gestion des événements</a>

<?php 
    require $_SERVER['DOCUMENT_ROOT'].'/wiews/admin/footer.php';
