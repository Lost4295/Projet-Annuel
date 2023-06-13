<?php
require $_SERVER['DOCUMENT_ROOT'] . "/core/functions.php";
if (isset($_GET['name']) && !empty($_GET['name'])) {
    $name = strip_tags($_GET['name']);
    $connection = connectToDB();
    $queryPrepared = $connection->prepare("SELECT * FROM " . PREFIX . "users WHERE username=:name");
    $queryPrepared->execute([
        "name" => $name
    ]);

    $result = $queryPrepared->fetch(PDO::FETCH_ASSOC);
    if (!empty($result)) {
        $username = $result["username"];
        $avatar = $result["avatar"];
        $about = $result["about"];

        if (isConnected()) {
            $nquery =  $connection->prepare('SELECT * FROM ' . PREFIX . 'users WHERE `email`=:email');
            $nquery->execute([':email' => $_SESSION['email']]);
            $user = $nquery->fetch(PDO::FETCH_ASSOC);
            $queryPrepared = $connection->prepare("SELECT * FROM " . PREFIX . "users_likes WHERE user_id=:user_id AND liked_id=:liked_id");
            $queryPrepared->execute([
                "user_id" => $user["id"],
                "liked_id" => $result["id"]
            ]);
            $liked = $queryPrepared->fetch(PDO::FETCH_ASSOC);
        }

        if ($result['visibility'] <= 1) {
            $_SESSION["message"] = "Ce profil est privé.";
            $_SESSION["message_type"] = "danger";
            header("Location: /");
            exit();
        }

        $queryPrepared = $connection->prepare("SELECT COUNT(liked_id) AS like_count FROM " . PREFIX . "users_likes WHERE liked_id=:liked_id");
        $queryPrepared->execute([
            "liked_id" => $result["id"]
        ]);
        $nbrlike = $queryPrepared->fetch(PDO::FETCH_ASSOC);

    } else {
        $_SESSION["message"] = "Une erreur est survenue.";
        $_SESSION["message_type"] = "danger";
        header("Location: /");
    exit(); 
    }
} else {
    $_SESSION["message"] = "Une erreur est survenue.";
    $_SESSION["message_type"] = "danger";
    header("Location: /");
    exit(); 
}
require $_SERVER['DOCUMENT_ROOT'] . "/core/header.php";
?>

<div class="w-100">
    <div class="d-flex justify-content-between flex-wrap align-items-center">
        <h1> Page utilisateur de <?php echo $username; ?> </h1>
        <div><a class="more" href="#">···</a>&emsp;&emsp;&emsp;</div>
    </div>
    <div class="d-flex justify-content-center my-5"><img src="<?php echo $avatar?>" width="200" height="200" /></div>
    <h3>À propos de moi</h3>
    <div class="my-5">
        <p>
            <?php echo $about ?>
        </p>
        <div class="text-center"><?php $nbrlike["like_count"] ?>J'aime &emsp; 12 amis <- nombres pouvant être privés</div>
        </div>
        <div class="d-flex justify-content-around">
           <?php if ($liked) { ?>
                <div class="btn-danger btn"><i class="bi bi-heart-fill"></i> J'aime</div>
           <?php } elseif (!$liked) { ?>
                <div class="btn-default btn"><i class="bi bi-heart-fill"></i> J'aime</div>
            <?php } ?>
            <div class="btn-secondary btn"><i class="bi bi-person-add"></i> Demander en ami</div>
        </div>
    </div>


    <?php require $_SERVER['DOCUMENT_ROOT'] . "/core/footer.php" ?>