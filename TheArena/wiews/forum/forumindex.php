<?php require $_SERVER['DOCUMENT_ROOT']."/core/header.php";

$db= connectToDB();
$query= $db->query("Select id, name, description,date_creation as date, author from ".PREFIX."forums ORDER BY date_creation");
$result = $query->fetchAll(PDO::FETCH_ASSOC);
// print_r($result);
?>

<h1 class="text-center">Forums</h1>


<div class="w-100">
    <div class="list-group">
        <?php foreach ($result as $forum){?>
        <a href="/forum?id=<?php echo $forum['id']?>" class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1"><?php echo $forum['name']?></h5>
                <small class="text-body-secondary"><?php echo $forum['date']?></small>
            </div>
            <p class="mb-1"><?php echo $forum["description"]?></p>
            <small class="text-body-secondary">Écrit par <?php echo findUserById($forum["author"])?></small>
        </a>
        <?php ; }?>
    </div>
</div>


<?php if(isConnected()) {?>
    
    <a href="/forum/create" class="btn btn-primary m-5"> Créer un forum</a>
    
    <?php ;}?>

<?php require $_SERVER['DOCUMENT_ROOT']."/core/footer.php" ?>
