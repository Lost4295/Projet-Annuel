<?php require 'header.php' ?>
<?php 
    session_start();
    require 'functions.php';
?>
<?php require 'constantes.php'?>

<h1>Utilisateurs</h1>
<?php

	$connect = connectToDB();
	$résultats = $connexion -> execute(" SELECT * FROM ". PREFIX ."users");

	$listOfUsers = $résultats -> fetchAll();

?>
<table class="table table-hover table-bordered w-100" aria-describedby="users-list">
    <thead>
        <th>Pseudo</th>
        <th>Email</th>
        <th>Contenu</th><!-- d'autres infos au besoin jsp -->
        <th>Actions</th>
    </thead>
    <tbody>
<?php
    foreach ( $listOfUsers  as  $user ){
					echo " <tr> ";

					echo " <td> ". $user ["id"]." </td> " ;
					echo " <td> ". $user ["scope"]." </td> " ;
					echo " <td> ". $user ["first_name"]." </td> " ;
					echo " <td> ". $user ["last_name"]." </td> " ;
					echo " <td> ". $user ["email"]." </td> " ;
					echo " <td> ". $user ["phone"]." </td> " ;
					echo " <td> ". $user ["adress"]." </td> " ;
					echo " <td> ". $user ["postal_code"]." </td> " ;
					echo " <td> ". $user ["country"]." </td> " ;
					echo " <td> ". $user ["creation_date"]." </td> " ;
					echo " <td> ". $user ["last_access_date"]." </td> " ;
					echo " <td> ". $user ["update_at"]." </td> " ;
					echo " <td> ". $user ["visibility"]." </td> " ;
					echo " <td> ". $user ["status"]." </td> " ;
					echo " <td><a href='removeUser.php'?id= ". $user["id"]." ' class='btn btn-danger'>Supprimer</a></td> ";
					
                    echo " </tr> ";
				}
?>
    </tbody>
</table>
<?php include 'footer.php'?>
