<?php 
session_start();
unset($_SESSION ['username']);
if(!isset($_SESSION['count'])){
    $_SESSION['count']=0;
}
if (!isset($_SESSION['listeuser'])){
    $_SESSION['listeuser']=[];
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
$username=$_POST['username'];


if ($username == $_SESSION['username'] && !empty($username)) {
    $_SESSION['count']++;
} else if (!empty($username)){ 
    $_SESSION['count']=1;
    $_SESSION['username']=$username;
    $_SESSION['userlist'][$username]=""; 
    $_SESSION["nbcalcul"]=0;
    $_SESSION["vie"]=3;
}  else { 
    $_SESSION['count'] = 0;
  } 
  }

?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta name="Page" content="Quelle page magnifique">
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style.css">
        <title>Nom de page </title>
        
    </head>
    <body>
        <form method="post" action="register.php">
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
    <p>Bonjour <?php echo $username;?>, vous avez vu cette page <?php echo $_SESSION['count']; ?> fois d'afilée.</p><br>

    <button class='styled'><a href='index.php'> index </a></button><br><br>
    <button class="styled"> <a href="game.php"> Aller au jeu </a></button>

    
   
    </body>
</html>