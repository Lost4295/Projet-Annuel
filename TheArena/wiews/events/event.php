<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require $_SERVER['DOCUMENT_ROOT'] . "/core/functions.php";
$db = connectToDB();
if (isset($_GET['name']) && !empty($_GET['name'])) {
    $name = strip_tags($_GET['name']);
    $query = $db->prepare('SELECT * FROM ' . PREFIX . 'events WHERE `name`=:name');
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
    } else {
        $tquery = $db->prepare('SELECT * FROM ' . PREFIX . 'events_users WHERE `event_id`=:event_id AND `user_id`=:user_id');
        $tquery->execute([':event_id' => $event['id'], ':user_id' => $user['id']]);
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
        <a class="btn btn-warning active" href="/event?name=<?php echo $event['name'] ?>">Accueil</a>
        <a class="btn btn-warning" href="/event/participants?name=<?php echo $event['name'] ?>">Participants</a>
        <a class="btn btn-warning" href="/event/dashboard?name=<?php echo $event['name'] ?>">Tableau de bord</a>
        <a class="btn btn-warning " href="/event/shop?shop=<?php echo $event['shop_id'] ?>&name=<?php echo $event['name'] ?>">Shop</a>
        <?php if (isConnected() && ($user['id'] == $event['manager_id'])) { ?>
            <a class="btn btn-warning" href="/event/management?name=<?php echo $event['name'] ?>">Gestion</a>
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
        <a class="btn btn-warning" href="/event/register?name=<?php echo $event['name'] ?>">S'inscrire</a>
        <a href="/event/tournament/create?name=<?php echo $event['name'] ?>" class="btn btn-warning">Créer un tournoi</a>
    <?php } elseif (isConnected() && $participation) { ?>
        <a class="btn btn-warning" href="/event/register?name=<?php echo $event['name'] ?>">S'inscrire</a>
    <?php } elseif (isConnected() && $participation) { ?>
    <a class="btn btn-warning" href="/event/register?name=<?php echo $event['name'] ?>">Se désinscrire</a>
    <?php } ?>
</div>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/core/footer.php" ?>