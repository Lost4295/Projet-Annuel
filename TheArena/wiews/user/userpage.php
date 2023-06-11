<?php
require $_SERVER['DOCUMENT_ROOT'] . "/core/functions.php";
redirectIfNotConnected();
require $_SERVER['DOCUMENT_ROOT'] . "/core/header.php";
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = strip_tags($_GET['id']);
    $connection = connectToDB();
    $queryPrepared = $connection->prepare("SELECT * FROM " . PREFIX . "users WHERE id=:id");
    $queryPrepared->execute([
        "id" => $id
    ]);

    $result = $queryPrepared->fetch(PDO::FETCH_ASSOC);
    if (!empty($result)) {
        $username = $result["username"];
        $avatar = $result["avatar"];
        $about = $result["about"];
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
        <div class="text-center">0 J'aime &emsp;&emsp;12 amis <- nombres pouvant être privés</div>
        </div>
        <div class="d-flex justify-content-around">
            <div class="btn-danger btn"><i class="bi bi-heart-fill"></i> J'aime</div>
            <div class="btn-secondary btn"><i class="bi bi-person-add"></i> Demander en ami</div>
        </div>
    </div>


    <?php require $_SERVER['DOCUMENT_ROOT'] . "/core/footer.php" ?>