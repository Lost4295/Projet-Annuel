<?php 

require $_SERVER['DOCUMENT_ROOT'] . "/core/functions.php";
$db = connectToDB();
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $name = strip_tags($_GET['id']);
    $query = $db->prepare('SELECT * FROM ' . PREFIX . 'events WHERE `id`=:name');
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
        <a title="Accueil" class="btn btn-warning" href="/event?id=<?php echo $evenement['id']; ?>">Accueil</a>
        <a title="Participants" class="btn btn-warning" href="/event/participants?id=<?php echo $evenement['id'] ?>">Participants</a>
        <a title="Tableau de bord" class="btn btn-warning active" href="/event/dashboard?id=<?php echo $evenement['id'] ?>">Tableau de bord</a>
        <a title="Shop" class="btn btn-warning " href="/event/shop?shop=<?php echo $evenement['shop_id'] ?>&id=<?php echo $evenement['id'] ?>">Shop</a>
        <?php if (isConnected() && ($user['id'] == $evenement['manager_id'])) { ?>
            <a title="Gestion de l'évènement" class="btn btn-warning" href="/event/management?id=<?php echo $evenement['id'] ?>">Gestion</a>
        <?php } ?>
    </nav>
</div>
    <div class="row">
        <h2>Tableau de bord</h2>
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
        <a class="btn btn-primary  btn-warning" href="/tournamentClassement.php">Inscrire les scores</a>
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