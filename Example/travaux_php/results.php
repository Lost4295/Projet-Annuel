<?php 
session_start();
if (!isset($_SESSION['leaderboard'])){
    $_SESSION['leaderboard']=array();
}
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $_SESSION['username']=$_POST['username'];
    $_SESSION['nbcalcul']=$_POST['nbcalcul'];
}
require 'header.php';
?>

        <!-- Tout est fait pour copier coller ensuite -->
        <a href="register.php"class=" btn btn-primary"> Recommencer </a> &emsp; &emsp;
        <form method="post">
        <input type="submit" name="button1" class="button btn btn-primary" value="Rénitialiser le tableau" />
        </form><br><br>
        <p><b><u>Résultats :</u></b></p><br><br>
        <div>
            <?php
                //faire un foreach pour afficher les gens au fur et à mesure

                $_SESSION['leaderboard'][$_SESSION['username']]=$_SESSION['nbcalcul'];
                echo $_SESSION['username'] . " a fait " . $_SESSION['nbcalcul'] . " calculs.";
                echo "<br><br>";
                arsort($_SESSION['leaderboard']);
                foreach ($_SESSION['leaderboard'] as $key => $value) {
                    echo $key . " : " . $value . "<br>";  
                }
                unset($value);
                
                if(array_key_exists('button1', $_POST)) {
                    button1();
                }
                function button1() {
                    unset($_SESSION['leaderboard']);
                }
                
                
            ?>
        </div>

<?php require 'footer.php'; ?>

