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
        <a class="btn btn-warning" href="/event?name=<?php echo $event['name'] ?>">Accueil</a>
        <a class="btn btn-warning active" href="/event/participants?name=<?php echo $event['name'] ?>">Participants</a>
        <a class="btn btn-warning" href="/event/dashboard?name=<?php echo $event['name'] ?>">Tableau de bord</a>
        <a class="btn btn-warning " href="/event/shop?shop=<?php echo $event['shop_id'] ?>&name=<?php echo $event['name'] ?>">Shop</a>
        <?php if (isConnected() && ($user['id'] == $event['manager_id'])) { ?>
            <a class="btn btn-warning" href="/event/management?name=<?php echo $event['name'] ?>">Gestion</a>
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
