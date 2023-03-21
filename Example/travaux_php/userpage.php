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

$username = $_SESSION['username'];
$reponseErr="";
$reponseBien="";
$reponse="";
if(!isset($_SESSION['vie'])){$_SESSION['vie']=3;}
if(!isset($_SESSION['nbcalcul'])){$_SESSION['nbcalcul']=0;}  

function calcul(){
$_SESSION['rand1']=rand(0, 20);
$_SESSION['rand2']=rand(0,20);
$_SESSION['randopc']=rand(1,3);
$_SESSION['randop']=""; 


if($_SESSION['randopc'] == 1){
    $_SESSION['randop']="+";
    $_SESSION['randres']=$_SESSION['rand1']+$_SESSION['rand2'];
    }
else if ($_SESSION['randopc']==2){
        $_SESSION['randop']="-";
        $_SESSION['randres']=$_SESSION['rand1']-$_SESSION['rand2'];
    }
else{
    $_SESSION['randop']="*";
    $_SESSION['randres']=$_SESSION['rand1']*$_SESSION['rand2'];
}
$_SESSION['nbcalcul']++; 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") { //post
    if (empty($_POST["reponse"])) {
        $reponseErr = "Il faut une réponse !";
    } else if (preg_match("/^[0-9-]{1,5}$/", $reponse)) {
        $reponseErr = "La réponse est invalide.";
        
    }else{
        $reponse = $_POST["reponse"];
        if ($_POST["reponse"]==$_SESSION['randres']){
            $_SESSION['vie']++;
            $reponseBien = "Bien !";
            
        }else { 
            $reponseErr="Faux ! La réponse était " . $_SESSION['randres'];
            $_SESSION['vie']--;
            
        }
        calcul();
    }
}
if ($_SESSION['vie']<=0){
    echo "<script>alert('La partie est terminée !'); window.location.href='results.php';</script>";
    
    

}
require 'header.php';
?>

    <div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <fieldset>
                <legend>Jeu de calcul</legend>
                <label for="user"> Joueur <?php echo $_SESSION["username"] ?> </label><br>
                <input type="text"  id="user" name="username" value="<?php echo $_SESSION["username"] ?>" hidden> 
                <label for="calcul">Calcul n°<?php echo $_SESSION['nbcalcul'] ?></label><br>
                <input type="text" id="calcul" name="nbcalcul" value="<?php echo $_SESSION['nbcalcul'] ?>" hidden>
                <label for="vies"> Vies : <?php echo $_SESSION ['vie'];?></label><br>
                <label for="formule"><?php echo $_SESSION['rand1'] . $_SESSION['randop'] . $_SESSION['rand2']?></label><br>
                <input type="text" id="reponse" name="reponse"> <br>
                <span class="error"><?php echo $reponseErr;?></span><span class="success"><?php echo $reponseBien;?></span><br>
                <input type="submit" value="Vérifier" class=" btn btn-success"><input type="submit" formaction="results.php" value="Terminer la partie" class=" btn btn-primary">
                <a href="register.php" class=" btn btn-primary"> Changer d'utilisateur</a>
            </fieldset>
        </form> 
        
        <?php 
            echo " reponse : " . $reponse;
            echo " || reponse attendue :" . $_SESSION['randres'];?>
    </div>

    <?php 
        if(empty($tableau[$_SESSION['users']]['image'])){$tableau[$_SESSION['users']]['image']= base64_encode_image('placeholder user.png', 'png');}
    ?>
        <div>
        <div><img src= "<?php echo $tableau[$_SESSION['users']]['image'] ?>"/></div></br></br></br>
    </br></br></br> 
    </br></br>
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