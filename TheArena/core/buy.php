<?php 

require_once 'functions.php';

if (isset($_POST['id'])
    && !empty($_POST['id'])
    && isset($_POST['shop'])
    && !empty($_POST['shop'])
    && isset($_POST['event'])
    && !empty($_POST['event'])
    && isset($_POST['user'])
    && !empty($_POST['user'])){

        $db = connectToDB();
        $id = $_POST['id'];
        $shop = $_POST['shop'];
        $event = $_POST['event'];
        $user = $_POST['user'];
        $query = $db->prepare("INSERT INTO ".PREFIX."payments (`product_id`, `shop`, `event`, `user`, date) VALUES (:id, :shop, :event, :user, :date)");
        $query->execute([
            'id' => $id,
            'shop' => $shop,
            'event' => $event,
            'user' => $user,
            'date' => date("Y-m-d H:i:s")
        ]);
        $_SESSION['message']= "Votre achat a bien été effectué.";
        $_SESSION['message_type']= "success";
        header('Location: /');
    } else {
        $_SESSION['message']= "Une erreur est survenue, veuillez réessayer.";
        $_SESSION['message_type']= "danger";
        header('Location: /');
    }