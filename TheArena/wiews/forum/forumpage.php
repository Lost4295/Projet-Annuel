<?php
require $_SERVER['DOCUMENT_ROOT'] . "/core/functions.php";
require $_SERVER['DOCUMENT_ROOT'] . "/core/formatter.php";

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = strip_tags($_GET['id']);
    $db = connectToDB();
    $query = $db->prepare("SELECT * FROM " . PREFIX . "forums WHERE id =:id");
    $query->execute([
        ':id' => $id
    ]);
    $forum = $query->fetch(PDO::FETCH_ASSOC);
    if ($forum) {
        $query = $db->prepare("SELECT * FROM " . PREFIX . "forum_reponses WHERE id_forum =:id");
        $query->execute([
            ':id' => $forum['id']
        ]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $query = $db->prepare("Select name from " . PREFIX . "forums WHERE id = :id");
        $query->execute([
            ':id' => $id
        ]);
        $forumName = $query->fetch(PDO::FETCH_ASSOC);
    } else {
        $_SESSION["message"] = "Le forum n'existe pas.";
        $_SESSION["message_type"] = "danger";
        header('Location: /forums');
        exit();
    }
} else {
    $_SESSION["message"] = "Le forum n'existe pas.";
    $_SESSION["message_type"] = "danger";
    header('Location: /forums');
    exit();
}
if (isConnected()) {
    $query = $db->prepare("SELECT * FROM " . PREFIX . "users WHERE email = :email");
    $query->execute([
        "email" => $_SESSION["email"]
    ]);
    $user = $query->fetch(PDO::FETCH_ASSOC);
}


require $_SERVER['DOCUMENT_ROOT'] . "/core/header.php" ?>

<h1><?php echo $forumName['name'] ?></h1>



<div class="w-100"><?php if (isset($result)) { ?>

        <ul class="list-group list-group-flush mb-4">
            <?php foreach ($result as $element) { ?>
                <li href="#" class="list-group-item">
                    <div class="d-flex w-100 justify-content-between flex-wrap align-items-center">
                        <h5 class="mb-1"><?php echo formatUsers($element['user_id']) ?></h5>
                        <div class="dropdown">
                            <button onclick="open<?php echo $element['id'] ?>()" class="dropbtn more">...</button>
                            <div id="msgdrop<?php echo $element["id"] ?>" class="dropdown-content-msg">
                                <a title="Parler à <?php echo formatUsers($element['user_id']) ?> en privé" href="/chat/chat?user_id=<?php echo $element['user_id'] ?>">Parler à <?php echo formatUsers($element['user_id']) ?> en privé</a>
                                <a  href="/core/signaler.php?id=<?php echo $element['id'] ?>&type=forumpost&content=<?php echo $element['message'];?>">Signaler le message</a>
                                <a title="Accéder à la page de <?php echo formatUsers($element['user_id']) ?>" href="/user?id=<?php echo $element['user_id'] ?>">Accéder à la page de <?php echo formatUsers($element['user_id']) ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex w-100 justify-content-end">
                        <small class="text-body-secondary"><?php echo $element['date_reponse'] ?></small>
                    </div>
                    <p class="mb-1"><?php echo nl2br($element['message']) ?></p>
                </li>
                <script>

    /* When the user clicks on the button, 
    toggle between hiding and showing the dropdown content */
    function open<?php echo $element["id"] ?>() {
        document.getElementById("msgdrop<?php echo $element["id"]?>").classList.toggle("showmsg");
    }

    // window.onclick = function(event) {
    //     if (event.target == document.getElementById('3')) {
    //         document.getElementById("msgdrop").classList.add("showmsg");
    //     }
    // }
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
        <?php };
                    }
        ?>
        <?php if (isset($result)) { ?>
        </ul>
    <?php }
        if (isConnected()) { ?>
        <form class="pb-5" method="post" action="/wiews/forum/msghandler.php">
            <input type="hidden" name="id" value="<?php echo $_GET["id"]; ?>">
            <input type="hidden" name="user" value="<?php echo $user['id']; ?>">
            <textarea type="textarea" id="message" name="message" placeholder="Entrez un message ici.." rows="5" class="form-control mb-2 pb-5"></textarea>
            <button class="btn-primary btn-block btn-lg w-100 btn mb-5 "><i class="bi bi-send"></i></button>
        </form>
        <div class="form-text"> Vous pouvez aussi utiliser la combinaison de touches Ctrl et Entrée pour envoyer votre message.</div>

        <script>
            let keysPressed = {};

            document.addEventListener('keydown', (event) => {
                keysPressed[event.key] = true;

                if (keysPressed['Control'] && event.key == 'Enter') {
                    document.forms[1].submit();
                }
            });

            document.addEventListener('keyup', (event) => {
                delete keysPressed[event.key];
            });
            sendBtn = document.querySelector("#maxer > div.content.col-10.d-flex.align-content-center.flex-column.flex-wrap > div > div > form > button");
            sendBtn.onclick =()=>{ document.forms[1].submit();}
        </script>



    <?php } else {?>
        <div class="form-text"> Afin de pouvoir envoyer des messages sur ce forum, merci de vous connecter.</div>

        <?php } ?>
</div>




<?php require $_SERVER['DOCUMENT_ROOT'] . "/core/footer.php" ?>