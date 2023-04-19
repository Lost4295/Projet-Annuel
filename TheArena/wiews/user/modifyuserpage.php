<?php require '../../core/header.php' ?>

<div class="w-100">
    <h1> Modifier ma page </h1>
    <form action="" method="post">
        <div class=" row mt-5 mb-3 pr-5 -flex justify-content-between">
            <div class="col-4">
                <label for="firstname" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="firstname" disabled value="John">
            </div>
            <div class="col-4">
                <label for="lastname" class="form-label">Nom</label>
                <input type="text" class="form-control" id="lastname" disabled value="Doe">
            </div>
        </div>
        <div class="row d-flex justify-content-between">
            <div class="col-5 mb-3">
                <label for="birthdate" class="form-label">Date de naissance</label>
                <input type="date" class="form-control"  id="birthdate" value="2015-01-12" disabled>
            </div>
        </div>
        <p class="text-muted text-center"> Ces informations ne sont pas modifiables.</p>

        <div class="col-7 my-4">
            <label for="pseudo" class="form-label">Pseudo</label>
            <input type="text" class="form-control" id="pseudo" name="pseudo" value="<?php echo "le pseudo actuel la tu vois";?>">
        </div>

        <div class="col-7 my-4">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" id="email" name="email"  value="<?php echo "l'email";?>">
        </div>

        <div class="col-7 my-4">
            <label for="pwd" class="form-label">Mot de passe</label>
            <input type="text" class="form-control" id="pwd" name="pwd" value="Johndoe1234">
        </div>

        <div class="col-7 my-4">
            <label for="pwdconfirm" class="form-label">Confirmation du mot de passe</label>
            <input type="password" class="form-control" id="pwdconfirm" name="pwdconfirm" value="Johndoe1234">
        </div>
        <h4>Photo de profil</h4>

        <label for="image" class="d-flex justify-content-center">
        <div class=" my-5"><img src="#" width="150" height="150"/></div>
        </label>
        <input type="file" id="image" accept="image/png, image/jpeg">
        <p class="text-muted text-center"> Cliquer pour modifier l'image</p>
        
        <div class="mb-5 pb-5">
            <label for="exampleFormControlTextarea1" class="form-label"><h3>À propos de moi</h3></label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="about"></textarea>
        </div>
        <div class="d-flex justify-content-center">
        <input type="submit" value="Enregistrer les modifications" class="btn btn-primary ">
        </div>
    </form>
</div>


<?php require '../../core/footer.php' ?>