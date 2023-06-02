<?php 

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
        <a class="btn 0btn-warning" href="event?name=<?php echo $event['name'] ?>">Accueil</a>
        <a class="btn btn-warning" href="event_participants?name=<?php echo $event['name'] ?>">Participants</a>
        <a class="btn btn-warning" href="event_dashboard?name=<?php echo $event['name'] ?>">Tableau de bord</a>
        <a class="btn btn-warning " href="event_shop?shop=<?php echo $event['shop_id'] ?>&name=<?php echo $event['name'] ?>">Shop</a>
        <?php if (isConnected() && ($user['id'] == $event['manager_id'])) { ?>
            <a class="btn btn-warning" href="/event/management?name=<?php echo $event['name'] ?>">Gestion</a>
        <?php } ?>
    </nav>
</div>
    <div class="row">
        <h2><u>Tableau de bord<u></h2>
    </div>
    <div class="row border">
        <div class="d-flex align-content-center flex-column flex-wrap">
            contre
        </div>
        <div class="row">
            <div class="col-4 d-flex align-content-center flex-column flex-wrap">
                participant 1 
            </div>       
            <div class="col-4 d-flex align-content-center flex-column flex-wrap">
                <h4>1 - 0</h4>
            </div>    
            <div class="col-4 d-flex align-content-center flex-column flex-wrap">
                participant 2
            </div>
        </div>
    </div>

    
    <div class="col-12 d-flex align-content-center flex-column flex-wrap">
        <a class="btn btn-primary  btn-warning" href="#">Inscrire les scores</a>
    </div>
    <div class="row">
        <div class="border col-6 d-flex align-content-center flex-column flex-wrap">
            info
        </div>
        <div class="border col-6 d-flex align-content-center flex-column flex-wrap  ">
            info
        </div>
    </div>

<?php require $_SERVER['DOCUMENT_ROOT']."/core/footer.php" ?>