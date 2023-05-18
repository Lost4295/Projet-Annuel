<?php
session_start();
    require $_SERVER['DOCUMENT_ROOT'].'/core/functions.php';

$db= connectToDB();
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = strip_tags($_GET['id']);
    $query = $db->prepare('SELECT * FROM '.PREFIX.'forums WHERE `id`=:id');
    $query->execute([':id'=>$id]);
    $produit = $query->fetch();
    if (!$produit) {
        header('Location: index.php');
    }
} else {
    header('Location: index.php');
}


//TODO : Adapter à chaque catégorie
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des produits</title>

</head>
<body>
    <h1>Détails du produit <?= $produit['produit'] ?></h1>
    <p>ID : <?= $produit['id'] ?></p>
    <p>Produit : <?= $produit['produit'] ?></p>
    <p>Prix : <?= $produit['prix'] ?></p>
    <p>Nombre : <?= $produit['nombre'] ?></p>
    <p><a href="update.php?id=<?= $produit['id'] ?>">Modifier</a>  <a href="delete.php?id=<?= $produit['id'] ?>">Supprimer</a></p>
</body>
</html>