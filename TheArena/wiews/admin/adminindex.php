<?php require 'header.php';
$db = connectToDB();
$query = $db->query("SELECT count(*) as c FROM " . PREFIX . "events");
$resulte = $query->fetch(PDO::FETCH_ASSOC);
$query = $db->query("SELECT count(*) as c FROM " . PREFIX . "users");
$resultu = $query->fetch(PDO::FETCH_ASSOC);
$query = $db->query("SELECT count(*) as c FROM " . PREFIX . "forums");
$resultf = $query->fetch(PDO::FETCH_ASSOC);
$query = $db->query("SELECT count(*) as c FROM " . PREFIX . "tournaments");
$resultt = $query->fetch(PDO::FETCH_ASSOC);
$query = $db->query("SELECT count(*) as s FROM " . PREFIX . "user_reports");
$results = $query->fetch(PDO::FETCH_ASSOC);
?>

<div class="row">
    <h1>Tableau de bord</h1>
    <div class="col m-2">
        <div class="card" style="width: 18rem;">
            <a href="/admin/forums" class="text-decoration-none">
                <div class="card-body">
                    <h5 class="card-title text-center link-dark"> Nombre de Forums</h5>
                    <p class=" link-dark fs-1 text-center"><?php echo $resultf['c'] ?> </p>
                </div>
        </div>
        </a>
    </div>
    <div class="col m-2">
        <a href="/admin/users" class="text-decoration-none">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title text-center link-dark"> Nombre d'utilisateurs</h5>
                    <p class=" link-dark fs-1 text-center"><?php echo $resultu['c'] ?> </p>
                </div>
            </div>
        </a>
    </div>
    <div class="col m-2">
        <a href="/admin/events" class="text-decoration-none">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title text-center link-dark"> Nombre d'événements</h5>
                    <p class=" link-dark fs-1 text-center"><?php echo $resulte['c'] ?> </p>
                </div>
            </div>
        </a>
    </div>
    <div class="col m-2">
        <a href="/admin/tournaments" class="text-decoration-none">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title text-center link-dark"> Nombre de tournois</h5>
                    <p class=" link-dark fs-1 text-center"><?php echo $resultt['c'] ?> </p>
                </div>
            </div>
        </a>
    </div>
    <div class="col m-2">
        <a href="/admin/signalements" class="text-decoration-none">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title text-center link-dark">Signalements</h5>
                    <p class="link-dark fs-1 text-center"><?php echo $results['s']?></p>
                </div>
            </div>
        </a>
    </div>
</div>
<?php include 'footer.php' ?>