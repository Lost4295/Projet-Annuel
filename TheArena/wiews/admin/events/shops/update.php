<?php
require $_SERVER['DOCUMENT_ROOT'] . '/core/functions.php';


if (isset($_GET['id']) && !empty($_GET['id']) && empty($_POST)) {
    $db = connectToDB();
    $id = strip_tags($_GET['id']);
    $query = $db->prepare("SELECT * FROM " . PREFIX . "shops WHERE `id`=:id;");
    $query->execute([':id' => $id]);
    $result = $query->fetch(PDO::FETCH_ASSOC);
} elseif (isset($_POST)) {
    if (
        count($_POST) != 3
        || empty($_POST['name'])
        || empty($_POST['description'])
        || empty($_POST['id'])
    ) {
        $_SESSION['message'] = "Erreur lors de la modification";
        $_SESSION['message_type'] = "danger";
        header('Location: /admin_shops/edit?id=' . $_GET['id']);
    } else {
        $db = connectToDB();
        $query = $db->prepare("UPDATE " . PREFIX . "shops SET `name`=:name, `description`=:description WHERE `id`=:id;");
        $query->execute([
            ':name' => strip_tags($_POST['name']),
            ':description' => strip_tags($_POST['description']),
            ':id' => strip_tags($_POST['id'])
        ]);
        $_SESSION['message'] = "Modification effectuée";
        $_SESSION['message_type'] = "success";
        unset($_POST);
        header('Location: /admin_shops');
    }
} else {
    header('Location: /admin_shops');
}

require $_SERVER['DOCUMENT_ROOT'] . '/wiews/admin/header.php';
?>
    <h1>Modifier un shop</h1>
    <form method="post">
        <p>
            <label class="form-label" for="name">Nom du shop</label>
            <input type="text" class="form-control" name="name" id="name" value="<?= $result['name'] ?>">
        </p>
        <p>
            <label class="form-label" for="description">Description</label>
            <textarea class="form-control" name="description" id="description"><?= $result['description'] ?></textarea>
        </p>
        <p>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </p>
        <input type="hidden" name="id" value="<?= $result['id'] ?>">
    </form>
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . '/wiews/admin/header.php';
