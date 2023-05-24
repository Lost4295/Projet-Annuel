<?php require $_SERVER['DOCUMENT_ROOT']."/core/header.php";
$db=connectToDB();
if (isset($_GET['eid']) && !empty($_GET['eid'])) {
    $id = strip_tags($_GET['eid']);
    $query = $db->prepare('SELECT id,shop_id FROM '.PREFIX.'events WHERE `id`=:id');
    $query->execute([':id' => $id]);
    $event = $query->fetch(PDO::FETCH_ASSOC);
    if (!$event){
        $_SESSION['message'] = "Cet évènement n'existe pas";
        $_SESSION['message_type'] = "danger";
        header('Location: /');
    }
    } else {
        header('Location: /');
    } ?>  
    <div class="row col-12">
    <nav class="navbar bar">
            <a class="btn btn-primary active btn-warning" href="/event?eid=<?php echo $event['id']?>">Accueil</a>
            <a class="navbarSecondaryBtn" href="/event/participants?eid=<?php echo $event['id']?>">Participants</a>
            <a class="navbarSecondaryBtn" href="/event/dashboard?eid=<?php echo $event['id']?>">Tableau de bord</a>
            <a class="navbarSecondaryBtn "href="/event/shop?shop=<?php echo $event['shop_id'] ?>&eid=<?php echo $event['id'] ?>">Shop</a>
        </nav>
    </div> 
    <div class="row">
        <h2><u>Tableau de bord<u></h2>
    </div>
    <div class="row border">
        <div class="d-flex align-content-center flex-column flex-wrap">
            contre
        </div>
        <div class="row">
            <div class="col-4 d-flex align-content-center flex-column flex-wrap">
                participant 1 
            </div>       
            <div class="col-4 d-flex align-content-center flex-column flex-wrap">
                <h4>1 - 0</h4>
            </div>    
            <div class="col-4 d-flex align-content-center flex-column flex-wrap">
                participant 2
            </div>
        </div>
    </div>

    
    <div class="col-12 d-flex align-content-center flex-column flex-wrap">
        <a class="btn btn-primary  btn-warning" href="#">Inscrire les scores</a>
    </div>
    <div class="row">
        <div class="border col-6 d-flex align-content-center flex-column flex-wrap">
            info
        </div>
        <div class="border col-6 d-flex align-content-center flex-column flex-wrap  ">
            info
        </div>
    </div>

<?php require $_SERVER['DOCUMENT_ROOT']."/core/footer.php" ?>