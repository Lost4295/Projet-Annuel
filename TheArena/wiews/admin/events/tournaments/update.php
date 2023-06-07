<?php
    require $_SERVER['DOCUMENT_ROOT'].'/wiews/admin/header.php';

if(isset($_GET['id']) && !empty($_GET['id'])){
    $id = strip_tags($_GET['id']);
    $query = $db->prepare("SELECT * FROM ".PREFIX."tournaments WHERE `id`=:id;");
    $query->execute([':id'=> $id]);
    $result = $query->fetch();
    $query = $db->query("SELECT * FROM ".PREFIX."users");
    $result2 = $query->fetch();

}

?>
<body>
<form action="/wiews/admin/forums/verifyblogup.php" method="post">
    <div class="mb-3">
        <label for="blogname" class="form-label">Nom du blog</label>
        <input type="text" class="form-control" id="blogname" name="blogname" value="<?= $result['name'] ?>" required>
    </div>
    <div class="mb-3">
        <label for="blogdesc" class="form-label">Description</label>
        <textarea class="form-control" id="blogdesc" name="blogdesc" rows="7"><?= $result['description'] ?></textarea>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 form-control-label">Organisateur</label>
        <div class="col-sm-6">
            <select class="form-control" id="manager_id" name="manager_id">
                <?php foreach ($result2 as $orga) {
                    echo "<option value=" . $orga["id"] . ">" . $orga["username"] . "</option>";
                } ?>
            </select>
        </div>
    </div>
    <input type="hidden" name="id" value="<?= $result['id'] ?>">
    <button class="btn-primary btn btn-lg" type="submit">Modifier le forum</button>
</form>
        
<?php
    require $_SERVER['DOCUMENT_ROOT'].'/wiews/admin/footer.php';