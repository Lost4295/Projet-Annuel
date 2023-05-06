<?php require $_SERVER['DOCUMENT_ROOT']."/core/header.php"?>

<h1>Créer un événement</h1>
    <form action="/wiews/events/verifycreateevent.php" method="post" class="mb-5 row-cols-lg-auto">
        <div class="mb-3">
            <label for="eventname" class="form-label">Nom de l'événement</label>
            <input type="text" class="form-control" id="eventname" name="eventname" placeholder="Tournoi" required>
            <div class="invalid"><?php
                                        if (isset($_SESSION["erroreventname"])) {echo $_SESSION['erroreventname'];}
                                    ?></div>
        </div>
        <div class="mb-3">
            <label for="infos" class="form-label">Informations</label>
            <textarea class="form-control" id="infos" name="infos" rows="7" required></textarea>
            <div class="invalid"><?php
                                        if (isset($_SESSION["errorinfos"])) {echo $_SESSION['errorinfos'];}
                                    ?></div>
        </div>
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
                                        if (isset($_SESSION["errortype"])) {echo $_SESSION['errortype'];}
                                    ?></div>
        </div><!-- If local, ajouter une div pour sélectionner une room ! Sinon -->
        <label for="game" class="form-label">Jeu utilisé</label>
        <input
            class="form-control mb-5"
            list="datalistOptions"
            id="game"
            name="game"
            placeholder="Entrez le nom du jeu..."
            required>
        <datalist id="datalistOptions">
            <option value="CSGO">
            <option value="LOL">
            <option value="Super Smash Bros. Ultimate">
            <option value="Rainbow Six Siege">
            <option value="Rocket League">
        </datalist>
        <div class="invalid"><?php
            if (isset($_SESSION["errorgame"])) {echo $_SESSION['errorgame'];}
            ?></div>
        <div class="row d-flex justify-content-center">
		<div class="col-2">
		<button class="btn-primary btn btn-lg">Créer l'événement</button>
	</div>
	</div>
    </form>
</div>

<?php require $_SERVER['DOCUMENT_ROOT']."/core/footer.php" ?>
