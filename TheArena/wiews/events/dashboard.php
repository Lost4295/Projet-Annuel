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
$player_id = 2; // Identifiant du joueur

// Requête SQL pour récupérer les matches d'un joueur spécifique
$sql = "SELECT *
        FROM ".PREFIX."matches
        WHERE player1_id = '$player_id' OR player2_id = '$player_id'";
$result = $db->query($sql);
$matches = $result->fetchAll(PDO::FETCH_ASSOC);

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

    <table class="table">
        <thead>
            <tr>
                <th>Match</th>
                <th>Score</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($matches as $match) { ?>
                <tr>
                    <td><?php echo formatUsers($match['player1_id']) . ' vs ' . formatUsers($match['player2_id']); ?></td>
                    <td><?php echo $match['player1_score']??'Pas encore renseigné'; echo ' - '; echo $match['player2_score']??'Pas encore renseigné'; ?></td>
                </tr>
            <?php } ?>
    </table>

<?php require $_SERVER['DOCUMENT_ROOT']."/core/footer.php" ?>