<?php

require $_SERVER['DOCUMENT_ROOT'] . "/core/formatter.php";
redirectIfNotConnected();
require $_SERVER['DOCUMENT_ROOT'] . "/core/header.php";
$connection = connectToDB();
$queryPrepared = $connection->prepare("SELECT * FROM " . PREFIX . "users WHERE email=:email");
$queryPrepared->execute([
    "email" => $_SESSION["email"]
]);

$result = $queryPrepared->fetch(PDO::FETCH_ASSOC);
if (!empty($result)) {
    $firstname = $result["first_name"];
    $lastname = $result["last_name"];
    $username = $result["username"];
    $birthdate = $result["birthdate"];
    $email = $result["email"];
    $password = $result["password"];
    $scope = $result["scope"];
    $phone = $result["phone"];
    $address = $result["address"];
    $newsletter = $result["newsletter"];
    $avatar = $result["avatar"];
    $about = $result["about"];

    $nquery = $connection->prepare("SELECT * FROM " . PREFIX . "user_friends WHERE friend_id=:receiver AND accepted=0");
    $nquery->execute([
        "receiver" => $result["id"]
    ]);
    $friendRequests = $nquery->fetchAll(PDO::FETCH_ASSOC);
    $query = $connection->prepare("SELECT * FROM " . PREFIX . "user_friends WHERE user_id=:user_id AND accepted=1");
    $query->execute([
        "user_id" => $result["id"]
    ]);
    $newFriends = $query->fetchAll(PDO::FETCH_ASSOC);
    $query = $connection->prepare("SELECT * FROM " . PREFIX . "user_friends WHERE user_id=:user_id AND accepted=2");
    $query->execute([
        "user_id" => $result["id"]
    ]);
    $friends = $query->fetchAll(PDO::FETCH_ASSOC);
} else {
    $_SESSION["message"] = "Une erreur est survenue.";
    $_SESSION["message_type"] = "danger";
    header("Location: /");
    exit();
}
?>

<div class="w-100">
    <h1> Ma page </h1>
    <div class="d-flex justify-content-center my-5"><img src="<?php echo $avatar ?>" width="150" height="150" /></div>
    <h3>À propos de moi</h3>
    <h3><?php echo $username ?></h3>
    <div class="my-3">
        <p><?php echo $about ?></p>
    </div>
    <div class="d-flex justify-content-center"><a title="Modifier les informations" href="/me/modify" class="btn btn-primary mb-5">Modifier les informations</a></div>
    <div class="d-flex justify-content-center"><a title="Obtenir mes informations (PDF)" href="/core/exporteddata.php" class="btn btn-primary mb-5" rel="noreferrer noopener">Obtenir mes informations en PDF</a></div>
    <br>
    <br>
    <br>
    <?php if ($friendRequests) { ?>
        <div>
            <h3>Demandes d'amis</h3>
            <div class="row">
                <?php foreach ($friendRequests as $friendRequest) { ?>
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <p class="card-text"><?php echo formatUsers($friendRequest['user_id']) ?> veut être votre ami ! Acceptez vous cette demande en ami ?</p>
                            <a href="user/interact/friend?id=<?php echo $friendRequest['user_id'] ?>&action=accept" class="btn btn-success">Accepter</a>
                            <a href="user/interact/friend?id=<?php echo $friendRequest['user_id'] ?>&action=refuse" class="btn btn-danger">Refuser</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php }
    if ($newFriends) { ?>
        <div>
            <h3>Nouveaux amis</h3>
            <div class="row">
                <?php foreach ($newFriends as $newFriend) { ?>
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <p class="card-text"><?php formatUsers($newFriend['friend_id']) ?> est maintenant votre ami !</p>
                            <a href="user/interact/friend?id=<?php echo $name ?>&action=ok" class="btn btn-danger">Supprimer</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php }
    if ($friends) { ?>
        <div>
            <h3>Amis</h3>
            <div class="row">
                <?php foreach ($friends as $friend) { ?>
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <p class="card-text"><?php formatUsers($friend['friend_id']) ?></p>
                            <a href="user/interact/friend?id=<?php echo $name ?>&action=remove" class="btn btn-danger">Supprimer des amis</a>
                            <a href="/chat/chat?user_id=<?php echo $name ?>" class="btn btn-secondary">Discuter avec <?php formatUsers($friend['friend_id']) ?></a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>

</div>



<?php require $_SERVER['DOCUMENT_ROOT'] . "/core/footer.php" ?>