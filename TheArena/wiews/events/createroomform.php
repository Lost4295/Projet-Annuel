<?php require $_SERVER['DOCUMENT_ROOT']."/core/header.php" ?>

<h1>Créer un événement</h1>
<form action="" method="post">
	<div class="mb-3">
		<label for="exampleFormControlInput1" class="form-label">Nom de la salle</label>
		<input type="text" class="form-control" id="exampleFormControlInput1">
	</div>
	<div class="row row-cols-lg-auto">
		<div class="col-12">
			<div class="form-check">
				<input class="form-check-input" type="radio" name="room" value="0" id="online">
				<label class="form-check-label" for="online">
					Salle en ligne
				</label>
			</div>
		</div>
		<div class="col-12">
			<div class="form-check">
				<input class="form-check-input" type="radio" name="room" value="1" id="physical" checked>
				<label class="form-check-label" for="physical">
					Salle physique
				</label>
			</div>
		</div>
	</div>

	<div class="mb-3">
	<div class="row">
		<div class="col-md-6">
			<label for="exampleFormControlInput1" class="form-label">Adresse de la salle</label>
			<input type="text" class="form-control" id="exampleFormControlInput1" placeholder="15 Rue de Paris">
		</div>
		<div class="col-md-2">
			<label for="exampleFormControlInput1" class="form-label">Code postal</label>
			<input type="text" class="form-control" id="exampleFormControlInput1" placeholder="75010">
		</div>
		</div>
	</div>
	<div class="row d-flex justify-content-center">
		<div class="col-2">
		<button class="btn-primary btn btn-lg">Créer la salle</button>
	</div>
	</div>
</form>

<?php require $_SERVER['DOCUMENT_ROOT']."/core/footer.php" ?>
