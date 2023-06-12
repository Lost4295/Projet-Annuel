<?php require $_SERVER['DOCUMENT_ROOT'] . "/wiews/admin/header.php";
$db = connectToDB();
$query = $db->query('SELECT * FROM ' . PREFIX . 'forums');
$result = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Forums</h1>
<table class="table table-hover table-bordered w-100">
    <thead>
        <th>ID</th>
        <th>Nom</th>
        <th>Description</th>
        <th>Date de création</th>
        <th>Statut</th>
        <th>Auteur</th>
        <th>Actions</th>
    </thead>
    <tbody>
        <?php
        foreach ($result as $forum) {
        ?>
            <tr>
                <td><?php echo $forum['id'] ?></td>
                <td><?php echo $forum['name'] ?></td>
                <td><?php echo $forum['description'] ?></td>
                <td><?php echo $forum['date_creation'] ?></td>
                <td><?php echo formatStatusForums($forum['status']) ?></td>
                <td><?php echo findUserById($forum['author']) ?></td>
                <td><a class="btn btn-primary m-1" href="admin_forum_read?id=<?php echo $forum['id'] ?>">Voir</a> <a class="btn btn-primary m-1" href="admin_forum_update?id=<?php echo $forum['id'] ?>">Modifier</a> <a class="btn btn-primary m-1" href="admin_forum_delete?id=<?php echo $forum['id'] ?>">Supprimer</a></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
<a href="admin_forum_create" class="btn btn-primary m-1">Ajouter</a>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/wiews/admin/footer.php" ?>