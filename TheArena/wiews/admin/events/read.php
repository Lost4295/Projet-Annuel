<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/wiews/admin/header.php';

$db = connectToDB();
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = strip_tags($_GET['id']);
    $query = $db->prepare('SELECT * FROM ' . PREFIX . 'events WHERE `id`=:id');
    $query->execute([':id' => $id]);
    $event = $query->fetch();
    if (!$event) {
        header('Location: index.php');
    }
} else {
    header('Location: index.php');
}

?>
<h1>Détails de l'évènement <?php echo $event['name'] ?></h1>
<p>ID : <?php echo $event['id'] ?></p>
<p>Nom : <?php echo $event['name'] ?></p>
<p>Description : <?php echo $event['description'] ?></p>
<p> Id de l'organisateur : <?php echo $event['manager_id'] ?></p>
<p> Id du shop : <?php echo ($event['shop_id']) ?? "NULL" ?></p>
<p>Jeu : <?php echo $event['game'] ?></p>
<p>Type : <?php echo $event['type'] ?></p>


<p> Personnes inscrites à l'événement</p>
//TODO accéder aux personnes inscrites
<div>
    <a class="btn btn-primary m-2" href="edit?id=<?php echo $event['id'] ?>">Modifier</a>
    <?php if ($event['shop_id']) {?><a class="btn btn-primary m-2" href="/admin/shop/read?id=<?php echo $event['shop_id'] ?>">Voir le shop associé</a><?php }?>
    <a class="btn btn-primary m-2" href="delete?id=<?php echo $event['id'] ?>">Supprimer</a>
</div>
<?php require $_SERVER['DOCUMENT_ROOT'] . "/wiews/admin/footer.php";
