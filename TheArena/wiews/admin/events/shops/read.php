<?php
require $_SERVER['DOCUMENT_ROOT'] . '/core/functions.php';

$db = connectToDB();
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = strip_tags($_GET['id']);
    $query = $db->prepare('SELECT * FROM ' . PREFIX . 'products WHERE `shop_id`=:id');
    $query->execute([':id' => $id]);
    $produits = $query->fetchAll(PDO::FETCH_ASSOC);
    $query = $db->prepare('SELECT name FROM ' . PREFIX . 'shops WHERE `id`=:id');
    $query->execute([':id' => $id]);
    $shop = $query->fetch(PDO::FETCH_ASSOC);
    print_r($produits);
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

<body>
    <h1>Liste des produits de <?php echo $shop['name']?></h1>
    <table class="table table-hover table-bordered w-100">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Type</th>
                <th>Prix</th>
                <th>Description</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produits as $produit) { ?>
                <tr>
                    <td><?= $produit['id'] ?></td>
                    <td><?= $produit['nom'] ?></td>
                    <td><?= formatTypeItems($produit['type']) ?></td>
                    <td><?= $produit['price'] ?></td>
                    <td><?= $produit['description'] ?></td>
                    <td><img src="<?= $produit['image'] ?>" width="70"></td>
                    <td><a class="btn btn-primary m-1" href="/admin/items/edit?id=<?= $produit['id'] ?>">Modifier</a>
                    <a class="btn btn-primary m-1" href="/admin/items/delete?id=<?= $produit['id'] ?>">Supprimer</a>
                </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <a class="btn btn-primary m-1" href="/admin/items/create">Ajouter un item</a>
</body>

</html>