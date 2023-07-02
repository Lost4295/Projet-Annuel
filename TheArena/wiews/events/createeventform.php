<?php

require $_SERVER['DOCUMENT_ROOT'] . "/core/header.php";

$db = connectToDB();

if (isConnected()) {
    $nquery =  $db->prepare('SELECT * FROM ' . PREFIX . 'users WHERE `email`=:email');
    $nquery->execute([':email' => $_SESSION['email']]);
    $user = $nquery->fetch(PDO::FETCH_ASSOC);

    $nquery =  $db->prepare('SELECT * FROM ' . PREFIX . 'event_rooms WHERE `owner_id`=:user_id');
    $nquery->execute([':user_id' => $_SESSION['id']]);
    $rooms = $nquery->fetchAll(PDO::FETCH_ASSOC);
    $prooms = [];
    $orooms = [];
    foreach ($rooms as $key => $room) {
        if ($room['type'] == 0) {
            $orooms[] = $room;
        } else {
            $prooms[] = $room;
        }
    }
} else {
    $_SESSION['message'] = "L'action a échoué.";
    $_SESSION['message_type'] = "danger";
    header('Location: /error');
}




?>


<h1>Créer un événement</h1>
<form action="/wiews/events/verifycreateevent.php" method="post" class="mb-5 row-cols-lg-auto" enctype="multipart/form-data">
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
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="type" id="online" onclick='checker()' value="0">
        <label class="form-check-label" for="online">
            En ligne
        </label>
    </div>
    <div class="form-check mb-4">
        <input class="form-check-input" type="radio" name="type" id="local" onclick='checker()' value="1" checked>
        <label class="form-check-label" for="local">
            En local
        </label>
        <div class="invalid"><?php
                                if (isset($_SESSION["errortype"])) {
                                    echo $_SESSION['errortype'];
                                }
                                ?></div>
    </div>
    <div class="form-check mb-4" id="prooms">
        <?php if (!empty($prooms)) { ?>
            <select class="form-select" name="roomname" id="room">
                <?php foreach ($prooms as $key => $room) { ?>
                    <option value="<?php echo $room['id'] ?>"><?php echo $room['address'] ?></option>
                <?php } ?>
            </select>
        <?php } else {
            echo '<p>Il n\'y a pas de salle. Merci d\'en créer une.</p>';
        } ?>
    </div>
    <div class="form-check mb-4" id="orooms" style="display:none">
        <?php if (!empty($orooms)) { ?>
            <select class="form-select" name="roomname" id="room">
                <?php foreach ($orooms as $key => $room) { ?>
                    <option value="<?php echo $room['id'] ?>"><?php echo $room['address'] ?></option>
                <?php } ?>
            </select>
        <?php } else {
            echo '<p>Il n\'y a pas de salle. Merci d\'en créer une.</p>';
        } ?>
    </div>
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

            function checker() {
                let ola = document.getElementById('orooms')
                let phy = document.getElementById('prooms')

                if (phy.checked === true) {
                    phy.style.display = 'block'
                    ola.style.display = 'none'
                } else {
                    phy.style.display = 'none'
                    ola.style.display = 'block'
                }
            }
        </script>
    </div>
    <div class="row d-flex justify-content-center">
        <div class="col-2">
            <button class="btn-primary btn btn-lg" type="submit">Créer l'événement</button>
        </div>
    </div>
</form>
</div>
<?php require $_SERVER['DOCUMENT_ROOT'] . "/core/footer.php" ?>