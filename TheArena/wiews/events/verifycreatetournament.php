<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/core/functions.php';



if (
    isset($_POST["price"]) && $_POST["price"] == "1"
) {
    $_POST["valueprice"] = 0;
}
    if (
        count($_POST) != 6
        || empty($_POST["name"])
        || !isset($_POST["price"])
        || empty($_POST["date"])
        || !isset($_POST["valueprice"])
        || !isset($_POST["description"])
        || !isset($_POST["event"])
    ) {
        print_r($_POST);
        die("Il ne vous est pas possible de terminer l'action. Merci de réessayer.
         Si cette page se réaffiche apèrs plusieurs essais, merci de vérifier vos informations,
         puis de contacter un administrateur.");
    }

    $name = $_POST["name"];
    $type = $_POST["price"];
    $priceint = intval($_POST["valueprice"]);
    $pricefloat = floatval($_POST["valueprice"]);
    $date = $_POST["date"];
    $description = $_POST["description"];
    $eventname = $_POST["event"];
    $errorname = "";
    $errorprice = "";
    $errortype = "";
    $errordate = "";
    $errordescription = "";
    
    
    $possibleTypes = ["1", "2"];
    
    if (!in_array($type, $possibleTypes)) {
        $errortype = "Le type de tournoi n'est pas valide.";
    }

    if ($name == "" || $name == "/^ *$/") {
        $errorname = "Le nom ne peut pas être vide.";
    }

    if (strlen($name) <= 2) {
        $errorname = "Le nom doit faire au moins 3 caractères.";
    }

    if (strlen($name) >= 50) {
        $errorname = "Le nom ne doit pas faire plus de 50 caractères.";
    }

    if (!preg_match("#^[a-zA-Z]*$#", $name)) {
        $errorname = "Le nom ne doit contenir que des lettres.";
    }

    if ($priceint < 0. || $pricefloat < 0.) {
        $errorprice = "Le prix ne peut pas être négatif.";
    }

    if (empty($priceint) && empty($pricefloat)) {
        $price = 0;
    } elseif ($priceint != $pricefloat) {
        $price = $pricefloat;
    } else {
        $price = $priceint;
    }

    if ($type==2 && $price == 0) {
        $errorprice = "Le prix ne peut pas être nul pour un tournoi payant.";
    }

    if (strlen($description) > 700) {
        $errordescription = "La description doit faire moins de 700 caractères.";
    }


    $dateExploded = explode("-", $date);
    $hour = substr($dateExploded[2], 3);
    $day= substr($dateExploded[2], 0, 2);
    if (!checkdate($dateExploded[1], $day, $dateExploded[0])) {
        $errordate = "Format de date incorrect";
    } else {
        $todaySeconds = time();
        $dateSeconds = strtotime($date);
        $timeSeconds = $todaySeconds - $dateSeconds;
        $time = $timeSeconds / 60 / 60 / 24 / 365.25;

        if ($time >= 0) {
            $errordate = "La date est dans le passé. Impossible de faire un tournoi dans le passé !";
        } elseif ($time <= -3.) {
            $errordate = "La date est trop lointaine. Essayez de mettre une date inférieure à 3 ans, avant le" . $fmt->format(new DateTime("+3 years")) . " !";
        }
    }


    if (empty($errorname) && empty($errorprice) && empty($errordate) && empty($errordescription)) {
        $error = false;
    } else {
        $error = true;
    }

    if ($error) {
        $_SESSION['errorname'] = $errorname;
        $_SESSION['errorprice'] = $errorprice;
        $_SESSION['errordate'] = $errordate;
        $_SESSION['errortype'] = $errortype;
        $_SESSION['errordescription'] = $errordescription;
        header("Location: /event/tournament/create?id=" . $eventid);
    } else {
        $db = connectToDB();
        $queryPrepared = $db->prepare("SELECT id FROM " . PREFIX . "events WHERE name=:name");
        $queryPrepared->execute([
            "name" => $eventname,
        ]);
        $eventid = $queryPrepared->fetch(PDO::FETCH_ASSOC)['id'];
        $queryPrepared = $db->prepare("INSERT INTO " . PREFIX . "tournaments (name, price, description, event_type, event_id, date) VALUES (:nom, :price, :description,:event_type,:event_id, :date)");
        $queryPrepared->execute([
            "nom" => $name,
            "price" => $price,
            "description" => $description,
            "event_type" => $price,
            "event_id" => $eventid,
            "date" => $date,
        ]);
        $_SESSION['message'] = "Le tournoi a bien été créé.";
        $_SESSION['message_type'] = "success";
        header("Location: /event?id=" . $eventid);
    }