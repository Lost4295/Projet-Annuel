
<?php 
session_start();
$tableau = unserialize(file_get_contents('users.dat'));
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if(array_key_exists('Oui', $_POST)) {
        if(isset($tableau[$_SESSION['users']])){
            unset($tableau[$_SESSION['users']]);
            file_put_contents('users.dat', serialize($tableau));
        }
        echo "<script>alert('Le compte a bien été effacé !');</script>";
        header('Location:register.php');
        exit();
    }
    if(array_key_exists('Non', $_POST)) {
        header('Location:userpage.php');
        exit();
    }
}
function base64_encode_image ($filename,$filetype) {
    if ($filename){
        $imgbinary = fread(fopen($filename, "r"), filesize($filename));
        return 'data:image/' . $filetype . ';base64,' . base64_encode($imgbinary);
    }
}
require 'header.php';
?>

        <button class=' btn btn-primary'><a href='index.php'> index </a></button><br><br>
        <h2><u>Voulez-vous vraiment effacer votre compte ?</u></h2>
        <marquee class="warning" truespeed="10" scrolldelay="30">⚠Ces données seront perdues pour toujours !⚠</marquee>
        <div><?php
            echo "Nom : " . $_SESSION['login']['name'] . "<br>";
            echo "Prénom : " . $_SESSION['login']['lastname'] . "<br>"; 
            echo "Pseudonyme : " . $_SESSION['users'] . "<br>"; 
            echo "genre : " . $_SESSION['login']['gender'] . "<br>";
            if(empty($tableau[$_SESSION['users']]['image'])){$tableau[$_SESSION['users']]['image']= base64_encode_image('placeholder user.png', 'png');} 
            echo "Image de profil :<br> <img src='" . $tableau[$_SESSION['users']]['image'] . "'/><br>"; 
        ?></div>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
            <fieldset>
                <input type="submit" name="Oui"value="Oui" class="button  btn btn-warning"> &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                <input type="submit" name="Non" value="Non" class="button btn btn-outline-info">
            </fieldset>
        </form>
        <marquee class="warning" truespeed="50" scrollamount="10" scrolldelay="30"> ⚠&emsp;⚠&emsp;⚠&emsp;⚠&emsp;⚠&emsp;⚠&emsp;⚠&emsp;⚠&emsp;⚠&emsp;⚠&emsp;⚠&emsp;⚠&emsp;⚠&emsp;⚠&emsp;⚠&emsp;⚠&emsp;</marquee>
        <?php require 'footer.php';