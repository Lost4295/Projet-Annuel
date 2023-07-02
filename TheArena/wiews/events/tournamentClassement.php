<?php
require $_SERVER['DOCUMENT_ROOT'] . "/core/functions.php";
session_start();
$db = connectToDB();
$classement = $_SESSION["classement"];
$lenClassement =  count($classement)-1;

for($x=0; $x <= $lenClassement; $x++){
    
    if($classement[$x]['rank']== 1){
        $score = 5;
        $query = $db->prepare("UPDATE ".PREFIX."users SET score = :score WHERE id = :id");

    $query->execute([
            "score"=> $score,
            "id"=> $_SESSION["id"]
                    ]);
    }
    elseif($classement[$x]['rank']== 2){
        $score = 4;
        $query = $db->prepare("UPDATE ".PREFIX."users SET score = :score WHERE id = :id");

    $query->execute([
            "score"=> $score,
            "id"=> $_SESSION["id"]
                    ]);
    }
    elseif($classement[$x]['rank']== 3){
        $score = 3;
        $query = $db->prepare("UPDATE ".PREFIX."users SET score = :score WHERE id = :id");

    $query->execute([
            "score"=> $score,
            "id"=> $_SESSION["id"]
                    ]);
    }
    elseif($classement[$x]['rank']== 4){
        $score = 2;
        $query = $db->prepare("UPDATE ".PREFIX."users SET score = :score WHERE id = :id");

    $query->execute([
            "score"=> $score,
            "id"=> $_SESSION["id"]
                    ]);
    }
    elseif($classement[$x]['rank']== 5){
        $score = 1;
        $query = $db->prepare("UPDATE ".PREFIX."users SET score = :score WHERE id = :id");

    $query->execute([
            "score"=> $score,
            "id"=> $_SESSION["id"]
                    ]);
    }
}
