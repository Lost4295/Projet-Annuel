<?php
require $_SERVER['DOCUMENT_ROOT'] . "/core/functions.php";

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = strip_tags($_GET['id']);
    $id= intval($id);
    $db = connectToDB();
    $query = $db->query("Select * from " . PREFIX . "forum_reponses WHERE id_forum = $id");
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    if (empty($result)) {
        $_SESSION["message"] = "Le forum n'existe pas.";
        $_SESSION["message_type"] = "danger";
        header('Location: /forums');
        exit();
    } else {
        $query = $db->query("Select name from " . PREFIX . "forums WHERE id = $id");
        $forumName = $query->fetch(PDO::FETCH_ASSOC);
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
                            <button onclick="myFunction()" class="dropbtn more">...</button>
                            <div id="myDropdown" class="dropdown-content">
                                <a href="#home">Répondre</a>
                                <a href="#about">Signaler</a>
                                <a href="#contact">Contact</a>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex w-100 justify-content-end">
                        <small class="text-body-secondary"><?php echo $element['date_reponse'] ?></small>
                    </div>
                    <p class="mb-1"><?php echo nl2br($element['message']) ?></p>
                </li>
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
            <textarea type="textarea" id="message" name="message" placeholder="Entrez un message ici.." rows="5" class="form-control mb-5 pb-5"></textarea>
        </form>
        <div class="form-text"> Utilisez la combinaison de touches Ctrl et Entrée pour envoyer votre message.</div>

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
        </script>



    <?php } ?>

</div>

<script>
    //TODO Revoir la fonction


    /* When the user clicks on the button, 
    toggle between hiding and showing the dropdown content */
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            document.getElementById("myDropdown").classList.toggle("show");
        }
    }
    // // Close the dropdown if the user clicks outside of it
    // window.onclick = function(event) {
    //   if (!event.target.matches('.dropbtn')) {
    //     var dropdowns = document.getElementsByClassName("dropdown-content");
    //     var i;
    //     for (i = 0; i < dropdowns.length; i++) {
    //       var openDropdown = dropdowns[i];
    //       if (openDropdown.classList.contains('show')) {
    //         openDropdown.classList.remove('show');
    //       }
    //     }
    //   }
</script>


<?php require $_SERVER['DOCUMENT_ROOT'] . "/core/footer.php" ?>