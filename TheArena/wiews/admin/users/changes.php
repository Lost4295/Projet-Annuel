<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/functions.php';

if ((isset($_GET['id']) && !empty($_GET['id'])) && (isset($_GET['visibility']) && (!empty($_GET['visibility']) || $_GET['visibility'] == 0))) {
    $id = strip_tags($_GET['id']);
    $visibility = strip_tags($_GET['visibility']);
    $db = connectToDB();
        $query = $db->prepare("UPDATE " . PREFIX . "users SET visibility =:visibility WHERE `id`=:id;");
    $query->execute([':id' => $id, ':visibility'=>$visibility]);
    if ($visibility == -1) {
        $query = $db->prepare("UPDATE " . PREFIX . "users SET status =:status WHERE `id`=:id;");
        $query->execute([':id' => $id, ':status'=>-1]);
    }
    header("Location:/admin_users");
    }
    header("Location: /admin_users");
}
if ((isset($_GET['id']) && !empty($_GET['id'])) && (isset($_GET['activity']) && (!empty($_GET['activity']) || $_GET['activity'] == 0))) {
    $id = strip_tags($_GET['id']);
    $activity = strip_tags($_GET['activity']);
    $db = connectToDB();
        $query = $db->prepare("UPDATE " . PREFIX . "users SET status =:activity WHERE `id`=:id;");
    $query->execute([':id' => $id, ':activity'=>$activity]);
    if ($activity == -1) {
        $query = $db->prepare("UPDATE " . PREFIX . "users SET visibility =:visibility WHERE `id`=:id;");
        $query->execute([':id' => $id, ':visibility'=>-1]);
    }
    header("Location:/admin_users");
    }
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/wiews/admin/header.php';


$db = connectToDB();

if ((isset($_GET['id']) && !empty($_GET['id'])) && !(isset($_GET['activity']) && !empty($_GET['activity'])) && !(isset($_GET['activity']) && (!empty($_GET['activity'])))) {
    $id = strip_tags($_GET['id']);
    $query = $db->prepare("SELECT * FROM " . PREFIX . "users WHERE `id`=:id;");
    $query->execute([':id' => $id]);
    $resultv = $query->fetch(PDO::FETCH_ASSOC);
    $scope = $resultv['scope'];
    $attr = whoIsConnected();
    if ($attr[0] == SUPADMIN || $scope != SUPADMIN) {
        $query = $db->prepare("SELECT * FROM " . PREFIX . "users WHERE `id`=:id;");
        $query->execute([':id' => $id]);
        $user = $query->fetch();
    } else {
        $_SESSION['message'] = "Vous n'êtes pas autorisé à modifier cet élément.";
        $_SESSION['message_type'] = "danger";
        header("Location:/admin/users");
    }
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
