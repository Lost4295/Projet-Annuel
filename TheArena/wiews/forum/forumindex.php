<?php require $_SERVER['DOCUMENT_ROOT']."/core/header.php";

$db= connectToDB();
$query= $db->query("Select * from ".PREFIX."forums ORDER BY date_creation");
$result = $query->fetchAll(PDO::FETCH_ASSOC);

// print_r($result);

$last_messages = array();
foreach ($result as $key => $forum) {
$query= $db->prepare("Select message from ".PREFIX."forum_reponses WHERE date_reponse=:date_response");
$query->execute([
    "date_response" => $forum['date_last_message']
]);
$last_messages[] = $query->fetch(PDO::FETCH_ASSOC);
}
// print_r($last_messages);

?>

<h1 class="text-center">Forums</h1>


<div class="w-100">
    <div class="list-group">
        <?php foreach ($result as $key => $forum) {?>
        <a title="<?php echo $forum['name']?>" href="/forum?id=<?php echo $forum['id']?>" class="list-group-item list-group-item-action" style="z-index: auto;">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1"><?php echo $forum['name']?></h5>
                <small class="text-body-secondary"><?php echo $forum['date_last_message']?></small>
            </div>
            <p class="mb-1"><?php echo $forum["description"]?></p>
            <?php if (isset($last_messages[$key]['message'])) { ?>
            <small class="text-body-secondary">Dernier message : <?php echo $last_messages[$key]['message']?></small>
            <?php ;}?>
        </a>
        <?php ; }?>
    </div>
</div>


<?php if(isConnected()) {?>
    
    <a title="Créer un forum" href="/forum/create" class="btn btn-primary m-5"> Créer un forum</a>
    
    <?php ;}?>

<?php require $_SERVER['DOCUMENT_ROOT']."/core/footer.php" ?>
