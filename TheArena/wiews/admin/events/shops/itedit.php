<?php

require $_SERVER['DOCUMENT_ROOT'] . "/core/functions.php";

$db = connectToDB();
if (isset($_GET['sid']) && !empty($_GET['sid']) && isset($_GET['id']) && !empty($_GET['id'])) {
    $id = strip_tags($_GET['id']);
    $sid = strip_tags($_GET['sid']);
    $query = $db->prepare('SELECT * FROM ' . PREFIX . 'events WHERE `shop_id`=:sid');
    $query->execute([':sid' => $sid]);
    $event = $query->fetch(PDO::FETCH_ASSOC);
    if (!$event) {
        $_SESSION['message'] = "Cet évènement n'existe pas.";
        $_SESSION['message_type'] = "danger";
        header('Location: /');
    } else {
        $query = $db->prepare("SELECT * FROM " . PREFIX . "products WHERE id=:id");
        $query->execute([':id' => $id]);
        $item = $query->fetch(PDO::FETCH_ASSOC);
        $query2 = $db->query("SELECT * FROM " . PREFIX . "shops");
        $results = $query2->fetchAll(PDO::FETCH_ASSOC);
        print_r($results);
    }
} else {
    $_SESSION['message'] = "L'action a échoué.";
    $_SESSION['message_type'] = "danger";
    header('Location: /404');
}

include $_SERVER['DOCUMENT_ROOT'] . "/wiews/admin/header.php";
?>


<h1>Modifier un article</h1>
<form action="/wiews/admin/events/shops/verifyitup.php" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="name" class="form-label">Nom de l'article</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo $item['nom'] ?>" required>
    </div>
    <div class="invalid">
        <?php if (!empty($_SESSION['errorname'])) {
            echo $_SESSION['errorname'];
        } ?>
    </div>

    <div class="col-md-3 mt-2 mb-4">
        <label for="price" class="form-label">Prix</label>
        <div class="input-group  mb-3">
            <input type="number" class="form-control" id="price" name="price" value="<?php echo $item['price'] ?>" required>
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
            <input class="form-check-input" type="radio" name="type" value="0" <?php if ($item['type'] == 0) {
                                                                                    echo 'checked';
                                                                                } ?> id="num">
            <label class="form-check-label" for="num">
                Numérique
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="type" id="phy" value="1" <?php if ($item['type'] == 1) {
                                                                                            echo 'checked';
                                                                                        } ?>>
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
        <div class=" my-5"><img src="<?php echo $item['image'] ?>" class=" border eventimg" style="width: 300px;" id="output" /></div>
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
        <textarea class="form-control" id="description" name="description" required><?php echo $item['description'] ?></textarea>

        <div class="invalid">
            <?php if (!empty($_SESSION['errordescription'])) {
                echo $_SESSION['errordescription'];
            } ?>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 form-control-label">Shop</label>
        <div class="col-sm-6">
            <select class="form-control" id="shop" name="shop">
                <?php foreach ($results as $key => $shop) {
                    echo "<option value=" . $shop["id"];
                    if ($shop['id'] == $sid) {
                        echo " selected";
                    }
                    echo ">" . $shop["name"] . "</option>";
                } ?>
            </select>
        </div>
    </div>
    <div class="invalid">
        <?php
        if (isset($_SESSION["errormanagerid"])) {
            echo $_SESSION['errormanagerid'];
        }
        ?>
    </div>

    <input type="hidden" value="<?php echo $event['shop_id'] ?>" name="shop_id">
    <input type="hidden" value="<?php echo $event['name'] ?>" name="eventname">
    <input type="hidden" value="<?php echo $item['id'] ?>" name="id">
    <div class="row d-flex justify-content-center">
        <div class="col-2">
            <button class="btn-primary btn btn-lg">Enregistrer l'article</button>
        </div>
    </div>
</form>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/wiews/admin/footer.php" ?>