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

    <div>
    <a class="btn btn-primary m-2" href="update?id=<?php echo $user['id']?>">Modifier les données reltives à la personne</a>
    <a class="btn btn-primary m-2" href="update?id=<?php echo $user['id']?>">Modifier les données concernant le compte</a>
    <a class="btn btn-primary m-2" href="delete.php?id=<?php echo $user['id']?>">Pseudo suppression</a>
	</div>


	<a class="btn btn-primary m-2" href="removeUser.php?id=<?php echo $user['id']?>">Supprimer( Attention, cela supprime totalement !)</a>
    <?php require $_SERVER['DOCUMENT_ROOT']."/wiews/admin/footer.php" ;?>