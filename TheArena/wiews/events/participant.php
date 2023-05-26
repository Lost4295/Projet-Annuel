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
    }
    ?>
    <div class="row col-12">
    <nav class="navbar bar">
            <a class="btn btn-primary active btn-warning" href="event?eid=<?php echo $event['id']?>">Accueil</a>
            <a class="navbarSecondaryBtn" href="event_participants?eid=<?php echo $event['id']?>">Participants</a>
            <a class="navbarSecondaryBtn" href="event_dashboard?eid=<?php echo $event['id']?>">Tableau de bord</a>
            <a class="navbarSecondaryBtn "href="event_shop?shop=<?php echo $event['shop_id'] ?>&eid=<?php echo $event['id'] ?>">Shop</a>
        </nav>
    </div> 
    <div class="row">
        <h2><u>Participants<u></h2>
    </div>
    <div class="row ">
        <table class="d-flex align-content-center flex-column flex-wrap table table-striped">
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
    </div>

<?php require $_SERVER['DOCUMENT_ROOT']."/core/footer.php" ?>
