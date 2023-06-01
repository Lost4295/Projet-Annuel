<?php 

// require $_SERVER['DOCUMENT_ROOT'] . "/core/functions.php";
// $db = connectToDB();
// if (isset($_GET['shop']) && !empty($_GET['shop'])) {
//     $name = strip_tags($_GET['shop']);
//     $query = $db->prepare('SELECT * FROM ' . PREFIX . 'shops WHERE `shop_id`=:shop');
//     $query->execute([':shop' => $shop]);
//     $event = $query->fetch(PDO::FETCH_ASSOC);
//     if (isConnected()) {
//         $nquery =  $db->prepare('SELECT * FROM ' . PREFIX . 'users WHERE `email`=:email');
//         $nquery->execute([':email' => $_SESSION['email']]);
//         $user = $nquery->fetch(PDO::FETCH_ASSOC);
//         if ($user['id'] != $event['manager_id']){
//             $_SESSION['message'] = "L'action a échoué.";
//             $_SESSION['message_type'] = "danger";
//             header('Location: /404');
//         }
//     }
//     if (!$event) {
//         $_SESSION['message'] = "Cet évènement n'existe pas.";
//         $_SESSION['message_type'] = "danger";
//         header('Location: /');
//     }
// } else {
//     $_SESSION['message'] = "Cet évènement n'existe pas.";
//     $_SESSION['message_type'] = "danger";
//     header('Location: /');
// }
include $_SERVER['DOCUMENT_ROOT'] . "/core/header.php";
?>


    <h1>Créer un article</h1>
    <form action="/wiews/events/verifycreateitem.php" method="post" class="mb-5 row-cols-lg-auto">
        <div class="mb-3">
            <label for="name" class="form-label">Nom de l'article</label>
            <input type="text" class="form-control" id="name">
        </div>

        <div class="col-md-2 mt-2 mb-4">
            <label for="price" class="form-label">Prix</label>
            <input type="text" class="form-control" id="price">
        </div>
        <p>Image de l'article</p>
        <label for="image" class="d-flex justify-content-center">
            <div class=" my-5"><img src="#" width="150" height="150"/></div>
        </label>
        <input type="file" id="image" name="image" accept="image/png, image/jpeg">

        <div class="mb-5">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description"></textarea>
        </div>
        <div class="row d-flex justify-content-center">
		<div class="col-2">
		<button class="btn-primary btn btn-lg">Enregistrer l'article</button>
	</div>
	</div>
    </form>

<?php require $_SERVER['DOCUMENT_ROOT']."/core/footer.php" ?>
