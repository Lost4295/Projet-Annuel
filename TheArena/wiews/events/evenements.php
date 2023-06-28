<?php require $_SERVER['DOCUMENT_ROOT'] . "/core/header.php";
$db = connectToDB();
$query = $db->query("SELECT * FROM " . PREFIX . "events");
$result = $query->fetchAll(PDO::FETCH_ASSOC);

// echo "<pre>";
// print_r($result);
// echo "</pre>";

?>

<div class="col-9 d-flex align-content-center flex-column flex-wrap">
    <div class="row m-3">
        <h2>Événements</h2>
    </div>
    <div class="row w-100 p-2 m-3 ms-5">
        <!-- <div class="col">
            <a href="event"><img style="position: relative; left:0; width: 250px; height:250px;" src="../img/evenement1.jpg"></a>
        </div>
        <div class="col">
            <img style="position: relative; left:0; width: 250px; height:250px;" src="#">
        </div> -->
        <?php foreach ($result as $key => $event) { ?>
            <div class="col-lg-4">
                    <a title="<?php echo $event['name']?>"href="event?id=<?php echo $event['id']; ?>">
                        <img style="position: relative; width: 250px; height:250px;" class="eventimg border" src="<?php echo $event['image']; ?>">
                    </a>
            </div>
        <?php } ?>
    </div>

<div class="col">
    <nav aria-label="Page navigation example" class="d-flex justify-content-center">
        <ul class="pagination">
            <li class="page-item"><a class="page-link" href="#">Précédent</a></li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">Suivant</a></li>
        </ul>
    </nav>
</div>
    </div>
    <?php if ((isConnected()) && (whoIsConnected()[0] == ORGANIZER || whoIsConnected()[0] == ADMIN || whoIsConnected()[0] == SUPADMIN)) { ?>
        <div class="row my-3">
            <div>
                <a title="Créer un événement" href="event_create">Créer un événement</a>
            </div>
        </div>
    <?php
    };
    require $_SERVER['DOCUMENT_ROOT'] . "/core/footer.php" ?>