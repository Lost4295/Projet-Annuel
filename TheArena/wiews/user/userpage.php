<?php
require $_SERVER['DOCUMENT_ROOT'] . "/core/functions.php";
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $name = strip_tags($_GET['id']);
    $connection = connectToDB();
    $queryPrepared = $connection->prepare("SELECT * FROM " . PREFIX . "users WHERE id=:name");
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

            $queryPrepared = $connection->prepare("SELECT * FROM " . PREFIX . "users_blocked WHERE user_id=:user_id AND blocked_id=:blocked_id");
            $queryPrepared->execute([
                ":user_id" => $result["id"],
                ":blocked_id" => $user["id"]
            ]);
            $isBlockMe = $queryPrepared->fetch(PDO::FETCH_ASSOC);

            if ($isBlockMe) {
                $_SESSION["message"] = "Ce profil est privé";
                $_SESSION["message_type"] = "danger";
                header("Location: /");
                exit();
            }

            $queryPrepared = $connection->prepare("SELECT * FROM " . PREFIX . "users_likes WHERE user_id=:user_id AND liked_id=:liked_id");
            $queryPrepared->execute([
                ":user_id" => $user["id"],
                ":liked_id" => $result["id"]
            ]);
            $liked = $queryPrepared->fetch(PDO::FETCH_ASSOC);

            $queryPrepared = $connection->prepare("SELECT * FROM " . PREFIX . "users_blocked WHERE user_id=:user_id AND blocked_id=:blocked_id");
            $queryPrepared->execute([
                ":user_id" => $user["id"],
                ":blocked_id" => $result["id"]
            ]);
            $blocked = $queryPrepared->fetch(PDO::FETCH_ASSOC);

            $queryPrepared = $connection->prepare("SELECT * FROM " . PREFIX . "user_friends WHERE user_id=:user_id AND friend_id=:friend_id");
            $queryPrepared->execute([
                ":user_id" => $user["id"],
                ":friend_id" => $result["id"]
            ]);
            $isFriend = $queryPrepared->fetch(PDO::FETCH_ASSOC);

            $queryPrepared = $connection->prepare("SELECT accepted FROM " . PREFIX . "user_friends WHERE user_id=:user_id AND friend_id=:friend_id");
            $queryPrepared->execute([
                ":user_id" => $result["id"],
                ":friend_id" => $user["id"]
            ]);
            $isFriendAccepted = $queryPrepared->fetch(PDO::FETCH_ASSOC);
        }

        if ($result['visibility'] <= 1) {
            $_SESSION["message"] = "Ce profil est privé.";
            $_SESSION["message_type"] = "danger";
            header("Location: /");
            exit();
        }

        $queryPrepared = $connection->prepare("SELECT COUNT(liked_id) AS nbr_like FROM " . PREFIX . "users_likes WHERE liked_id=:liked_id");
        $queryPrepared->execute([
            ":liked_id" => $result["id"]
        ]);
        $nbrlike = $queryPrepared->fetch(PDO::FETCH_ASSOC);


        $queryPrepared = $connection->prepare("SELECT COUNT(friend_id) AS nbr_friend FROM " . PREFIX . "user_friends WHERE friend_id=:friend_id AND accepted=1");
        $queryPrepared->execute([
            ":friend_id" => $result["id"]
        ]);
        $nbrfriend = $queryPrepared->fetch(PDO::FETCH_ASSOC);
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
        <div class="dropdown">
            <button onclick="openMod()" class="dropbtn more">...</button>
            <div id="msgdrop" class="dropdown-content-msg">
                <a href="#">Bloquer</a>
                <a id="showDialog" href="#"> Signaler</a>
                <a href="#">é</a>
            </div>
        </div>
        <script>
            function openMod() {
                document.getElementById("msgdrop").classList.toggle("showmsg");
            }
            window.onclick = function(event) {
                if (!event.target.matches('.dropbtn')) {
                    var dropdowns = document.getElementsByClassName("dropdown-content");
                    var i;
                    for (i = 0; i < dropdowns.length; i++) {
                        var openDropdown = dropdowns[i];
                        if (openDropdown.classList.contains('showmsg')) {
                            openDropdown.classList.remove('showmsg');
                        }
                    }
                }
            }
        </script>
    </div>
    <dialog id="favDialog">
        <form action="/core/signaler.php" class="p-5">
        <h2 class="text-center">Signaler un profil</h2>
            <label class="form-label">
                Nous aimerions savoir pourquoi vous signalez ce profil. Merci de l'insérer ci-dessous.
            </label>
            <input type="text" name="content" id="reason" required class="form-control m-3">
            <input type="hidden" name="id" value="<?php echo $result["id"]; ?>">
            <input type="hidden" name="type" value="user">
            <div>
                <button value="cancel" class="btn btn-info" formmethod="dialog">Annuler</button>
                <button id="confirmBtn" class="btn btn-info" value="default">Confirmer</button>
            </div>
        </form>
    </dialog>
    <p>
    </p>
    <script>
        const showButton = document.getElementById("showDialog");
        const favDialog = document.getElementById("favDialog");
        const reason = document.getElementById("reason");
        const confirmBtn = favDialog.querySelector("#confirmBtn");

        // "Show the dialog" button opens the <dialog> modally
        showButton.addEventListener("click", () => {
            favDialog.showModal();
        });

        reason.addEventListener("change", (e) => {
            confirmBtn.value = reason.value;
        });

        // "Cancel" button closes the dialog without submitting because of [formmethod="dialog"], triggering a close event.
        favDialog.addEventListener("close", (e) => {
            favDialog.returnValue === "default" ?
                "No return value." :
                `ReturnValue: ${favDialog.returnValue}.`; // Have to check for "default" rather than empty string
        });

        // Prevent the "confirm" button from the default behavior of submitting the form, and close the dialog with the `close()` method, which triggers the "close" event.
        confirmBtn.addEventListener("click", (event) => {   
            favDialog.close(reason.value); // Have to send the select box value here.
        });
    </script>
    <div class="d-flex justify-content-center my-5"><img src="<?php echo $avatar ?>" width="200" height="200" /></div>
    <h3>À propos de moi</h3>
    <div class="my-5">
        <p>
            <?php echo $about ?>
        </p>
        <div class="text-center"><?= $nbrlike["nbr_like"] ?> J'aime <?= $nbrfriend["nbr_friend"] ?> amis</div>
    </div>
    <?php if ($isFriend) { ?>
        <p>Vous êtes amis :D</p>
    <?php } ?>
    <?php if (isConnected()) { ?>
        <div class="d-flex justify-content-around">
            <?php if ($liked) { ?>
                <a class="btn-danger btn" href="user/interact/like?id=<?php echo $name ?>"><i class="bi bi-heart-fill"></i> Je n'aime plus</a>
            <?php } elseif (!$liked) { ?>
                <a class="btn-secondary btn" href="user/interact/like?id=<?php echo $name ?>"><i class="bi bi-heart-fill"></i> J'aime</a>
            <?php } ?>
            <?php if ($blocked) { ?>
                <a class="btn-danger btn" href="user/interact/block?id=<?php echo $name ?>"><i class="bi bi-slash-circle-fill"></i> Debloquer</a>
            <?php } elseif (!$blocked) { ?>
                <a class="btn-info btn" href="user/interact/block?id=<?php echo $name ?>"><i class="bi bi-slash-circle-fill"></i> Bloquer</a>
            <?php } ?>
            <?php if ($isFriend && $isFriendAccepted['accepted'] && $isFriend['accepted']) { ?>
                <a class="btn-danger btn" href="user/interact/friend?id=<?php echo $name ?>"><i class="bi bi-person-add"></i> Retirer de mes amis</a>
            <?php } elseif ($isFriend && (!$isFriendAccepted['accepted'] || !$isFriend['accepted'])) { ?>
                <a class="btn-warning btn" href="user/interact/friend?id=<?php echo $name ?>"><i class="bi bi-person-add"></i> Annuler ma demande</a>
            <?php } elseif (!$isFriend) { ?>
                <a class="btn-success btn" href="user/interact/friend?id=<?php echo $name ?>"><i class="bi bi-person-add"></i> Demander en ami</a>
            <?php } ?>
                <a class="btn btn-secondary" href="/chat/chat?user_id=<?php echo $name ?>">Discuter avec <?php echo $username ?></a>
        </div>
    <?php } ?>
</div>


<?php require $_SERVER['DOCUMENT_ROOT'] . "/core/footer.php" ?>