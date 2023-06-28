<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wiews/admin/header.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $db = connectToDB();
    $id = strip_tags($_GET['id']);
    $query = $db->prepare("SELECT * FROM " . PREFIX . "tournaments WHERE `id`=:id;");
    $query->execute([':id' => $id]);
    $result = $query->fetch(PDO::FETCH_ASSOC);
    $query = $db->prepare("SELECT * FROM ".PREFIX."events WHERE `id`=:id;");
    $query->execute([':id'=> $result['event_id']]);
    $resultv = $query->fetch(PDO::FETCH_ASSOC);
    $user =$db->prepare("SELECT scope FROM ".PREFIX."users WHERE id=:id");
    $user->execute([':id'=> $resultv['manager_id']]);
    $result3 = $user->fetch(PDO::FETCH_ASSOC);
    $scope = $result3['scope'];
    $attr = whoIsConnected();
    if ($attr[0]==SUPADMIN || $scope != SUPADMIN){
    $query = $db->query("SELECT * FROM " . PREFIX . "events");
    $result2 = $query->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $_SESSION['message'] = "Vous n'êtes pas autorisé à modifier cet élément.";
        $_SESSION['message_type'] = "danger";
        header("Location: /admin/tournaments");
    }

}

?>
<form action="/wiews/admin/events/tournaments/verifyup.php" method="post" class="mb-5">
    <div class="mb-3">
        <label for="name" class="form-label">Nom du tournoi </label>
        <input type="text" class="form-control" id="name" value="<?php echo $result["name"] ?>" name="name" required>
        <div class="invalid">
            <?php
            if (isset($_SESSION["errorname"])) {
                echo $_SESSION['errorname'];
            }
            ?>
        </div>
    </div>
    <!-- apparaît seulement si l'évent est payant de base -->

    <div class="my-3">
        <div class="col">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="price" onchange="checkPrice()" id="free" value="1" <?php if ($result['event_type']==1){ echo "checked";}?>>
                <label class="form-check-label" for="free">
                    Gratuit
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="price" onchange="checkPrice()" id="nfree" value="2" <?php if ($result['event_type']==2){ echo "checked";}?>>
                <label class="form-check-label" for="nfree">
                    Payant
                </label>
            </div>
            <div class="invalid">
                <?php
                if (isset($_SESSION["errortype"])) {
                    echo $_SESSION['errortype'];
                }
                ?>
            </div>
            <div class="form-text" id="basic-addon1">
                Si l'événement est gratuit, tous les tournois le seront.
                Si l'événement est payant, tous les tournois ne le sont pas forcément.
            </div>

            <div class="col-2 mb-2" id="prixdiv">
                <label for="valueprice" class="form-label">Prix</label>
                <input type="text" class="form-control" id="valueprice" value="<?php echo $result["price"] ?>" name="valueprice" pattern="^\d+.?\d+$">
                <div class="invalid">
                    <?php
                    if (isset($_SESSION["errorprice"])) {
                        echo $_SESSION['errorprice'];
                    }
                    ?>
                </div>
                <div class="form-text mb-4" id="basic-addon2">Le prix de base pour s'inscrire à chaque tournoi créé.</div>
            </div>

            <script>
                var divSuivante = document.getElementById("prixdiv");
                divSuivante.style.display = <?php echo($result['event_type']==1)?"none":"block";?>

                function checkPrice() {
                    if (document.getElementById("nfree").checked) {
                        divSuivante.style.display = "block";
                    } else if (document.getElementById("free").checked) {
                        divSuivante.style.display = "none";
                    }
                }
            </script>

        </div>
        <div class="mt-3 mb-5">
            <label for="date" class="form-label">Date du tournoi</label>
            <input type="datetime-local" class="form-control form-control-date" id="date" value="<?php echo $result["date"] ?>" name="date" required>

            <div class="invalid">
                <?php
                if (isset($_SESSION["errordate"])) {
                    echo $_SESSION['errordate'];
                }
                ?>
            </div>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description du tournoi</label>
            <textarea class="form-control" id="description"  name="description" rows="3" required><?php echo $result["description"] ?></textarea>

            <div class="invalid">
                <?php
                if (isset($_SESSION["errordescription"])) {
                    echo $_SESSION['errordescription'];
                }
                ?>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 form-control-label">Événement</label>
            <div class="col-sm-6">
                <select class="form-control" id="event" name="event">
                    <?php foreach ($result2 as $key => $orga) {
                        echo "<option value=" . $orga["id"];
                        if ($orga['id'] == $result["event_id"]) {
                            echo " selected";
                        }
                        echo ">" . $orga["name"] . "</option>";
                    } ?>
                </select>
            </div>
        </div>
        <div class="invalid">
            <?php
            if (isset($_SESSION["errormanagerid"])) {
                echo $_SESSION['errormanagerid'];
            }
            ?>
        </div><input type="hidden" value="<?php echo $result["id"] ?>" name="id" value="<?= $result['id'] ?>">
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Modifier le tournoi</button>
        </div>
    </div>
</form>

<?php
require $_SERVER['DOCUMENT_ROOT'] . "/wiews/admin/footer.php";
