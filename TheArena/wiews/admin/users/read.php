<?php
session_start();
require $_SERVER['DOCUMENT_ROOT']."/wiews/admin/header.php";

$db= connectToDB();
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = strip_tags($_GET['id']);
    $query = $db->prepare('SELECT * FROM '.PREFIX.'users WHERE `id`=:id');
    $query->execute([':id'=>$id]);
    $user = $query->fetch();
    if (!$user) {
        header('Location: index.php');
    }
} else {
    header('Location: index.php');
}

require_once('close.php');

//TODO : Adapter à chaque catégorie
?>

			<p>ID : <?php echo $user["id"] ?></p>
			<p>SCOPE : <?php echo $user["scope"] ?></p>
			<p>Pseudo : <?php echo $user["username"] ?></p>
			<p>Prénom : <?php echo $user["first_name"] ?></p>
			<p>Nom : <?php echo $user["last_name"] ?></p>
			<p>Email : <?php echo $user["email"] ?></p>
			<p>Téléphone : <?php echo $user["phone"] ?></p>
			<p>Adresse : <?php echo $user["address"] ?></p>
			<p>Code postal : <?php echo $user["postal_code"] ?></p>
			<p>Pays : <?php echo $user["country"] ?></p>
			<p>Date de création : <?php echo $user["creation_date"] ?></p>
			<p>Date de dernière connexion <?php echo $user["last_access_date"] ?></p>
			<p> Date de dernière modification <?php echo $user["update_at"] ?></p>
			<p>Visibilité : <?php echo $user["visibility"] ?></p>
			<p>Statut : <?php echo $user["status"] ?></p>

    <p><a href="update.php?id=<?= $produit['id'] ?>">Modifier</a>  <a href="delete.php?id=<?= $produit['id'] ?>">Supprimer</a></p>
    <?php require $_SERVER['DOCUMENT_ROOT']."/wiews/admin/footer.php" ?>