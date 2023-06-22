<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/core/header.php" ?>

<h1>Création d'un nouveau blog</h1>
<form action="/wiews/forum/verifyblog.php" method="post">
    <div class="mb-3">
        <label for="blogname" class="form-label">Nom du blog</label>
        <input type="text" class="form-control" id="blogname" name="blogname" required>
        <div class="invalid">
            <?php if (isset($_SESSION["errorname"])) {
                echo $_SESSION["errorname"];
            } ?>
        </div>
    </div>
    <div class="mb-3">
        <label for="blogdesc" class="form-label">Description</label>
        <textarea class="form-control" id="blogdesc" name="blogdesc" rows="7"></textarea>
        <div class="invalid">
            <?php if (isset($_SESSION["errordesc"])) {
                echo $_SESSION["errordesc"];
            } ?>
    </div>
    <button class="btn-primary btn btn-lg" type="submit">Créer le forum</button>
</form>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/core/footer.php" ?>