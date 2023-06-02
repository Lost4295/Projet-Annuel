<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/core/functions.php';

$db = connectToDB();
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = strip_tags($_GET['id']);
    $query = $db->prepare('SELECT * FROM ' . PREFIX . 'products WHERE `shop_id`=:id');
    $query->execute([':id' => $id]);
    $produits = $query->fetchAll(PDO::FETCH_ASSOC);
    if (!$produits) {
        echo ' pas de produit';
        // header('Location: index.php');
    }
} else {
    echo ' pas de prosuit';
    // header('Location: index.php');
}
require $_SERVER['DOCUMENT_ROOT'] . "/wiews/admin/header.php";


//TODO : Finir ça ici et faire le nécessaire pour que ce soit good (par exemple la page de modification d'item)
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des produits</title>

</head>

<body>
    <table class="table table-hover table-bordered w-100">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prix</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produits as $produit) { ?>
                <tr>
                    <td><?= $produit['id'] ?></td>
                    <td><?= $produit['nom'] ?></td>
                    <td><?= $produit['prix'] ?></td>
                    <td><?= $produit['description'] ?></td>
                    <td><a class="btn btn-primary m-1" href="/admin/items/modify?id=<?= $produit['id'] ?>">Modifier</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>