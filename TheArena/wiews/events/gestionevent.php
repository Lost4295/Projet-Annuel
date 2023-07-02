<?php

require $_SERVER['DOCUMENT_ROOT'] . "/core/formatter.php";
$db = connectToDB();
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $name = strip_tags($_GET['id']);
    $query = $db->prepare('SELECT * FROM ' . PREFIX . 'events WHERE `id`=:name');
    $query->execute([':name' => $name]);
    $evenement = $query->fetch(PDO::FETCH_ASSOC);
    if (isConnected()) {
        $nquery =  $db->prepare('SELECT * FROM ' . PREFIX . 'users WHERE `email`=:email');
        $nquery->execute([':email' => $_SESSION['email']]);
        $user = $nquery->fetch(PDO::FETCH_ASSOC);
        if ($user['id'] != $evenement['manager_id']) {
            $_SESSION['message'] = "L'action a échoué.";
            $_SESSION['message_type'] = "danger";
            header('Location: /404');
        }
    }
    if (!$evenement) {
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
        <a title="Accueil" class="btn btn-warning" href="/event?id=<?php echo $evenement['id']; ?>">Accueil</a>
        <a title="Participants" class="btn btn-warning" href="/event/participants?id=<?php echo $evenement['id'] ?>">Participants</a>
        <a title="Tableau de bord" class="btn btn-warning" href="/event/dashboard?id=<?php echo $evenement['id'] ?>">Tableau de bord</a>
        <a title="Shop" class="btn btn-warning " href="/event/shop?shop=<?php echo $evenement['shop_id'] ?>&id=<?php echo $evenement['id'] ?>">Shop</a>
        <?php if (isConnected() && ($user['id'] == $evenement['manager_id'])) { ?>
            <a title="Gestion" class="btn btn-warning active" href="/event/management?id=<?php echo $evenement['id'] ?>">Gestion</a>
        <?php } ?>
    </nav>
</div>
<div class="row">
    <h2>Gestion de l'événement</h2>


    <button class="accordion">Paramètres de l'événement</button>
    <div class="panel">

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
                <input type="hidden" name="event" value="<?php echo $_GET['id'] ?>">
                <div class="row d-flex justify-content-center">
                    <div class="col-2">
                        <button class="btn-primary btn btn-lg" type="submit">Mettre à jour l'événement</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php

$tou = $db->prepare("SELECT * FROM " . PREFIX . "tournaments WHERE event_id = :eid");
$tou->execute(array(
    'eid' => $_GET['id']
));
$tournaments = $tou->fetchAll(PDO::FETCH_ASSOC);



foreach ($tournaments as $tournament) {
    $remMAtches = $db->prepare("SELECT * FROM " . PREFIX . "matches WHERE tournament_id = :tid and player1_score is null and player2_score is null");
    $remMAtches->execute(array(
        'tid' => $tournament['id']
    ));
    $remMatches = $remMAtches->fetchAll(PDO::FETCH_ASSOC);

?>
    <button class="accordion">Tournoi <?php echo $tournament['name'] ?></button>
    <div class="panel w-100">
        <?php if ($remMAtches == null) { ?>
            <a href="/endTournament?id=<?php echo $tournament['id'] ?>&eid=<?php echo $evenement['id']  ?>" class="btn btn-primary m-2">Terminer le tournoi</a>
        <?php } ?>
        <a href="/launchTournament?id=<?php echo $tournament['id'] ?>&eid=<?php echo $evenement['id']  ?>" class="btn btn-primary m-2">Générer les matches</a>
        <div class="row">

            <div class="col-12">
                <h3>Matchs</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Round</th>
                            <th>Joueur 1</th>
                            <th>Joueur 2</th>
                            <th>Score Joueur 1</th>
                            <th>Score Joueur 2</th>
                            <th>Modifier le résultat du match</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $ql = $db->query("SELECT * FROM " . PREFIX . "matches");
                        $matches = $ql->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($matches as $match) { ?>
                            <tr>
                                <td>Round <?php echo $match['round_number'] ?></td>
                                <td><?php echo formatUsers($match['player1_id']) ?></td>
                                <td><?php echo formatUsers($match['player2_id']) ?></td>
                                <td><?php echo $match['player1_score'] ?></td>
                                <td><?php echo $match['player2_score'] ?></td>
                                <td><a href='#' id="showDialog<?php echo $match['match_id'] ?>" class='btn btn-primary'>Modifier le résultat du match</a></td>
                                <dialog id="favDialog<?php echo $match['match_id'] ?>" class="p-5">
                                    <form action="/wiews/events/resultssaver.php" class="">
                                        <div>
                                            <h2 class="text-center">Résultats</h2>
                                            <div class="row">
                                                <input type="number" name="player1_score<?php echo $match['match_id'] ?>" id="player1_score<?php echo $match['match_id'] ?>" placeholder="Score de <?php echo formatUsers($match['player1_id']) ?>" required class="form-control col-auto m-3">
                                                <input type="number" name="player2_score<?php echo $match['match_id'] ?>" id="player2_score<?php echo $match['match_id'] ?>" placeholder="Score de <?php echo formatUsers($match['player2_id']) ?>" required class="form-control col-auto m-3">
                                            </div>
                                            <input type="hidden" name="match_id" value="<?php echo $match['match_id'] ?>">
                                            <input type="hidden" name="player1id" value="<?php echo $match['player1_id'] ?>">
                                            <input type="hidden" name="player2id" value="<?php echo $match['player2_id'] ?>">
                                            <input type="hidden" name="eventid" value="<?php echo $evenement['id'] ?>">
                                            <div>
                                                <button value="cancel" class="btn btn-info" formmethod="dialog">Annuler</button>
                                                <button id="confirmBtn<?php echo $match['match_id'] ?>" class="btn btn-info" value="default">Confirmer</button>
                                            </div>
                                    </form>
                                </dialog>
                                <script>
                                    const showButton<?php echo $match['match_id'] ?> = document.getElementById("showDialog<?php echo $match['match_id'] ?>");
                                    const favDialog<?php echo $match['match_id'] ?> = document.getElementById("favDialog<?php echo $match['match_id'] ?>");
                                    const player1_score<?php echo $match['match_id'] ?> = document.getElementById("player1_score<?php echo $match['match_id'] ?>");
                                    const player2_score<?php echo $match['match_id'] ?> = document.getElementById("player2_score<?php echo $match['match_id'] ?>");
                                    const confirmBtn<?php echo $match['match_id'] ?> = favDialog<?php echo $match['match_id'] ?>.querySelector("#confirmBtn<?php echo $match['match_id'] ?>");
                                    // "Show the dialog" button opens the <dialog> modally
                                    showButton<?php echo $match['match_id'] ?>.addEventListener("click", () => {
                                        favDialog<?php echo $match['match_id'] ?>.showModal();
                                    });
                                    player1_score<?php echo $match['match_id'] ?>.addEventListener("change", (e) => {
                                        confirmBtn<?php echo $match['match_id'] ?>.value = player1_score<?php echo $match['match_id'] ?>.value + " - " + player2_score<?php echo $match['match_id'] ?>.value;
                                    });
                                    player2_score<?php echo $match['match_id'] ?>.addEventListener("change", (e) => {
                                        confirmBtn<?php echo $match['match_id'] ?>.value = player1_score<?php echo $match['match_id'] ?>.value + " - " + player2_score<?php echo $match['match_id'] ?>.value;
                                    });

                                    // "Cancel" button closes the dialog without submitting because of [formmethod="dialog"], triggering a close event.
                                    favDialog<?php echo $match['match_id'] ?>.addEventListener("close", (e) => {
                                        favDialog<?php echo $match['match_id'] ?>.returnValue === "default" ?
                                            "No return value." :
                                            `ReturnValue: ${favDialog<?php echo $match['match_id'] ?>.returnValue}.`; // Have to check for "default" rather than empty string
                                    });

                                    // Prevent the "confirm" button from the default behavior of submitting the form, and close the dialog with the `close()` method, which triggers the "close" event.
                                    confirmBtn<?php echo $match['match_id'] ?>.addEventListener("click", (event) => {
                                        favDialog<?php echo $match['match_id'] ?>.close(player1_score<?php echo $match['match_id'] ?>.value + player2_score<?php echo $match['match_id'] ?>.value); // Have to send the select box value here.
                                    });
                                </script>
                            <?php }
                        if ($matches == null) { ?>
                            <tr>
                                <td colspan="6">Aucun match n'a été créé pour cet évènement</td>
                            </tr>
                        <?php }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php } ?>

<script>
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            /* Toggle between adding and removing the "active" class,
            to highlight the button that controls the panel */
            this.classList.toggle("activee");

            /* Toggle between hiding and showing the active panel */
            var panel = this.nextElementSibling;
            if (panel.style.display === "block") {
                panel.style.display = "none";
            } else {
                panel.style.display = "block";
            }
        });
    }
</script>
</div>
</div>
<?php require $_SERVER['DOCUMENT_ROOT'] . "/core/footer.php" ?>