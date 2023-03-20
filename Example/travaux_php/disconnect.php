

<?php 
session_start();
$tableau = unserialize(file_get_contents('users.dat'));
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if(array_key_exists('Oui', $_POST)) {
        unset($_SESSION);
        session_destroy();
        header('Location:connexion.php');
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
        <button class='styled'><a href='index.php'> index </a></button><br><br>
        <h2><u>Voulez-vous vraiment vous déconnecter, <?php echo $_SESSION['users'] . " ? <br>"?></u></h2>
        <?php
            if(empty($tableau[$_SESSION['users']]['image'])){$tableau[$_SESSION['users']]['image']= base64_encode_image('placeholder user.png', 'png');} 
            echo "<br> <img src='" . $tableau[$_SESSION['users']]['image'] . "'/><br>"; 
        ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
            <fieldset>
                <input type="submit" name="Oui"value="Oui" class="button styled"> &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                <input type="submit" name="Non" value="Non" class="button styled">
            </fieldset>
        </form>
        
<?php require 'footer.php';