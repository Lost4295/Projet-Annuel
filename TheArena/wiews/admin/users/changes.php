<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/functions.php';


if ((isset($_GET['id']) && !empty($_GET['id'])) && (isset($_GET['visibility']) && !empty($_GET['visibility']))) {
    $id = strip_tags($_GET['id']);
    $visibility = strip_tags($_GET['visibility']);
    if ($visibility == -1||$visibility == 0||$visibility == 1||$visibility == 2) {
    $db = connectToDB();
        $query = $db->prepare("UPDATE " . PREFIX . "users SET visibility =:visibility WHERE `id`=:id;");
    $query->execute([':id' => $id, ':visibility'=>$visibility]);
    header("Location:/admin/users/read?id=".$id);
    }
}
if ((isset($_GET['id']) && !empty($_GET['id'])) && (isset($_GET['activity']) && !empty($_GET['activity']))) {
    $id = strip_tags($_GET['id']);
    $activity = strip_tags($_GET['activity']);
    if ($activity == -1||$activity == 0||$activity == 1) {
    $db = connectToDB();
        $query = $db->prepare("UPDATE " . PREFIX . "users SET status =:activity WHERE `id`=:id;");
    $query->execute([':id' => $id, ':activity'=>$activity]);
    header("Location:/admin/users/read?id=".$id);
    }
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/wiews/admin/header.php';


$db = connectToDB();

if ((isset($_GET['id']) && !empty($_GET['id']))) {
    $id = strip_tags($_GET['id']);
    $query = $db->prepare("SELECT * FROM " . PREFIX . "users WHERE `id`=:id;");
    $query->execute([':id' => $id]);
    $user = $query->fetch();
}

?>

<h1>Modifier les informations</h1>
<div>
    <div class="m-4">
        <h3>Visibilité</h3>
        <form>
            <select class="form-select" name="visibility" aria-label="Default select example">
                <option value="-1">Supprimé au niveau du site</option>
                <option value="0">non activé</option>
                <option value="1">actif et privé</option>
                <option value="2">actif et public </option>
            </select>
            <input type="hidden" name="id" value="<?= $user['id'] ?>">
            <input type="submit" class="btn btn-primary m-3" value="Valider les informations"></input>
        </form>
    </div>
    <div class="m-4">
        <h3>Activité</h3>
        <form>
            <select class="form-select" name="activity" aria-label="Default select example 2">
                <option value="-1"> Inactif et invisible (so soft deleted)</option>
                <option value="0">Créé mais inactif (so visible)</option>
                <option value="1">Actif</option>
            </select>
            <input type="hidden" name="id" value="<?= $user['id'] ?>">
            <input type="submit" class="btn btn-primary m-3" value="Valider les informations"></input>
        </form>
    </div>
</div>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/wiews/admin/footer.php';
