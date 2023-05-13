<?php require $_SERVER['DOCUMENT_ROOT']."/core/header.php" ?>


    <h1>Créer un article</h1>
    <form action="" method="post" class="mb-5 row-cols-lg-auto">
        <div class="mb-3">
            <label for="name" class="form-label">Nom de l'article</label>
            <input type="text" class="form-control" id="name">
        </div>

        <div class="col-md-2 mt-2 mb-4">
            <label for="price" class="form-label">Prix</label>
            <input type="text" class="form-control" id="price">
        </div>
        <p>Image de l'article</p>
        <label for="image" class="d-flex justify-content-center">
            <div class=" my-5"><img src="#" width="150" height="150"/></div>
        </label>
        <input type="file" id="image" name="image" accept="image/png, image/jpeg">

        <div class="mb-5">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description"></textarea>
        </div>
        <div class="row d-flex justify-content-center">
		<div class="col-2">
		<button class="btn-primary btn btn-lg">Enregistrer l'article</button>
	</div>
	</div>
    </form>

<?php require $_SERVER['DOCUMENT_ROOT']."/core/footer.php" ?>
