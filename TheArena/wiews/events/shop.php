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
        $_SESSION['message'] = "Cet évènement n'existe pas";
        $_SESSION['message_type'] = "danger";
        
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
        <h2><u>Shop<u></h2>
    </div>
    <div class="row my-3">
                <div class="col"> 
                    <a href="event"><img style="position: relative; left:0; width: 250px; height:250px;" src="#" ></a>
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
