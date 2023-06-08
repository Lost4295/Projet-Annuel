<?php
require $_SERVER['DOCUMENT_ROOT'] . "/wiews/admin/header.php";
$db = connectToDB();

$query = $db->query("SELECT * FROM " . PREFIX . "events");
$result = $query->fetchAll(PDO::FETCH_ASSOC);

print_r($_SESSION);
?>


<h1>Création d'un nouveau tournoi</h1>
<form action="/wiews/admin/events/tournaments/verifycr.php" method="post" class="mb-5">
	<div class="mb-3">
		<label for="name" class="form-label">Nom du tournoi </label>
		<input type="text" class="form-control" id="name" name="name" required>
		<div class="invalid">
				<?php
				if (isset($_SESSION["errorname"])) {
					echo $_SESSION['errorname'];
				}
				?>
			</div>
	</div>
	<!-- apparaît seulement si l'évent est payant de base -->

	<div class="my-3">
		<div class="col">
			<div class="form-check">
				<input class="form-check-input" type="radio" name="price" onchange="checkPrice()" id="free" value="1" checked>
				<label class="form-check-label" for="free">
					Gratuit
				</label>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="radio" name="price" onchange="checkPrice()" id="nfree" value="2">
				<label class="form-check-label" for="nfree">
					Payant
				</label>
			</div>
			<div class="invalid">
				<?php
				if (isset($_SESSION["errortype"])) {
					echo $_SESSION['errortype'];
				}
				?>
			</div>
			<div class="form-text" id="basic-addon1">
				Si l'événement est gratuit, tous les tournois le seront.
				Si l'événement est payant, tous les tournois ne le sont pas forcément.
			</div>

			<div class="col-2 mb-2" id="prixdiv">
				<label for="valueprice" class="form-label">Prix</label>
				<input type="number" class="form-control" id="valueprice" name="valueprice">
				<div class="invalid">
					<?php
					if (isset($_SESSION["errorprice"])) {
						echo $_SESSION['errorprice'];
					}
					?>
				</div>
				<div class="form-text mb-4" id="basic-addon2">Le prix de base pour s'inscrire à chaque tournoi créé.</div>
			</div>

			<script>
				var divSuivante = document.getElementById("prixdiv");
				divSuivante.style.display = "none";

				function checkPrice() {
					if (document.getElementById("nfree").checked) {
						divSuivante.style.display = "block";
					} else if (document.getElementById("free").checked) {
						divSuivante.style.display = "none";
					}
				}
			</script>

		</div>
		<div class="mt-3 mb-5">
			<label for="date" class="form-label">Date du tournoi</label>
			<input type="datetime-local" class="form-control form-control-date" id="date" name="date" required>

			<div class="invalid">
				<?php
				if (isset($_SESSION["errordate"])) {
					echo $_SESSION['errordate'];
				}
				?>
			</div>
		</div>
		<div class="mb-3">
			<label for="description" class="form-label">Description du tournoi</label>
			<textarea class="form-control" id="description" name="description" rows="3" required></textarea>

			<div class="invalid">
				<?php
				if (isset($_SESSION["errordescription"])) {
					echo $_SESSION['errordescription'];
				}
				?>
			</div>
		</div>
        <div class="form-group row">
        <label class="col-sm-2 form-control-label">Événement</label>
        <div class="col-sm-6">
            <select class="form-control" id="event" name="event">
                <?php foreach ($result as $key => $orga) {
                    echo "<option value=" . $orga["id"] . ">" . $orga["name"] . "</option>";
                } ?>
            </select>
        </div>
    </div>
    <div class="invalid">
        <?php
        if (isset($_SESSION["errormanagerid"])) {
            echo $_SESSION['errormanagerid'];
        }
        ?>
    </div>
		<div class="mb-3">
			<button type="submit" class="btn btn-primary">Créer le tournoi</button>
		</div>
	</div>
</form>

<?php
require $_SERVER['DOCUMENT_ROOT'] . "/wiews/admin/footer.php";
?>