<?php require $_SERVER['DOCUMENT_ROOT']."/core/header.php" ?>

<form action="" method="post">
<div class="row">
<div class="col mb-3">
    <label for="lastname" class="form-label">Nom</label>
    <input type="text" class="form-control" id="lastname" placeholder="name@example.com">
</div>
<div class="col mb-3">
    <label for="firstname" class="form-label">Prénom</label>
    <input type="text" class="form-control" id="firstname" placeholder="name@example.com">
</div>
</div>
<div class="row">
<div class="col mb-3">
    <label for="email" class="form-label">Email address</label>
    <input type="email" class="form-control" id="email" placeholder="name@example.com">
</div>
<div class="col mb-3">
    <label for="email" class="form-label">Adresse email</label>
    <input type="email" class="form-control" id="email" placeholder="name@example.com">
</div>
</div>
<div class="mb-3">
    <label for="exampleFormControlTextarea1" class="form-label">Message</label>
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
</div>

</form>

<?php require $_SERVER['DOCUMENT_ROOT']."/core/footer.php" ?>
