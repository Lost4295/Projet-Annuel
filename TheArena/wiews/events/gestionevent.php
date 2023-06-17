<?php

require $_SERVER['DOCUMENT_ROOT'] . "/core/functions.php";
$db = connectToDB();
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $name = strip_tags($_GET['id']);
    $query = $db->prepare('SELECT * FROM ' . PREFIX . 'events WHERE `id`=:name');
    $query->execute([':name' => $name]);
    $event = $query->fetch(PDO::FETCH_ASSOC);
    if (isConnected()) {
        $nquery =  $db->prepare('SELECT * FROM ' . PREFIX . 'users WHERE `email`=:email');
        $nquery->execute([':email' => $_SESSION['email']]);
        $user = $nquery->fetch(PDO::FETCH_ASSOC);
        if ($user['id'] != $event['manager_id']){
            $_SESSION['message'] = "L'action a échoué.";
            $_SESSION['message_type'] = "danger";
            header('Location: /404');
        }
    }
    if (!$event) {
        $_SESSION['message'] = "Cet évènement n'existe pas.";
        $_SESSION['message_type'] = "danger";
        header('Location: /');
    }
} else {
    $_SESSION['message'] = "Cet évènement n'existe pas.";
    $_SESSION['message_type'] = "danger";
    header('Location: /');
}
include $_SERVER['DOCUMENT_ROOT'] . "/core/header.php";
?>

<div class="row">
    <nav class="navbar bar">
        <a class="btn btn-warning" href="/event?id=<?php echo $event['id']; ?>">Accueil</a>
        <a class="btn btn-warning" href="/event/participants?id=<?php echo $event['id'] ?>">Participants</a>
        <a class="btn btn-warning" href="/event/dashboard?id=<?php echo $event['id'] ?>">Tableau de bord</a>
        <a class="btn btn-warning " href="/event/shop?shop=<?php echo $event['shop_id'] ?>&id=<?php echo $event['id'] ?>">Shop</a>
        <?php if (isConnected() && ($user['id'] == $event['manager_id'])) { ?>
            <a class="btn btn-warning active" href="/event/management?id=<?php echo $event['id'] ?>">Gestion</a>
        <?php } ?>
    </nav>
</div>
<div class="row">
    <h2>Gestion de l'événement</h2>
</div>
<div class="row">
    <div class="col-12">
        <h3>Paramètres de l'événement</h3>
    </div>
    <div>
        <form action="/wiews/events/verifyupdateevent.php" method="post" class="mb-5 row-cols-lg-auto" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="eventname" class="form-label">Nom de l'événement</label>
                <input type="text" class="form-control" id="eventname" name="eventname" placeholder="Tournoi" required>
                <div class="invalid"><?php
                                        if (isset($_SESSION["erroreventname"])) {
                                            echo $_SESSION['erroreventname'];
                                        }
                                        ?></div>
            </div>
            <div class="mb-3">
                <label for="infos" class="form-label">Informations</label>
                <textarea class="form-control" id="infos" name="infos" rows="7" required></textarea>
                <div class="invalid"><?php
                                        if (isset($_SESSION["errorinfos"])) {
                                            echo $_SESSION['errorinfos'];
                                        }
                                        ?></div>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="type" id="online" value="0">
                <label class="form-check-label" for="online">
                    En ligne
                </label>
            </div>
            <div class="form-check mb-4">
                <input class="form-check-input" type="radio" name="type" id="local" value="1" checked>
                <label class="form-check-label" for="local">
                    En local
                </label>
                <div class="invalid"><?php
                                        if (isset($_SESSION["errortype"])) {
                                            echo $_SESSION['errortype'];
                                        }
                                        ?></div>
            </div><!-- If local, ajouter une div pour sélectionner une room ! Sinon -->
            <label for="game" class="form-label">Jeu utilisé</label>
            <input class="form-control mb-5" list="datalistOptions" id="game" name="game" placeholder="Entrez le nom du jeu..." required>
            <datalist id="datalistOptions">
                <option value="CSGO">
                <option value="LOL">
                <option value="Super Smash Bros. Ultimate">
                <option value="Rainbow Six Siege">
                <option value="Rocket League">
            </datalist>
            <div class="invalid"><?php
                                    if (isset($_SESSION["errorgame"])) {
                                        echo $_SESSION['errorgame'];
                                    }
                                    ?></div>
            <label for="image" class="form-label">Image de l'événement</label>
            <input type="file" accept="image/*" name="image" class="form-control" onchange="loadFile(event)">
            <div class="mb-3 d-flex justify-content-center">
                <div class="border" id="imgborder" style="width:650px; height:400px;">
                    <img id="output" src="#" width="500" height=auto />
                </div>
                <script>
                    var loadFile = function(event) {
                        var output = document.getElementById('output');
                        var border = document.getElementById('imgborder');
                        output.src = URL.createObjectURL(event.target.files[0]);
                        border.style = "none";
                    };
                </script>
            </div>
            <input type="hidden" value="<?php echo $_GET['id']?>">
            <div class="row d-flex justify-content-center">
                <div class="col-2">
                    <button class="btn-primary btn btn-lg" type="submit">Mettre à jour l'événement</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <h3>Participants</h3>
    </div>

    <div class="col-12">
        <h3>Matchs</h3>
    </div>

    <div class="col-12">
        <h3>Scores</h3>
    </div>


    // TODO ajouter accordéon
    // TODO Faire une modal pour modifier les users qui se sont enreigstrées
    // TODO Faire une modal pour modifier les matchs
    // TODO Faire une modal pour modifier les scores
</div>
<?php require $_SERVER['DOCUMENT_ROOT'] . "/core/footer.php" ?>