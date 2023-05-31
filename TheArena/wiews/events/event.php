<?php require $_SERVER['DOCUMENT_ROOT']."/core/header.php";
$db=connectToDB();
if (isset($_GET['eid']) && !empty($_GET['eid'])) {
    $id = strip_tags($_GET['eid']);
    $query = $db->prepare('SELECT * FROM '.PREFIX.'events WHERE `id`=:id');
    $query->execute([':id' => $id]);
    $event = $query->fetch(PDO::FETCH_ASSOC);
    if (!$event){
        $_SESSION['message'] = "Cet évènement n'existe pas";
        $_SESSION['message_type'] = "danger";
        header('Location: /');
    }
    } else {
        $_SESSION['message'] = "Cet évènement n'existe pas";
        $_SESSION['message_type'] = "danger";
        header('Location: /');
    }
?>

    <div class="row col-12">
        <nav class="navbar bar">
            <a class="btn btn-primary active btn-warning" href="/event?eid=<?php echo $event['id']?>">Accueil</a>
            <a class="navbarSecondaryBtn" href="/event/participants?eid=<?php echo $event['id']?>">Participants</a>
            <a class="navbarSecondaryBtn" href="/event/dashboard?eid=<?php echo $event['id']?>">Tableau de bord</a>
            <a class="navbarSecondaryBtn "href="/event/shop?shop=<?php echo $event['shop_id'] ?>&eid=<?php echo $event['id'] ?>">Shop</a>
            //TODO AJOUTER PAGE ADMIN DE l'event
        </nav>
    </div>    
    <div class="row">
        <h2><u>Evenement <?php echo $event['name']?><u></h2>
    </div>   
    <div class="row">
        <img style="position: relative; left: 300px; width: 685px; height: 279px;" src="<?php echo $event['image'] ?>">
    </div>
    <div class="row col-3">
        <h4>Informations</h4>
    </div>
    <div class="row">
        <p><?php echo $event['description']?></p>
    </div>
    <div class="col-12 d-flex align-content-center flex-column flex-wrap">
        <a class="btn btn-primary  btn-warning" href="/event/register">S'inscrire</a>
    </div>

<?php require $_SERVER['DOCUMENT_ROOT']."/core/footer.php" ?>