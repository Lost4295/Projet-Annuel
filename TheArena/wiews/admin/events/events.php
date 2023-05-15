<?php require $_SERVER['DOCUMENT_ROOT']."/wiews/admin/header.php";
$db= connectToDB();
$query = $db->prepare('SELECT * FROM '.PREFIX.'events');
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<h1>Événements</h1>

<table class="table table-hover table-bordered w-100">
    <thead>
        <th>Nom</th>
        <th>Salle</th>
        <th>Tournois</th>
        <th>Contenu</th>
        <th>Actions</th>
    </thead>
    <tbody>
        <tr>
            <td><span class="placeholder col-10"></span></td>
            <td><span class="placeholder col-10"></span></td>
            <td><span class="placeholder col-10"></span></td>
            <td><span class="placeholder col-10"></span></td>
            <td><span class="btn btn-primary placeholder col-10"></span></td>
        </tr>
        <tr>
            <td><span class="placeholder col-10"></span></td>
            <td><span class="placeholder col-10"></span></td>
            <td><span class="placeholder col-10"></span></td>
            <td><span class="placeholder col-10"></span></td>
            <td><span class=" btn btn-primary placeholder col-10"></span></td>
        </tr>
        <tr>
            <td><span class="placeholder col-10"></span></td>
            <td><span class="placeholder col-10"></span></td>
            <td><span class="placeholder col-10"></span></td>
            <td><span class="placeholder col-10"></span></td>
            <td><span class="btn btn-primary placeholder col-10"></span></td>
        </tr>
    </tbody>
</table>

 //TODO à fusionner quand on aura des objets en base
<h1>Liste des produits</h1>
    <table>
        <thead>
            <th>ID</th>
            <th>Nom</th>
            <th>Prix</th>
            <th>Stock</th>
            <th>Actions</th>
        </thead>
        <tbody>
        <?php
            foreach($result as $produit){
        ?>
                <tr>
                    <td><?= $produit['id'] ?></td>
                    <td><?= $produit['produit'] ?></td>
                    <td><?= $produit['prix'] ?></td>
                    <td><?= $produit['nombre'] ?></td>
                    <td><a href="read.php?id=<?= $produit['id'] ?>">Voir</a>  <a href="edit.php?id=<?= $produit['id'] ?>">Modifier</a>  <a href="delete.php?id=<?= $produit['id'] ?>">Supprimer</a></td>
                </tr>
        <?php
            }
        ?>
        </tbody>
    </table>
    <a href="create.php">Ajouter</a>

<?php require $_SERVER['DOCUMENT_ROOT']."/wiews/admin/footer.php" ?>
