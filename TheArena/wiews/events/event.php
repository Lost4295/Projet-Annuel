<?php

require $_SERVER['DOCUMENT_ROOT'] . "/core/functions.php";
$db = connectToDB();
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $name = strip_tags($_GET['id']);
    $query = $db->prepare('SELECT * FROM ' . PREFIX . 'events WHERE `id`=:name');
    $query->execute([':name' => $name]);
    $event = $query->fetch(PDO::FETCH_ASSOC);
    if (isConnected()) {
        $nquery =  $db->prepare('SELECT * FROM ' . PREFIX . 'users WHERE `email`=:email');
        $nquery->execute([':email' => $_SESSION['email']]);
        $user = $nquery->fetch(PDO::FETCH_ASSOC);
    }
    if (!$event) {
        $_SESSION['message'] = "Cet évènement n'existe pas.";
        $_SESSION['message_type'] = "danger";
        header('Location: /');
        exit();
    } else {
        $tquery = $db->prepare('SELECT * FROM ' . PREFIX . 'events_users WHERE `event_id`=:event_id AND `user_id`=:user_id');
        $tquery->execute([':event_id' => $event['id'], ':user_id' => $user['id']]);
        $participation = $tquery->fetch(PDO::FETCH_ASSOC);
    
    }
} else {
    $_SESSION['message'] = "Cet évènement n'existe pas.";
    $_SESSION['message_type'] = "danger";
    header('Location: /');
    exit();
}
include $_SERVER['DOCUMENT_ROOT'] . "/core/header.php";
?>

<div class="row">
    <nav class="navbar bar">
        <a title="Accueil" class="btn  btn-warning active" href="event?id=<?php echo $event['id']; ?>">Accueil</a>
        <a title="Participants" class="btn btn-warning" href="event_participants?id=<?php echo $event['id'] ?>">Participants</a>
        <a title="Tableau de bord" class="btn btn-warning" href="event_dashboard?id=<?php echo $event['id'] ?>">Tableau de bord</a>
        <a title="Shop" class="btn btn-warning " href="event_shop?shop=<?php echo $event['shop_id'] ?>&id=<?php echo $event['id'] ?>">Shop</a>
        <?php if (isConnected() && ($user['id'] == $event['manager_id'])) { ?>
            <a title="Gestion de l'évènement" class="btn btn-warning" href="event_management?id=<?php echo $event['id'] ?>">Gestion</a>
        <?php } ?>
    </nav>
</div>
<div class="row">
    <h2>Evenement <?php echo $event['name'] ?></h2>
</div>
<div class="row">
    <img style="position: relative; left: 300px; width: 685px; height: 279px;" src="<?php echo $event['image'] ?>">
</div>
<div class="row col-3">
    <h4>Informations</h4>
</div>
<div class="row">
    <p><?php echo $event['description'] ?></p>
</div>
<div class="col-12 d-flex justify-content-around flex-wrap">
    <?php if (isConnected() && ($user['id'] == $event['manager_id'])) { ?>
        <a title="S'inscrire" class="btn btn-warning" href="event_register?id=<?php echo $event['id'] ?>">S'inscrire</a>
        <a title="Créer un tournoi" href="event_tournament_create?id=<?php echo $event['id'] ?>" class="btn btn-warning">Créer un tournoi</a>
    <?php } elseif (isConnected() && !$participation) { ?>
        <a title="S'inscrire" class="btn btn-warning" href="event_register?id=<?php echo $event['id'] ?>">S'inscrire</a>
    <?php } elseif (isConnected() && $participation) { ?>
        <a title="Gérer mon inscription" class="btn btn-warning" href="event_unregister?id=<?php echo $event['id'] ?>">Gérer mon inscription</a>
    <?php } ?>
</div>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/core/footer.php" ?>