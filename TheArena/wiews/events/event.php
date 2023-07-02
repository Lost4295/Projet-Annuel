<?php

require $_SERVER['DOCUMENT_ROOT'] . "/core/functions.php";
$db = connectToDB();
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $name = strip_tags($_GET['id']);
    $query = $db->prepare('SELECT id, name,description, manager_id, shop_id,game, type,image FROM ' . PREFIX . 'events WHERE `id`=:name');
    $query->execute([':name' => $name]);
    $evenement = $query->fetch(PDO::FETCH_ASSOC);
    if (isConnected()) {
        $nquery =  $db->prepare('SELECT * FROM ' . PREFIX . 'users WHERE `email`=:email');
        $nquery->execute([':email' => $_SESSION['email']]);
        $user = $nquery->fetch(PDO::FETCH_ASSOC);
    }
    if (!$evenement) {
        $_SESSION['message'] = "Cet évènement n'existe pas.";
        $_SESSION['message_type'] = "danger";
        header('Location: /');
    } else {
        $tquery = $db->prepare('SELECT * FROM ' . PREFIX . 'events_users WHERE `event_id`=:event_id AND `user_id`=:user_id');
        $tquery->execute([':event_id' => $evenement['id'], ':user_id' => $user['id']]);
        $participation = $tquery->fetch(PDO::FETCH_ASSOC);
    }
} else {
    $_SESSION['message'] = "Cet évènement n'existe pas.";
    $_SESSION['message_type'] = "danger";
    header('Location: /');
}
include $_SERVER['DOCUMENT_ROOT'] . "/core/header.php";
?>

<div class="row">
    <nav class="navbar bar">
        <a title="Accueil" class="btn btn-warning active" href="/event?id=<?php echo $evenement['id']; ?>">Accueil</a>
        <a title="Participants" class="btn btn-warning" href="/event/participants?id=<?php echo $evenement['id'] ?>">Participants</a>
        <a title="Tableau de bord" class="btn btn-warning" href="/event/dashboard?id=<?php echo $evenement['id'] ?>">Tableau de bord</a>
        <a title="Shop" class="btn btn-warning " href="/event/shop?shop=<?php echo $evenement['shop_id'] ?>&id=<?php echo $evenement['id'] ?>">Shop</a>
        <?php if (isConnected() && ($user['id'] == $evenement['manager_id'])) { ?>
            <a title="Gestion de l'évènement" class="btn btn-warning" href="/event/management?id=<?php echo $evenement['id'] ?>">Gestion</a>
        <?php } ?>
    </nav>
</div>
<div class="row">
    <h2>Evenement <?php echo $evenement['name'] ?></h2>
</div>
<div class="row">
    <img style="position: relative; left: 300px; width: 685px; height: 279px;" src="<?php echo $evenement['image'] ?>">
</div>
<div class="row col-3">
    <h4>Informations</h4>
</div>
<div class="row">
    <p><?php echo $evenement['description'] ?></p>
</div>
<div class="col-12 d-flex justify-content-around flex-wrap">
    <?php if (isConnected()){ if ($user['id'] == $evenement['manager_id']) { ?>
        <a title="Créer un tournoi" href="/event/tournament/create?id=<?php echo $evenement['id'] ?>" class="btn btn-warning">Créer un tournoi</a>
    <?php } if (!$participation) { ?>
        <a title="S'inscrire" class="btn btn-warning" href="/event/register?id=<?php echo $evenement['id'] ?>">S'inscrire</a>
    <?php } else { ?>
        <a title="Gérer mon inscription" class="btn btn-warning" href="/event/register?id=<?php echo $evenement['id'] ?>">Gérer mon inscription</a>
    <?php }} ?>
</div>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/core/footer.php" ?>