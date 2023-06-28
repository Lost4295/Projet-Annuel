<?php
require $_SERVER['DOCUMENT_ROOT'] . '/core/functions.php';



if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = strip_tags($_GET['id']);
    $db = connectToDB();
    $query = $db->prepare("SELECT * FROM " . PREFIX . "forums WHERE `author`=:id;");
    $query->execute([':id' => $id]);
    $resultv = $query->fetch(PDO::FETCH_ASSOC);
    $scope = $result3['scope'];
    $attr = whoIsConnected();
    if ($attr[0] == SUPADMIN || $scope != SUPADMIN) {
        $query = $db->prepare("SELECT * FROM " . PREFIX . "forums WHERE `id`=:id;");
        $query->execute([':id' => $id]);
        $result = $query->fetch();
        $query = $db->query("SELECT * FROM " . PREFIX . "users");
        $result2 = $query->fetchAll();
    } else {
        $_SESSION['message'] = "Vous n'êtes pas autorisé à modifier cet élément.";
        $_SESSION['message_type'] = "danger";
        header("Location: /admin/forums");
    }
}
require $_SERVER['DOCUMENT_ROOT'] . '/wiews/admin/header.php';
?>

<body>
    <form action="/wiews/admin/forums/verifyblogup.php" method="post">
        <div class="mb-3">
            <label for="blogname" class="form-label">Nom du blog</label>
            <input type="text" class="form-control" id="blogname" name="blogname" value="<?= $result['name'] ?>" required>
            <div class="invalid">
                <?php if (isset($_SESSION['errorname'])) {
                    echo $_SESSION['errorname'];
                    unset($_SESSION['errorname']);
                } ?>
            </div>
        </div>
        <div class="mb-3">
            <label for="blogdesc" class="form-label">Description</label>
            <textarea class="form-control" id="blogdesc" name="blogdesc" rows="7"><?= $result['description'] ?></textarea>
            <div class="invalid">
                <?php if (isset($_SESSION['errordesc'])) {
                    echo $_SESSION['errordesc'];
                    unset($_SESSION['errordesc']);
                } ?>
            </div>
            <div class="form-group row my-4">
                <label class="col-sm-2 form-control-label">Créateur du blog</label>
                <div class="col-sm-6">
                    <select class="form-control" id="author" name="author">
                        <?php foreach ($result2 as $orga) {
                            echo "<option value=" . $orga["id"] . ">" . $orga["username"] . "</option>";
                        } ?>
                    </select>
                </div>
                <div class="invalid">
                    <?php if (isset($_SESSION['errorauthor'])) {
                        echo $_SESSION['errorauthor'];
                        unset($_SESSION['errorauthor']);
                    } ?>
                </div>
                <input type="hidden" name="id" value="<?= $result['id'] ?>">
                <button class="btn-primary btn btn-lg" type="submit">Modifier le forum</button>
    </form>

    <?php
    require $_SERVER['DOCUMENT_ROOT'] . '/wiews/admin/footer.php';
