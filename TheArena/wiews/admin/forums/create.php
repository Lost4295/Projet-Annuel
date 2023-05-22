<?php
require $_SERVER['DOCUMENT_ROOT'] . "/wiews/admin/header.php";
$db = connectToDB();

$query = $db->query("SELECT * FROM " . PREFIX . "users");
$result = $query->fetchAll(PDO::FETCH_ASSOC);

?>


<h1>Création d'un nouveau blog</h1>
<form action="/wiews/admin/forums/verifyblog.php" method="post">
    <div class="mb-3">
        <label for="blogname" class="form-label">Nom du blog</label>
        <input type="text" class="form-control" id="blogname" name="blogname" required>
    </div>
    <div class="mb-3">
        <label for="blogdesc" class="form-label">Description</label>
        <textarea class="form-control" id="blogdesc" name="blogdesc" rows="7"></textarea>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 form-control-label">Auteur</label>
        <div class="col-sm-6">
            <select class="form-control" id="author" name="author">
                <?php foreach ($result as $orga) {
                    echo "<option value=" . $orga["id"] . ">" . $orga["username"] . "</option>";
                } ?>
            </select>
        </div>
    </div>
    <button class="btn-primary btn btn-lg" type="submit">Créer le forum</button>
</form>

<?php
require $_SERVER['DOCUMENT_ROOT'] . "/wiews/admin/footer.php";
?>