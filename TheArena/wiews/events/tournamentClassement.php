<?php
require $_SERVER['DOCUMENT_ROOT'] . "/core/functions.php";
session_start();
$db = connectToDB();
$classement = $_SESSION["classement"];
$lenClassement =  count($ranking)-1;

for($x=0; $x <= $lenClassement; $x++){
    
    if($classement[$x]== 1){
        $score = 5;
        $query = $db->prepare("UPDATE ".PREFIX."powerranking SET score + :score = :score WHERE jeu = :jeu and uid = :id");

    $query->execute([
            "score"=> $score,
            "email"=> $_SESSION["email"]
            "jeu"=> $_SESSION["jeu"]
            "id"=> $_SESSION["id"]
                    ]);
    }
    else if($classement[$x]== 2){
        $score = 4;
        $query = $db->prepare("UPDATE ".PREFIX."powerranking SET score + :score = :score WHERE jeu = :jeu and uid = :id");

        $query->execute([
            "score"=> $score,
            "email"=> $_SESSION["email"]
            "jeu"=> $_SESSION["jeu"]
            "id"=> $_SESSION["id"]
                    ]);
    }else if($classement[$x]== 3){
        $score = 3;
        $query = $db->prepare("UPDATE ".PREFIX."powerranking SET score + :score = :score WHERE jeu = :jeu and uid = :id");

        $query->execute([
                "score"=> $score,
                "email"=> $_SESSION["email"]
                "jeu"=> $_SESSION["jeu"]
                "id"=> $_SESSION["id"]
                        ]);
    else if($classement[$x]== 4){
        $score = 2;
        $query = $db->prepare("UPDATE ".PREFIX."powerranking SET score + :score = :score WHERE jeu = :jeu and uid = :id");

    $query->execute([
            "score"=> $score,
            "email"=> $_SESSION["email"]
            "jeu"=> $_SESSION["jeu"]
            "id"=> $_SESSION["id"]
                    ]);
    }
    else if($classement[$x]== 5){
        $score = 1;
        $query = $db->prepare("UPDATE ".PREFIX."powerranking SET score + :score = :score WHERE jeu = :jeu and uid = :id");

        $query->execute([
                "score"=> $score,
                "email"=> $_SESSION["email"]
                "jeu"=> $_SESSION["jeu"]
                "id"=> $_SESSION["id"]
                        ]);
        }
    }
}
