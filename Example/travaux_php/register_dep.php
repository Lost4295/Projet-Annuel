<!-- Cette page est dépréciée, il faut la remplacer par l'autre register.php sur le repo -->


<?php 
session_start();
unset($_SESSION ['username']);
if (!isset($_SESSION['listeuser'])){
    $_SESSION['listeuser']=[];
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $username=$_POST['username'];
    if (!empty($username)){ 
        $_SESSION['username']=$username;
        $_SESSION['userlist'][$username]=""; 
        $_SESSION["nbcalcul"]=0;
        $_SESSION["vie"]=3;
    }  
}
require 'header.php';
?>
        <form method="post" action="register_dep.php">
            <label for="username">Nom d'utilisateur:</label><br>
            <input list="username" id="username" name="username">
            <datalist id="username">
                <?php 
                $_SESSION['listeuser']=array();
                    if (!empty($username)) { // Si on reçoit un nouveau nom d'utilisateur
                        foreach( $_SESSION['listeuser'] as $cle => $username){
                            echo "<option value='$username'> $username </option>";
                            if ($username!== $_SESSION['listeuser'][-1]){
                                $_SESSION['listeuser'][$username] = $username;
                            };
                        var_dump($_SESSION['listeuser']);
                    }}
                ?>
            </datalist><br>
            <input type="submit" value="Enregistrer">
        </form>
    <a href='index.php' class=" btn btn-primary"> index </a><br><br>
    <a href="game.php" class=" btn btn-primary"> Aller au jeu </a>
<?php require 'footer.php';