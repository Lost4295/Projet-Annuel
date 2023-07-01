<?php 

require $_SERVER['DOCUMENT_ROOT'] . "/core/functions.php";
$db = connectToDB();
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $name = strip_tags($_GET['id']);
    $query = $db->prepare('SELECT * FROM ' . PREFIX . 'events WHERE `id`=:name');
    $query->execute([':name' => $name]);
    $evenement = $query->fetch(PDO::FETCH_ASSOC);
    if (isConnected()) {
        $nquery =  $db->prepare('SELECT * FROM ' . PREFIX . 'users WHERE `email`=:email');
        $nquery->execute([':email' => $_SESSION['email']]);
        $user = $nquery->fetch(PDO::FETCH_ASSOC);
    }
    if (!$evenement) {
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

<div class="row">
    <nav class="navbar bar">
        <a title="Accueil" class="btn btn-warning" href="/event?id=<?php echo $evenement['id']; ?>">Accueil</a>
        <a title="Participants" class="btn btn-warning active" href="/event/participants?id=<?php echo $evenement['id'] ?>">Participants</a>
        <a title="Tableau de bord" class="btn btn-warning" href="/event/dashboard?id=<?php echo $evenement['id'] ?>">Tableau de bord</a>
        <a title="Shop" class="btn btn-warning " href="/event/shop?shop=<?php echo $evenement['shop_id'] ?>&id=<?php echo $evenement['id'] ?>">Shop</a>
        <?php if (isConnected() && ($user['id'] == $evenement['manager_id'])) { ?>
            <a title="Gestion" class="btn btn-warning" href="/event/management?id=<?php echo $evenement['id'] ?>">Gestion</a>
        <?php } ?>
    </nav>
</div>
    <div class="row">
        <h2>Participants</h2>
    </div>
    <div class="row ">
        <!-- <table class="d-flex align-content-center flex-column flex-wrap table table-striped">
            <tbody>
                <tr>
                    <td>
                        participant 1
                    </td>
                    <td>
                        contre
                    </td>
                    <td>
                        participant 2
                    </td>
                </tr>
                <tr>
                    <td>
                        participant 3
                    </td>
                    <td>
                        contre
                    </td>
                    <td>
                        participant 4
                    </td>
                </tr>
                <tr>
                    <td>
                        participant 5
                    </td>
                    <td>
                        contre
                    </td>
                    <td>
                        participant 6
                    </td>
                </tr>
            </tbody>
        </table>
    </div> -->

    <?php

    $listOfMatches= [];
    $numplayers = 4;
    if ($numplayers % 2 != 0) $numplayers++; // Dummy
    
    for ($round = 0;$round < $numplayers - 1;$round++) {
        echo 'Squad ' . ($round+1) . ":<br><br>";
        
        echo "1 contre ";
        for ($i = 0;$i < $numplayers-1;$i++) {
            if ($i % 2 == 0) {
                $player = ($numplayers-2) - ($i/2) - $round;
            } else {
                $player = ((($i-1)/2) - $round);
            }
            
            if ($player < 0) $player += $numplayers - 1;
            echo $player+2;
            echo ($i % 2 == 0) ? "\n" : ' contre ';
        }
        echo "<br><br>";
    }
    
    
    ?>

<?php require $_SERVER['DOCUMENT_ROOT']."/core/footer.php" ?>
