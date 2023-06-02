<?php

require $_SERVER['DOCUMENT_ROOT'] . "/core/functions.php";

$db = connectToDB();
if (isset($_GET['shop']) && !empty($_GET['shop'])) {
    $shop = strip_tags($_GET['shop']);
    $query = $db->prepare('SELECT * FROM ' . PREFIX . 'events WHERE `shop_id`=:shop');
    $query->execute([':shop' => $shop]);
    $event = $query->fetch(PDO::FETCH_ASSOC);
    if (!$event) {
        $_SESSION['message'] = "Cet évènement n'existe pas.";
        $_SESSION['message_type'] = "danger";
        header('Location: /');
    }
    if (isConnected() && ($shop == $event['shop_id'])) {
        $nquery =  $db->prepare('SELECT * FROM ' . PREFIX . 'users WHERE `email`=:email');
        $nquery->execute([':email' => $_SESSION['email']]);
        $user = $nquery->fetch(PDO::FETCH_ASSOC);
        if ($user['id'] != $event['manager_id']) {
            $_SESSION['message'] = "L'action a échoué.";
            $_SESSION['message_type'] = "danger";
            header('Location: /404');
        }
    } else {
        $_SESSION['message'] = "L'action a échoué.";
        $_SESSION['message_type'] = "danger";
        header('Location: /404');
    }
} else {
    $_SESSION['message'] = "Cet évènement n'existe pas.";
    $_SESSION['message_type'] = "danger";
    header('Location: /');
}
include $_SERVER['DOCUMENT_ROOT'] . "/core/header.php";
?>


<h1>Créer un article</h1>
<form action="/wiews/events/verifycreateitem.php" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="name" class="form-label">Nom de l'article</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="invalid">
        <?php if (!empty($_SESSION['errorname'])) {
            echo $_SESSION['errorname'];
        } ?>
    </div>

    <div class="col-md-3 mt-2 mb-4">
        <label for="price" class="form-label">Prix</label>
        <div class="input-group  mb-3">
            <input type="number" class="form-control" id="price" name="price" required>
            <span class="input-group-text" id="euros">€</span>
        </div>
    </div>
    <div class="invalid">
        <?php if (!empty($_SESSION['errorprice'])) {
            echo $_SESSION['errorprice'];
        } ?>
    </div>
    <div class="mb-3">
        <label class="form-label">Type du produit</label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="type" value="0" id="num">
            <label class="form-check-label" for="num">
                Numérique
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="type" id="phy" value="1" checked>
            <label class="form-check-label" for="phy">
                Physique
            </label>
        </div>
    </div>
    <div class="invalid">
        <?php if (!empty($_SESSION['errortype'])) {
            echo $_SESSION['errortype'];
        } ?>
    </div>
        <p>Image de l'article</p>
        <label for="image" class="d-flex justify-content-center">
            <div class=" my-5"><img src="#" width="150" height="150" id="output" /></div>
        </label>
        <input type="file" id="image" name="image" accept="image/png, image/jpeg" onchange="loadFile(event)">
        <script>
            var loadFile = function(event) {
                var output = document.getElementById('output');
                output.src = URL.createObjectURL(event.target.files[0]);
            };
        </script>
        <div class="invalid">
            <?php if (!empty($_SESSION['errorimage'])) {
                echo $_SESSION['errorimage'];
            } ?>
        </div>
        <div class="mb-5">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" required></textarea>

            <div class="invalid">
                <?php if (!empty($_SESSION['errordescription'])) {
                    echo $_SESSION['errordescription'];
                } ?>
            </div>
        </div>
        <input type="hidden" value="<?php echo $event['shop_id'] ?>" name="shop_id">
        <div class="row d-flex justify-content-center">
            <div class="col-2">
                <button class="btn-primary btn btn-lg">Enregistrer l'article</button>
            </div>
        </div>
</form>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/core/footer.php" ?>