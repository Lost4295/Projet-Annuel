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
    header('Location: delete.php');
}
if(array_key_exists('button3', $_POST)) {
    header('Location: disconnect.php');
}
require 'header.php';
require 'game.php';

if(empty($tableau[$_SESSION['users']]['image'])){$tableau[$_SESSION['users']]['image']= base64_encode_image('placeholder user.png', 'png');}
    ?>
        <div>
        <div></br></br><img src= "<?php echo $tableau[$_SESSION['users']]['image'] ?>"/></div></br></br></br>
        </div>
        <div>
            <a class=' btn btn-primary' href='listing.php'> Listing des users </a>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" enctype= "multipart/form-data">
                <input type="file" name="image" class="form-control" value="Modifier l'image" />
                <input type="submit" name="button1" class="button btn btn-primary" value="envoyer l'image" />
                <input type="submit" name="button3" class="button btn btn-primary" value="Se déconnecter" />
            </form>
            <div class="row">
                <div class="col">
                    <div class="d-flex justify-content-center">
                        <a class="btn btn-warning" href="delete.php"> Supprimer le compte </a>
                    </div>
                </div>
            </div>
        </div>

<?php require 'footer.php';