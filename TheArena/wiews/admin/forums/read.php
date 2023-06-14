<?php
require $_SERVER['DOCUMENT_ROOT'] . "/wiews/admin/header.php";

$db= connectToDB();
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = strip_tags($_GET['id']);
    $query = $db->prepare('SELECT * FROM '.PREFIX.'forums WHERE `id`=:id');
    $query->execute([':id'=>$id]);
    $forum = $query->fetch();
    if (!$forum) {
        header('Location: /admin/forums');
    }
} else {
    header('Location: /admin/forums');
}
?>

<body>
    <h1>Détails du forum <?php echo $forum['name'] ?></h1>
    <p>ID : <?php echo $forum['id'] ?></p>
    <p>Nom : <?php echo $forum['name'] ?></p>
    <p>Description : <?php echo $forum['description'] ?></p>
    <p>Date de création : <?php echo $forum['date_creation'] ?></p>
    <p>Statut : <?php echo formatStatusForums($forum['status']) ?></p>
    <p>Auteur : <?php echo formatUsers($forum['author']) ?></p>
    <div>
    <a class="btn btn-primary m-2" href="update?id=<?php echo $forum['id']?>">Modifier</a>
    <a class="btn btn-primary m-2" href="status?id=<?php echo $forum['id']?>">Changer le statut</a>
    <a class="btn btn-primary m-2" href="delete?id=<?php echo $forum['id']?>">Suppression</a>
	</div>
<?php require $_SERVER['DOCUMENT_ROOT']."/wiews/admin/footer.php" ?>
