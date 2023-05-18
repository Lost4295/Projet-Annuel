<?php require $_SERVER['DOCUMENT_ROOT']."/wiews/admin/header.php";
$db= connectToDB();
$query = $db->prepare('SELECT * FROM '.PREFIX.'forums');
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Forums</h1>
<table class="table table-hover table-bordered w-100">
    <thead>
        <th>Nom</th>
        <th>Description</th>
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


//TODO à fusionner quand on aura des objets en basevcvf
<h1>Liste des produits</h1>
    <table class="table table-hover table-bordered w-100">
        <thead>
            <th>ID</th>
            <th>Nom</th>
            <th>Prix</th>
            <th>Stock</th>
            <th>Actions</th>
        </thead>
        <tbody>
        <?php
            foreach($result as $event){
        ?>
                <tr>
                    <td><?= $event['id'] ?></td>
                    <td><?= $event['event'] ?></td>
                    <td><?= $event['prix'] ?></td>
                    <td><?= $event['nombre'] ?></td>
                    <td><a href="read.php?id=<?= $event['id'] ?>">Voir</a>  <a href="edit.php?id=<?= $event['id'] ?>">Modifier</a>  <a href="delete.php?id=<?= $event['id'] ?>">Supprimer</a></td>
                </tr>
        <?php
            }
        ?>
        </tbody>
    </table>
    <a href="create.php">Ajouter</a>

<?php require $_SERVER['DOCUMENT_ROOT']."/wiews/admin/footer.php" ?>