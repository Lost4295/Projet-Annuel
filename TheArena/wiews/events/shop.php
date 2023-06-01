<?php 

require $_SERVER['DOCUMENT_ROOT'] . "/core/functions.php";
$db = connectToDB();
if (isset($_GET['name']) && !empty($_GET['name'])) {
    $name = strip_tags($_GET['name']);
    $query = $db->prepare('SELECT * FROM ' . PREFIX . 'events WHERE `name`=:name');
    $query->execute([':name' => $name]);
    $event = $query->fetch(PDO::FETCH_ASSOC);
    if (isConnected()) {
        $nquery =  $db->prepare('SELECT * FROM ' . PREFIX . 'users WHERE `email`=:email');
        $nquery->execute([':email' => $_SESSION['email']]);
        $user = $nquery->fetch(PDO::FETCH_ASSOC);
    }
    if (!$event) {
        $_SESSION['message'] = "Cet évènement n'existe pas.";
        $_SESSION['message_type'] = "danger";
        header('Location: /');
    }
} else {
    $_SESSION['message'] = "Cet évènement n'existe pas.";
    $_SESSION['message_type'] = "danger";
    header('Location: /');
}
include $_SERVER['DOCUMENT_ROOT'] . "/core/header.php";
?>

<div class="row col-12">
    <nav class="navbar bar">
        <a class="btn btn-primary active btn-warning" href="/event?name=<?php echo $event['name'] ?>">Accueil</a>
        <a class="btn btn-warning" href="/event/participants?name=<?php echo $event['name'] ?>">Participants</a>
        <a class="btn btn-warning" href="/event/dashboard?name=<?php echo $event['name'] ?>">Tableau de bord</a>
        <a class="btn btn-warning " href="/event/shop?shop=<?php echo $event['shop_id'] ?>&name=<?php echo $event['name'] ?>">Shop</a>
        <?php if (isConnected() && ($user['id'] == $event['manager_id'])) { ?>
            <a class="btn btn-warning" href="/event/management?name=<?php echo $event['name'] ?>">Gestion</a>
        <?php } ?>
    </nav>
</div>
    <div class="row">
        <h2><u>Shop<u></h2>
    </div>
    <div class="row my-3">
                <div class="col"> 
                    <a href="/event"><img style="position: relative; left:0; width: 250px; height:250px;" src="#" ></a>
                </div>
                <div class="col"> 
                    <img style="position: relative; left:0; width: 250px; height:250px;" src="#">
                </div>
                <div class="col"> 
                    <img style="position: relative; left:0; width: 250px; height:250px;" src="#">
                </div>
            </div>
        <div class="row my-3">
            <div class="col"> 
                    <img style="position: relative; left:0; width: 250px; height:250px;" src="#" href="#">
                </div>
                <div class="col"> 
                    <img style="position: relative; left:0; width: 250px; height:250px;" src="#">
                </div>
                <div class="col"> 
                    <img style="position: relative; left:0; width: 250px; height:250px;" src="#">
                </div>
            </div>
            <div class="col">
                <nav aria-label="Page navigation example" class="d-flex justify-content-center">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>
        </div>


<?php require $_SERVER['DOCUMENT_ROOT']."/core/footer.php" ?>
