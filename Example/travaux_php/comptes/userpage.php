<?php
session_start(); 
if(!isset($_SESSION['login'])){
    $_SESSION['login']['lastname']= "Erreur ! Veuillez vous connecter.";
}
$tableau = unserialize(file_get_contents('users.dat'));

if(array_key_exists('button1', $_POST)) {
   if(isset($_FILES['image'])){
       $tmpName = $_FILES['image']['tmp_name'];
       $type = $_FILES['image']['type'];
       $size = $_FILES['image']['size'];
       $error = $_FILES['image']['error'];
       $tableau[$_SESSION['users']]['image'] = base64_encode_image($tmpName, $type);
       file_put_contents('users.dat', serialize($tableau));
   }
}

function base64_encode_image ($filename,$filetype) {
    if ($filename){
        $imgbinary = fread(fopen($filename, "r"), filesize($filename));
        return 'data:image/' . $filetype . ';base64,' . base64_encode($imgbinary);
    }
}

if(array_key_exists('button2', $_POST)) {
   header('Location:delete.php');
}
if(array_key_exists('button3', $_POST)) {
   header('Location:disconnect.php');
}

?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta name="Page" content="Quelle page magnifique">
        <meta charset="UTF-8">
        <title> Page utilisateur </title>
        <link rel="stylesheet" href="../style.css">
    </head>
    <body>
    <button class='styled'><a href='../index.php'> index </a></button></br></br>
    <?php 
        echo "Bonjour, " . $_SESSION['login']['lastname'] ." ". $_SESSION['login']['name'] . "</br></br></br></br></br>";
        if(empty($tableau[$_SESSION['users']]['image'])){$tableau[$_SESSION['users']]['image']= base64_encode_image('placeholder user.png', 'png');}
    
    ?>
        <div>
        <div><img src= "<?php echo $tableau[$_SESSION['users']]['image'] ?>"/></div> </br></br></br></br></br></br> 
        
       
        </div>
        <div>
        <button class='styled'><a href='listing.php'> Listing des users </a></button>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" enctype= "multipart/form-data">
                
                <input type="file" name="image" class="button styled" value="Modifier l'image" />
                <input type="submit" name="button1" class="button styled" value="envoyer l'image" />
                <input type="submit" name="button3" class="button styled" value="Se déconnecter" />
                </br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br>
                <input type="submit" name="button2" class="button styled" value="Effacer le compte" />
                
            </form>
        </div>
        
    </body>
</html> 