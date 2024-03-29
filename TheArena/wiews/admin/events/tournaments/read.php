<?php
require $_SERVER['DOCUMENT_ROOT'] . "/wiews/admin/header.php";

$db = connectToDB();
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = strip_tags($_GET['id']);
    $query = $db->prepare('SELECT * FROM ' . PREFIX . 'tournaments WHERE `id`=:id');
    $query->execute([':id' => $id]);
    $tournament = $query->fetch();
    if (!$tournament) {
        header('Location: /admin/tournaments');
    }
} else {
    header('Location: /admin/tournaments');
}
?>

<body>
    <h1>Détails du tournoi <?php echo $tournament['name'] ?></h1>
    <p>ID : <?php echo $tournament['id'] ?></p>
    <p>Nom : <?php echo $tournament['name'] ?></p>
    <p>Description : <?php echo $tournament['description'] ?></p>
    <p>Prix : <?php echo $tournament['price'] ?></p>
    <p>Date : <?php echo $tournament['date'] ?></p>
    <p> État : <?php echo formatStateTournaments($tournament['state']) ?></p>
    <p>Type d'événement : <?php echo $tournament['event_type'] ?></p>
    <p>Événement : <?php echo formatEventName($tournament['event_id']) ?></p>

    <p> Personnes inscrites : </p>
    <table class='table w-50'>
    <?php
    $query = $db->prepare('SELECT * FROM ' . PREFIX . 'events_users WHERE `tournament_id`=:id');
    $query->execute([':id' => $id]);
    $users = $query->fetchAll(PDO::FETCH_ASSOC);
    foreach ($users as $key => $user) { ?>
    <tr>
        <td><a class="link-dark text-decoration-none" href="/admin/users/read?id=<?php echo $user['user_id'] ?>"><?php echo formatUsers($user['user_id'])?></a></td><td><a href="/admin/tournament/unregister?id=<?php echo $user['user_id'] ?>&tid=<?php echo $tournament['id'] ?>" class="btn btn-primary">Désinscrire <?php echo formatUsers($user['user_id'])?></a></td>
    </tr>
    <?php }
    ?>
    </table>

    <div>
        <a class="btn btn-primary m-2" href="update?id=<?php echo $tournament['id'] ?>">Modifier</a>
        <a class="btn btn-primary m-2" href="delete?id=<?php echo $tournament['id'] ?>">Suppression</a>
    </div>
    <?php require $_SERVER['DOCUMENT_ROOT']."/wiews/admin/footer.php" ?>
