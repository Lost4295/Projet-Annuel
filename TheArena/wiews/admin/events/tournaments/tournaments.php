<?php require $_SERVER['DOCUMENT_ROOT'] . "/wiews/admin/header.php";
$db = connectToDB();
$query = $db->query('SELECT * FROM ' . PREFIX . 'tournaments');
$result = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>tournaments</h1>
<table class="table table-hover table-bordered w-100">
    <thead>
        <th>ID</th>
        <th>Nom</th>
        <th>Description</th>
        <th>Prix</th>
        <th>Date</th>
        <th>État</th>
        <th>Type d'événement</th>
        <th>Événement</th>
        <th>Actions</th>
    </thead>
    <tbody>
        <?php
        foreach ($result as $tournament) {
        ?>
            <tr>
                <td><?php echo $tournament['id'] ?></td>
                <td><?php echo $tournament['name'] ?></td>
                <td><?php echo $tournament['description'] ?></td>
                <td><?php echo $tournament['price'] ?> €</td>
                <td><?php echo $fmt->format(date_create_from_format('Y-m-d H:i:s', $tournament['date']))."<br>(".$tournament['date'].")" ?></td>
                <td><?php echo formatStateTournaments($tournament['state']) ?></td>
                <td><?php echo formatTypePriceEvents($tournament['event_type']) ?></td>
                <td><?php echo formatEventName($tournament['event_id']) ?></td>
                <td><a class="btn btn-primary m-1" href="admin_tournament_read?id=<?php echo $tournament['id'] ?>">Voir</a> <a class="btn btn-primary m-1" href="admin_tournament_update?id=<?php echo $tournament['id'] ?>">Modifier</a> <a class="btn btn-primary m-1" href="admin_tournament_delete?id=<?php echo $tournament['id'] ?>">Supprimer</a></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
<a href="/admin/tournament/create" class="btn btn-primary m-1">Ajouter</a>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/wiews/admin/footer.php" ?>