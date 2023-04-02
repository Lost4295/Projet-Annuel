<?php 
session_start();
if (!isset($_SESSION['leaderboard'])){
    $_SESSION['leaderboard']=array();
}
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $_SESSION['users'];
    $_SESSION['nbcalcul']=$_POST['nbcalcul'];
}
require 'header.php';
?>

        <!-- Tout est fait pour copier coller ensuite -->
        <form method="post">
        <input type="submit" name="button2" class="button btn btn-primary" value="Recommencer" />
        </form><br><br>
        <p><b><u>Résultats :</u></b></p><br><br>
        <div>
            <?php
            //faire un foreach pour afficher les gens au fur et à mesure
                $_SESSION['leaderboard'][$_SESSION['users']]=$_SESSION['nbcalcul'];
                echo $_SESSION['users'] . " a fait " . $_SESSION['nbcalcul'] . ($_SESSION['nbcalcul']==1?" calcul.":" calculs.") . " Félicitations !";
                echo "<br><br>";
                arsort($_SESSION['leaderboard']);
                foreach ($_SESSION['leaderboard'] as $key => $value) {
                    echo $key . " : " . $value . "<br>";  
                }
                unset($value);
                if(array_key_exists('button2', $_POST)) {
                    $_SESSION['nbcalcul']=1;
                    $_SESSION['vie']=3;
                    header('Location: userpage.php');
                }
                
            ?>
        </div>

<?php require 'footer.php'; ?>

