<?php
require $_SERVER['DOCUMENT_ROOT'] . "/core/functions.php";

if (isset($_GET['q'])) {
    $search = strip_tags($_GET['q']);
    $db = connectToDB();
    $query = $db->prepare('SELECT * FROM ' . PREFIX . 'events WHERE `name` LIKE :search OR `description` LIKE :search OR game LIKE :search');
    $query->execute([':search' => '%' . $search . '%']);
    $results['events'] = $query->fetchAll(PDO::FETCH_ASSOC);
    $query = $db->prepare('SELECT * FROM ' . PREFIX . 'users WHERE `username` LIKE :search AND visibility=2');
    $query->execute([':search' => '%' . $search . '%']);
    $results['users'] = $query->fetchAll(PDO::FETCH_ASSOC);
    $query = $db->prepare('SELECT * FROM ' . PREFIX . 'products WHERE `nom` LIKE :search OR `description` LIKE :search');
    $query->execute([':search' => '%' . $search . '%']);
    $results['items'] = $query->fetchAll(PDO::FETCH_ASSOC);
    $query = $db->prepare('SELECT * FROM ' . PREFIX . 'forums WHERE `name` LIKE :search OR `description` LIKE :search');
    $query->execute([':search' => '%' . $search . '%']);
    $results['forums'] = $query->fetchAll(PDO::FETCH_ASSOC);
    $query = $db->prepare('SELECT * FROM ' . PREFIX . 'tournaments WHERE `name` LIKE :search');
    $query->execute([':search' => '%' . $search . '%']);
    $results['tournaments'] = $query->fetchAll(PDO::FETCH_ASSOC);
}


include $_SERVER['DOCUMENT_ROOT'] . "/core/header.php";
echo "<pre>";
print_r($results);
echo "</pre>";
?>

<div class="row">
    <div class="col">
        <h2>Recherche</h2>
    </div>
</div>

