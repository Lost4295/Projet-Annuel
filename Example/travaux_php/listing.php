
<?php 
session_start();
$tableau = unserialize(file_get_contents('users.dat'));
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if(array_key_exists('modify', $_POST)) {
        if($tableau[$_POST['login']]['rights'] == 0){
            $tableau[$_POST['login']]['rights']= 1;
        } else if($tableau[$_POST['login']]['rights'] == 1){
            $tableau[$_POST['login']]['rights']=0;
        } file_put_contents('users.dat', serialize($tableau));
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
        <header class="listing">
            
            <a class=' btn btn-primary' href='index.php'> index </a>
            <a class=' btn btn-primary' href='userpage.php'> Retour </a>
            <?php if(!isset($tableau[$_SESSION['users']]['image'])){$tableau[$_SESSION['users']]['image']= base64_encode_image('placeholder user.png', 'png');}  echo "<img src= '" . $tableau[$_SESSION['users']]['image'] . "'class='little'/>";?>
            <a class="linklisted" href="userpage.php"><?php echo  $_SESSION['users'] ?></a>
        </header>
    <br><br>
    
    <table class="listing">
            <?php
                $res = array("Pseudo","Nom", "Prenom","mot de passe","genre","image", "droits");
                echo "<tr>";
                foreach($res as $cle => $valeur) { 
                    echo "<th>$valeur</th>";
                }
                echo "</tr>"; 
                
                foreach($tableau as $cle => $valeurs) { 
                    if(empty($valeurs['rights'])){
                        $valeurs['rights']="user";
                    }
                    if($valeurs['rights'] == 1){
                        $valeurs['rights']="superuser";
                    }
                    if(!isset($valeurs['image'])){
                        $valeurs['image']= base64_encode_image('placeholder user.png', 'png');
                    }
                    echo "<tr>"; 
                    echo "<td>" . $cle . "</td>";
                    echo "<td>" . $valeurs['name'] . "</td>";
                    echo "<td>" . $valeurs['lastname'] . "</td>";
                    echo "<td>" . $valeurs['password'] . "</td>";
                    echo "<td>" . $valeurs['gender'] . "</td>";
                    echo "<td> <img src= '" . $valeurs['image'] . "'/> </td>";
                    echo "<td>" . $valeurs['rights'];
                    if( $tableau[$_SESSION['users']]['rights'] == 1)
                        {?>
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" enctype= "multipart/form-data">
                            <input type="submit" name="modify" class="button btn btn-primary" value="Modifier" />
                            <input type="hidden" name="login" value=<?php echo "'" . $cle . "'";?>/>
                        </form>
                    <?php }
                    echo "</td>";
                    echo"</tr>"; 
                }?>
        </table><br><br><br>

<?php require 'footer.php';