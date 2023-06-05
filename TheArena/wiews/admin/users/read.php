<?php
require $_SERVER['DOCUMENT_ROOT']."/core/functions.php";
$db= connectToDB();
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = strip_tags($_GET['id']);
    $query = $db->prepare('SELECT * FROM '.PREFIX.'users WHERE `id`=:id');
    $query->execute([':id'=>$id]);
    $user = $query->fetch();
    if (!$user) {
        header('Location: /admin_users');
    }
} else {
    header('Location: /admin_users');
}
require $_SERVER['DOCUMENT_ROOT']."/wiews/admin/header.php";
?>

			<p>ID : <?php echo $user["id"] ?></p>
			<p>SCOPE : <?php echo formatScope($user["scope"]) ?></p>
			<p>Pseudo : <?php echo $user["username"] ?></p>
			<p>Prénom : <?php echo $user["first_name"] ?></p>
			<p>Nom : <?php echo $user["last_name"] ?></p>
			<p>Email : <?php echo $user["email"] ?></p>
			<p>Téléphone : <?php echo $user["phone"] ?></p>
			<p>Adresse : <?php echo $user["address"] ?></p>
			<p>Département : <?php echo $user["department"] ?></p>
			<p>Date de création : <?php echo $user["creation_date"] ?></p>
			<p>Date de dernière connexion <?php echo $user["last_access_date"] ?></p>
			<p> Date de dernière modification <?php echo $user["update_at"] ?></p>
			<p>Visibilité : <?php echo formatVisibility($user["visibility"]) ?></p>
			<p>Statut : <?php echo formatStatusUsers($user["status"]) ?></p>

    <div>
    <a class="btn btn-primary m-2" href="update?id=<?php echo $user['id']?>">Modifier les données reltives à la personne</a>
    <a class="btn btn-primary m-2" href="changes?id=<?php echo $user['id']?>">Modifier les données concernant le compte</a>
    <a class="btn btn-primary m-2" href="delete?id=<?php echo $user['id']?>">Pseudo suppression</a>
	</div>


	<a class="btn btn-primary m-2" href="removeUser?id=<?php echo $user['id']?>">Supprimer( Attention, cela supprime totalement !)</a>
    <?php require $_SERVER['DOCUMENT_ROOT']."/wiews/admin/footer.php" ;?>