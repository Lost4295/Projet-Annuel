<?php require '../../core/header.php' ?>
<h1>Créer un tournoi</h1>
<form action="" method="post" class="mb-5">
<div class="mb-3">
  <label for="name" class="form-label">Nom du tournoi </label>
  <input type="text" class="form-control" id="name" name="name">
</div>
<!-- apparaît seulement si l'évent est payant de base -->
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
</div>


<div class="mt-3 mb-5">
<label for="date" class="form-label">Date du tournoi</label>
<input type="datetime-local" class="form-control form-control-date" id="date" name="date">
</div>

</form>

<?php require '../../core/footer.php' ?>