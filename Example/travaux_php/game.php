
<?php 
session_start();
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

    <div><button class=' btn btn-primary'><a href='index.php'> index </a></button><br><br></div>
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
                <input type="submit" value="Vérifier" class="styled"><input type="submit" formaction="results.php" value="Terminer la partie" class=" btn btn-primary">
                <button class=" btn btn-primary"><a href="register.php"> Changer d'utilisateur</a></button>
            </fieldset>
        </form> 
        
        <?php 
            echo "|| reponse : " . $reponse;
            echo " reponse attendue :" . $_SESSION['randres'];
    ?>
    </div>
<?php require 'footer.php'; 
