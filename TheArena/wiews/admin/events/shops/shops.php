<?php require $_SERVER['DOCUMENT_ROOT']."/wiews/admin/header.php";
$db= connectToDB();
$query = $db->prepare('SELECT * FROM '.PREFIX.'events');
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<h1>Événements</h1>

    <table class="table table-hover table-bordered w-100">
        <thead>
            <th>ID</th>
            <th>Nom</th>
            <th>ID de l'organisateur</th>
            <th>ID du shop</th>
            <th>jeu</th>
            <th>Type</th>
            <th>Actions</th>
        </thead>
        <tbody>
        <?php
            foreach($result as $event){
        ?>
                <tr>
                    <td><?php echo $event['id'] ?></td>
                    <td><?php echo $event['name'] ?></td>
                    <td><?php echo $event['manager_id'] ?></td>
                    <td><?php echo $event['shop_id'] ?></td>
                    <td><?php echo $event['game'] ?></td>
                    <td><?php echo $event['type'] ?></td>
                    <td><a class="btn btn-primary m-1" href="read?id=<?php echo $event['id'] ?>">Voir</a>  <a class="btn btn-primary m-1" href="edit?id=<?php echo $event['id'] ?>">Modifier</a>  <a class="btn btn-primary m-1" href="delete?id=<?php echo $event['id'] ?>">Supprimer</a></td>
                </tr>
        <?php
            }
        ?>
        </tbody>
    </table>
    <a class="btn btn-primary m-1" href="create">Ajouter</a>
    <a class="btn btn-primary m-1" href="admin/shops">Ajouter</a>

<?php require $_SERVER['DOCUMENT_ROOT']."/wiews/admin/footer.php" ?>