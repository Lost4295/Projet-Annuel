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
        <a title="Accueil" class="btn btn-warning" href="event?id=<?php echo $event['id']; ?>">Accueil</a>
        <a title="Participants" class="btn btn-warning active" href="event_participants?id=<?php echo $event['id'] ?>">Participants</a>
        <a title="Tableau de bord" class="btn btn-warning" href="event_dashboard?id=<?php echo $event['id'] ?>">Tableau de bord</a>
        <a title="Shop" class="btn btn-warning " href="event_shop?shop=<?php echo $event['shop_id'] ?>&id=<?php echo $event['id'] ?>">Shop</a>
        <?php if (isConnected() && ($user['id'] == $event['manager_id'])) { ?>
            <a title="Gestion" class="btn btn-warning" href="/event_management?id=<?php echo $event['id'] ?>">Gestion</a>
        <?php } ?>
    </nav>
</div>
    <div class="row">
        <h2>Participants</h2>
    </div>
    <div class="row ">
        <table class="d-flex align-content-center flex-column flex-wrap table table-striped">
            <tbody>
                <tr>
                    <td>
                        participant 1
                    </td>
                    <td>
                        contre
                    </td>
                    <td>
                        participant 2
                    </td>
                </tr>
                <tr>
                    <td>
                        participant 3
                    </td>
                    <td>
                        contre
                    </td>
                    <td>
                        participant 4
                    </td>
                </tr>
                <tr>
                    <td>
                        participant 5
                    </td>
                    <td>
                        contre
                    </td>
                    <td>
                        participant 6
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

<?php require $_SERVER['DOCUMENT_ROOT']."/core/footer.php" ?>
