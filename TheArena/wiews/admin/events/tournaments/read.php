<?php
require $_SERVER['DOCUMENT_ROOT'] . "/wiews/admin/header.php";

$db= connectToDB();
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = strip_tags($_GET['id']);
    $query = $db->prepare('SELECT * FROM '.PREFIX.'tournaments WHERE `id`=:id');
    $query->execute([':id'=>$id]);
    $tournament = $query->fetch();
    if (!$tournament) {
        header('Location: /admin/tournaments');
    }
} else {
    header('Location: /admin/tournaments');
}
?>

<body>
    <h1>Détails du tournament <?php echo $tournament['name'] ?></h1>
    <p>ID : <?php echo $tournament['id'] ?></p>
    <p>Nom : <?php echo $tournament['name'] ?></p>
    <p>Description : <?php echo $tournament['description'] ?></p>
    <p>Prix : <?php echo $tournament['price'] ?></p>
        <p>Date : <?php echo $tournament['date'] ?></p>
        <p>Type d'événement : <?php echo $tournament['event_type'] ?></p>
        <p>Événement : <?php echo formatEventName($tournament['event_id'])?></p>
    <div>
    <a class="btn btn-primary m-2" href="update?id=<?php echo $tournament['id']?>">Modifier</a>
    <a class="btn btn-primary m-2" href="delete?id=<?php echo $tournament['id']?>">Suppression</a>
	</div></body>
</html>