<div class="row">
    <div class="col">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active activated" id="nav-events-tab" data-target="nav-events" type="button" role="tab" <?php if (empty($results['events'])) {
                                                                                                                                    echo "disabled";
                                                                                                                                } ?>>Événements</button>
                <button class="nav-link" id="nav-users-tab" data-target="nav-users" type="button" role="tab" <?php if (empty($results['users'])) {
                                                                                                                    echo "disabled";
                                                                                                                } ?>>Utilisateurs</button>
                <button class="nav-link" id="nav-items-tab" data-target="nav-items" type="button" role="tab" <?php if (empty($results['items'])) {
                                                                                                                    echo "disabled";
                                                                                                                } ?>>Produits</button>
                <button class="nav-link" id="nav-forums-tab" data-target="nav-forums" type="button" role="tab" <?php if (empty($results['forums'])) {
                                                                                                                    echo "disabled";
                                                                                                                } ?>>Forums</button>
                <button class="nav-link" id="nav-tournaments-tab" data-target="nav-tournaments" type="button" role="tab" <?php if (empty($results['tournaments'])) {
                                                                                                                                echo "disabled";
                                                                                                                            } ?>>Tournaments</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane active" id="nav-events" role="tabpanel" tabindex="0">
                <div class="list-group">
                    <?php if (!empty($results['events'])) { foreach ($results['events'] as $item ) {?>
                        <a href="/event?name=<?php echo $item['name']?>" class="list-group-item list-group-item-action" aria-current="true">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1"><?php echo $item['name']?></h5>
                        </div>
                        <p class="mb-1"><?php echo $item['description']?></p>
                        <small> <i class="bi bi-controller"></i> : <?php echo $item['game']?> </small>
                    </a> <?php }} else { ?>
                        <p> Il n'y a aucun événement correspondant à votre recherche.</p>
                        <?php } ?>
                </div>
            </div>
            <div class="tab-pane" id="nav-users" role="tabpanel" tabindex="0">
                <div class="list-group">
                    <?php if (!empty($results['users'])) { foreach ($results['users'] as $item ) {?>
                        <a href="/user?id=<?php echo $item['id']?>" class="list-group-item list-group-item-action" aria-current="true">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1"><?php echo $item['username']?></h5>
                        </div>
                        <p class="mb-1"><?php echo $item['about']?></p> //TODO COUPER? SI C4EST TROP LONG
                        <small> Mentions j'aime : </small> //TODO Implémenter le sistème de like
                    </a> <?php }} else { ?>
                        <p> Il n'y a aucun utilisateur correspondant à votre recherche.</p>
                        <?php } ?>
                </div>
            </div>
            <div class="tab-pane" id="nav-items" role="tabpanel" tabindex="0">
                <div class="list-group">
                    <?php if(!empty($results['items'])) { foreach ($results['items'] as $item ) {?>
                        <a href="#" class="list-group-item list-group-item-action" aria-current="true">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1"><?php echo $item['nom']?></h5>
                        </div>
                        <p class="mb-1"><?php echo $item['description']?></p>
                        <small> Prix : <?php echo $item['price']?> € </small>
                    </a> <?php }} else { ?>
                        <p> Il n'y a aucun produit correspondant à votre recherche.</p>
                        <?php } ?>
                </div>
            </div>
            <div class="tab-pane" id="nav-forums" role="tabpanel" tabindex="0">
                <div class="list-group">
                    <?php if(!empty($results['forums'])) { foreach ($results['forums'] as $item ) {?>
                        <a href="/forum?id=<?php echo $item['id']?>" class="list-group-item list-group-item-action" aria-current="true">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1"><?php echo $item['name']?></h5>
                            <small><?php echo $item['date_creation'] ?></small> //TODO METTRE PAR RAPPORT A MAINTENANT
                        </div>
                        <p class="mb-1"><?php echo $item['description']?></p>
                        <small></small> //TODO METTRE DERNIER MESSAGE ENVOYé
                    </a> <?php }} else { ?>
                        <p> Il n'y a aucun forum correspondant à votre recherche.</p>
                        <?php } ?>
                </div>
            </div>
            <div class="tab-pane" id="nav-tournaments" role="tabpanel" tabindex="0">
                <div class="list-group">
                <?php if(!empty($results['tourrnaments'])) { foreach ($results['tourrnaments'] as $item ) {?>
                    <a href="#" class="list-group-item list-group-item-action" aria-current="true">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1"><?php echo $item['name']?></h5>
                            <small>Type d'événement : <?php echo formatTypeEvents($item['event_type']) ?> </small>
                        </div>
                        <p class="mb-1"><?php echo $item['description']?></p>
                        <small> Prix : <?php echo $item['price']?> € </small>
                        <small> Date : <?php echo $item['date']?> </small> //TODO Formatter la date
                    </a> <?php }} else { ?>
                        <p> Il n'y a aucun tournoi correspondant à votre recherche.</p>
                        <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const buttons = document.getElementsByTagName("button");
    const panels = document.getElementsByClassName("tab-pane");

    const buttonPressed = e => {
        fade(document.getElementById("nav-events"))
        fade(document.getElementById("nav-users"))
        fade(document.getElementById("nav-items"))
        fade(document.getElementById("nav-forums"))
        fade(document.getElementById("nav-tournaments"))
        setTimeout(function() {
            Array.from(buttons).forEach(button => button.classList.remove("active"));
            Array.from(buttons).forEach(button => button.classList.remove("activated"));
            Array.from(panels).forEach(button => button.classList.remove("active"));
            e.target.classList.add("active");
            e.target.classList.add("activated");
            let attr = e.target.getAttribute("data-target");
            document.getElementById(attr).classList.add("active");
            unfade(document.getElementById(attr));
        }, 400);
    }

    for (let button of buttons) {
        button.addEventListener("click", buttonPressed);
    }

    function fade(element) {
        var op = 1; // initial opacity
        var timer = setInterval(function() {
            if (op <= 0.1) {
                clearInterval(timer);
                element.style.display = 'none';
            }
            element.style.opacity = op;
            element.style.filter = 'alpha(opacity=' + op * 100 + ")";
            op -= op * 0.1;
        }, 10);
        console.log("done")

    }

    function unfade(element) {
        var op = 0.1; // initial opacity
        element.style.display = 'block';
        var timer = setInterval(function() {
            if (op >= 1) {
                clearInterval(timer);
            }
            element.style.opacity = op;
            element.style.filter = 'alpha(opacity=' + op * 100 + ")";
            op += op * 0.1;
        }, 10);
    }
</script>

<?php
include $_SERVER['DOCUMENT_ROOT'] . "/core/footer.php";
?>