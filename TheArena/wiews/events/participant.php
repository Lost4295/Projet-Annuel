<?php 

require $_SERVER['DOCUMENT_ROOT'] . "/core/formatter.php";
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
        <a title="Participants" class="btn btn-warning active" href="/event/participants?id=<?php echo $evenement['id'] ?>">Participants</a>
        <a title="Tableau de bord" class="btn btn-warning" href="/event/dashboard?id=<?php echo $evenement['id'] ?>">Tableau de bord</a>
        <a title="Shop" class="btn btn-warning " href="/event/shop?shop=<?php echo $evenement['shop_id'] ?>&id=<?php echo $evenement['id'] ?>">Shop</a>
        <?php if (isConnected() && ($user['id'] == $evenement['manager_id'])) { ?>
            <a title="Gestion" class="btn btn-warning" href="/event/management?id=<?php echo $evenement['id'] ?>">Gestion</a>
        <?php } ?>
    </nav>
</div>
    <div class="row">
        <h2>Participants à l'événement </h2>
    </div>
    <div class="row">
        <table class="table table-striped table-bordered w-75 m-5">
            <thead>
                <tr>
                    <th>
                        Pseudo
                    </th>
                    <th>
                        Tournoi
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = $db->prepare('SELECT * FROM ' . PREFIX . 'events_users WHERE `event_id`=:id');
                $query->execute([':id' => $evenement['id']]);
                $participants = $query->fetchAll(PDO::FETCH_ASSOC);
                foreach ($participants as $participant) {
                    ?>
                    <tr>
                        <td>
                            <?php echo formatUsers($participant['user_id']); ?>
                        </td>
                        <td>
                            <?php echo formatTournamentName($participant['tournament_id']); ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <!-- <table class="d-flex align-content-center flex-column flex-wrap table table-striped">
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
        </table>-->
    </div> 

    <?php

    ?>

<?php require $_SERVER['DOCUMENT_ROOT']."/core/footer.php" ?>
