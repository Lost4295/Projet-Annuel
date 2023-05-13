<?php require_once $_SERVER['DOCUMENT_ROOT']."/core/header.php" ?>

<h1>Création d'un nouveau blog</h1>
<form action="" method="post">
<div class="mb-3">
  <label for="blogname" class="form-label">Nom du blog</label>
  <input type="text" class="form-control" id="blogname" name="blogname" required>
</div>
<div class="mb-3">
  <label for="blogdesc" class="form-label">Description</label>
  <textarea class="form-control" id="blogdesc" name="blogdesc" rows="7"></textarea>
</div>
</form>
<?php require_once $_SERVER['DOCUMENT_ROOT']."/core/footer.php" ?>

