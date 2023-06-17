<?php

require $_SERVER['DOCUMENT_ROOT'] . "/core/functions.php";
$db = connectToDB();
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $name = strip_tags($_GET['id']);
    $query = $db->prepare('SELECT * FROM ' . PREFIX . 'events WHERE `id`=:name');
    $query->execute([':name' => $name]);
    $event = $query->fetch(PDO::FETCH_ASSOC);
    if (isConnected()) {
        $nquery =  $db->prepare('SELECT * FROM ' . PREFIX . 'users WHERE `email`=:email');
        $nquery->execute([':email' => $_SESSION['email']]);
        $user = $nquery->fetch(PDO::FETCH_ASSOC);
    }
    if (!$event) {
        $_SESSION['message'] = "Cet évènement n'existe pas.";
        $_SESSION['message_type'] = "danger";
        header('Location: /');
    }
} else {
    $_SESSION['message'] = "Cet évènement n'existe pas.";
    $_SESSION['message_type'] = "danger";
    header('Location: /');
}

$query = $db->prepare('SELECT * FROM ' . PREFIX . 'products WHERE `shop_id`=:event');
$query->execute([':event' => $event['shop_id']]);
$items = $query->fetchAll(PDO::FETCH_ASSOC);

include $_SERVER['DOCUMENT_ROOT'] . "/core/header.php";
?>
<div class="row">
    <nav class="navbar bar px-3">
        <a class="btn btn-warning" href="/event?id=<?php echo $event['id']; ?>">Accueil</a>
        <a class="btn btn-warning" href="/event/participants?id=<?php echo $event['id'] ?>">Participants</a>
        <a class="btn btn-warning" href="/event/dashboard?id=<?php echo $event['id'] ?>">Tableau de bord</a>
        <a class="btn btn-warning active" href="/event/shop?shop=<?php echo $event['shop_id'] ?>&id=<?php echo $event['id'] ?>">Shop</a>
        <?php if (isConnected() && ($user['id'] == $event['manager_id'])) { ?>
            <a class="btn btn-warning" href="/event/management?id=<?php echo $event['id'] ?>">Gestion</a>
        <?php } ?>
    </nav>
</div>
<div class="row">
    <h2>Shop</h2>
</div>
<div class="row w-100 p-2 ms-4 m-3">
    <?php foreach ($items as $key => $item) { ?>
        <div class="col-lg-4">
                <a href="/item?id=<?php echo $item['id']; ?>&shop=<?php echo $event['shop_id']?>">
                    <img style="width:150px" class=" border eventimg" src="<?php echo $item['image']; ?>">
                </a>
        </div>
    <?php } ?>
</div>

<div class="col">
    <nav aria-label="Page navigation example" class="d-flex justify-content-center">
        <ul class="pagination">
            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">Next</a></li>
        </ul>
    </nav>
</div>
<?php if (isConnected() && ($user['id'] == $event['manager_id'])) { ?>
    <a href='event_shop_create_item?shop=<?php echo $event['shop_id'] ?>'>Créer un article</a>
<?php } ?>
</div>


<?php require $_SERVER['DOCUMENT_ROOT'] . "/core/footer.php" ?>