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
            <a href="/event"><img style="position: relative; left:0; width: 250px; height:250px;" src="../img/evenement1.jpg"></a>
        </div>
        <div class="col">
            <img style="position: relative; left:0; width: 250px; height:250px;" src="#">
        </div> -->
        
        <?php if (empty($result)) { ?>
            <div class="col-lg-4">
                <p>Aucun événement n'est disponible pour le moment</p>
            </div>
        <?php }
        foreach ($result as $key => $event) { ?>
            <div class="col-lg-4">
                    <a title="<?php echo $event['name']?>"href="/event?id=<?php echo $event['id']; ?>">
                        <img style="position: relative; width: 250px; height:250px;" class="eventimg border" src="<?php echo $event['image']; ?>">
                    </a>
            </div>
        <?php } ?>
    </div>
</div>
<?php if ((isConnected()) && (whoIsConnected()[0] == ORGANIZER || whoIsConnected()[0] == ADMIN || whoIsConnected()[0] == SUPADMIN)) { ?>
    <div class="row my-3">
        <div>
            <a title="Créer un événement" href="/event/create">Créer un événement</a>
        </div>
    </div>
<?php
};
require $_SERVER['DOCUMENT_ROOT'] . "/core/footer.php" ?>