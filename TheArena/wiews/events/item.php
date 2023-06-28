<?php

require $_SERVER['DOCUMENT_ROOT'] . "/core/functions.php";
$db = connectToDB();
if (isset($_GET['id']) && !empty($_GET['id'])&& isset($_GET['shop']) && !empty($_GET['shop'])) {
    $shop = strip_tags($_GET['shop']);
    $query = $db->prepare('SELECT * FROM ' . PREFIX . 'shops WHERE `id`=:shop');
    $query->execute([':shop' => $shop]);
    $shop = $query->fetch(PDO::FETCH_ASSOC);
    $query = $db->prepare('SELECT * FROM ' . PREFIX . 'events WHERE `shop_id`=:shop');
    $query->execute([':shop' => $shop['id']]);
    $event = $query->fetch(PDO::FETCH_ASSOC);
    if (isConnected()) {
        $nquery =  $db->prepare('SELECT * FROM ' . PREFIX . 'users WHERE `email`=:email');
        $nquery->execute([':email' => $_SESSION['email']]);
        $user = $nquery->fetch(PDO::FETCH_ASSOC);
    }
    $id = strip_tags($_GET['id']);
    $query = $db->prepare('SELECT * FROM ' . PREFIX . 'products WHERE `id`=:id');
    $query->execute([':id' => $id]);
    $item = $query->fetch(PDO::FETCH_ASSOC);
    if (!$event) {
        $_SESSION['message'] = "Cet évènement n'existe pas.";
        $_SESSION['message_type'] = "danger";
        header('Location: /');
        exit();
    }
} else {
    $_SESSION['message'] = "Cet item n'existe pas.";
    $_SESSION['message_type'] = "danger";
    header('Location: /');
    exit();
}

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
    <h2><?php echo $item['nom']?></h2>
</div>

<div class="row">
    <div class="col-12">
        <img src="<?php echo $item['image']?>" style="max-width:500px" alt="<?php echo $item['nom']?>" class="rounded mx-auto d-block">
    </div>
    <div class="col-12">
        <h4>Description :</h4> 
        <p><?php echo $item['description']?></p>
        <p class="text-center"><?php echo $item['price']?> euros</p>
        <form  class="d-flex justify-content-center" action="/core/buy.php" method="post">
            <input type="hidden" name="id" value="<?php echo $item['id']?>">
            <input type="hidden" name="shop" value="<?php echo $shop['id']?>">
            <input type="hidden" name="event" value="<?php echo $event['id']?>">
            <input type="hidden" name="user" value="<?php echo $user['id']?>">
            <input type="submit" class="btn btn-warning justify-self-center btn-lg" value="Acheter">
        </form>
    </div>





<?php require $_SERVER['DOCUMENT_ROOT'] . "/core/footer.php" ?>