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
} else {
    $_SESSION['message'] ='Pas de shop par ici !';
    // header('Location:admin_shops');
}
require $_SERVER['DOCUMENT_ROOT'] . "/wiews/admin/header.php";


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
                    <td><a class="btn btn-primary m-1" href="admin_items_edit?id=<?= $produit['id'] ?>&sid=<?php echo $id?>">Modifier</a>
                    <a class="btn btn-primary m-1" href="admin_items_delete?id=<?= $produit['id'] ?>&sid=<?php echo $id?>">Supprimer</a>
                </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <a class="btn btn-primary m-1" href="admin_items_create?id=<?php echo $id?>">Ajouter un item</a>

    <?php
    require $_SERVER['DOCUMENT_ROOT'] . "/wiews/admin/footer.php";