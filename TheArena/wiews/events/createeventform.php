<?php require $_SERVER['DOCUMENT_ROOT']."/core/header.php"?>

<h1>Créer un événement</h1>
    <form action="verifycreateevent.php" method="post" class="mb-5 row-cols-lg-auto">
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
        <div class="my-3">
            <div class="col">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="price" id="free" value="1" checked>
                    <label class="form-check-label" for="free">
                        Gratuit
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="price" id="nfree" value="0">
                    <label class="form-check-label" for="nfree">
                        Payant
                    </label>
                    <div class="invalid"><?php
                                        if (isset($_SESSION["errorprice"])) {echo $_SESSION['errorprice'];}
                                    ?></div>
                    <div class="form-text" id="basic-addon1">
                        Si l'événement est gratuit, tous les tournois le seront.
                         Si l'événement est payant, tous les tournois ne le sont pas forcément.
                    </div>

                </div>
            </div>
        </div>
        <div class="col-2 my-2">
            <label for="valueprice" class="form-label">Prix</label>
            <input type="text" class="form-control" id="valueprice" name="valueprice" required>
            <div class="invalid"><?php
                                        if (isset($_SESSION["errorvalueprice"])) {echo $_SESSION['errorvalueprice'];}
                                    ?></div>
            <div class="form-text mb-4" id="basic-addon2">Le prix de base pour s'inscrire à chaque tournoi créé.</div>

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
