<?php require $_SERVER['DOCUMENT_ROOT'] . "/core/header.php" ?>


<h1>Créer une salle</h1>
<form action="/wiews/events/verifyrooms.php" method="post">
	<div class="mb-3">
		<label for="nameofroom" class="form-label">Nom de la salle</label>
		<input type="text" class="form-control" required name="name" id="nameofroom">
	</div>
	<div class="mb-3">
		<label for="maxplayers" class="form-label">Nombre maximal de joueurs</label>
		<input type="number" class="form-control" required name="max_users" id="maxplayers">
	</div>
	<div class="row row-cols-lg-auto">
		<div class="col-12">
			<div class="form-check">
				<input class="form-check-input" type="radio" name="room" value="0" onclick='checker()' id="online">
				<label class="form-check-label" for="online">
					Salle en ligne
				</label>
			</div>
		</div>
		<div class="col-12">
			<div class="form-check">
				<input class="form-check-input" type="radio" name="room" value="1" onclick='checker()' id="physical" checked>
				<label class="form-check-label" for="physical">
					Salle physique
				</label>
			</div>
		</div>
	</div>

	<div class="mb-3" id="onlyphysical">
	<div class=" row mt-5 mb-3 pr-5">
                <div class="col">
                    <label for="adresse" class="form-label">Adresse</label>
                    <input type="text" class="form-control" id="adresse" name="fulladdress" placeholder="1 Rue de Paris">
                    <div id="selection" style="display: none;" class="dropdown-menu">
                    </div>
                    <div class="invalid">
                        <?php if (isset($_SESSION['errorfulladdress'])) {
                            echo $_SESSION['errorfulladdress'];
                            unset($_SESSION['errorfulladdress']);
                        }
                        ?> <div class="invalid">
                            <?php if (isset($_SESSION['erroraddress'])) {
                                echo $_SESSION['erroraddress'];
                                unset($_SESSION['erroraddress']);
                            }
                            ?>
                        </div>
                        <div class="invalid">
                            <?php if (isset($_SESSION['errorcity'])) {
                                echo $_SESSION['errorcity'];
                                unset($_SESSION['errorcity']);
                            }
                            ?>
                        </div>
                        <div class="invalid">
                            <?php if (isset($_SESSION['errorcp'])) {
                                echo $_SESSION['errorcp'];
                                unset($_SESSION['errorcp']);
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5 mb-3 pr-5">
                <div class="col">
                    <label for="resAdresse" hidden class="form-label">Adresse</label>
                    <input type="text" hidden class="form-control" id="resAdresse" name="address" placeholder="France">

                </div>
                <div class="col">
                    <label for="CP" hidden class="form-label">Code postal</label>
                    <input type="text" hidden class="form-control" id="CP" name="cp" placeholder="75012">

                    <div class="col">
                        <label for="Ville" hidden class="form-label">Ville</label>
                        <input type="text" hidden class="form-control" id="Ville" name="city" placeholder="Paris">

                    </div>
                </div>
	</div>
	</div>
	<script>
		function checker() {
			let ola = document.getElementById('onlyphysical')
			let phy = document.getElementById('physical')

			if (phy.checked === true) {
				ola.style.display = 'block'
			} else {
				ola.style.display = 'none'
			}
		}
	</script>
	<script type="text/javascript" src="/wiews/admin/users/completer.js"></script>
	<input type="hidden" value="<?php echo $user['id'] ?>">
	<div class="row d-flex justify-content-center">
		<div class="col-2">
			<button class="btn-primary btn btn-lg">Créer la salle</button>
		</div>
	</div>
</form>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/core/footer.php" ?>