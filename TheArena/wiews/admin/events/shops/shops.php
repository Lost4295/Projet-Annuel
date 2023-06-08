<?php require $_SERVER['DOCUMENT_ROOT']."/wiews/admin/header.php";
$db= connectToDB();
$query = $db->prepare('SELECT * FROM '.PREFIX.'shops');
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<h1>Boutiques des événements</h1>

    <table class="table table-hover table-bordered w-100">
        <thead>
            <th>ID</th>
            <th>Nom</th>
            <th>Description</th>
            <th>Actions</th>
        </thead>
        <tbody>
        <?php
            foreach($result as $event){
        ?>
                <tr>
                    <td><?php echo $event['id'] ?></td>
                    <td><?php echo $event['name'] ?></td>
                    <td><?php echo $event['description']??"NULL" ?></td>
                    <td><a class="btn btn-primary m-1" href="/admin/shops/read?id=<?php echo $event['id'] ?>">Voir</a>  <a class="btn btn-primary m-1" href="/admin/shops/edit?id=<?php echo $event['id'] ?>">Modifier</a></td>
                </tr>
        <?php
            }
        ?>
        </tbody>
    </table>

<?php require $_SERVER['DOCUMENT_ROOT']."/wiews/admin/footer.php" ?>
