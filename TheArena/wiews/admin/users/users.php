<?php require $_SERVER['DOCUMENT_ROOT']."/wiews/admin/header.php";
define("TD", "<td>");
define("ENDTD", "</td>");?>

<h1>Utilisateurs</h1>
<?php
	$db= connectToDB();
	$query = $db->query(" SELECT * FROM ". PREFIX ."users");
	$listOfUsers = $query->fetchAll(PDO::FETCH_ASSOC);
	?>

<table class="table table-hover table-bordered w-100" aria-describedby="users-list">
    <thead>
		<th>id</th>
		<th>Scope</th>
		<th>Pseudo</th>
		<th>Email</th>
		<th>visibility</th>
		<th>Statut</th>
		<th>Actions</th>
    </thead>
    <tbody>
<?php
    foreach ($listOfUsers as $user){
					echo " <tr> ";
					echo TD.$user["id"].ENDTD ;
					echo TD.$user["scope"].ENDTD ;
					echo TD.$user["username"].ENDTD ;
					echo TD.$user["email"].ENDTD ;
					echo TD.$user["phone"].ENDTD ;
					echo TD.$user["address"].ENDTD ;
					echo TD.$user["postal_code"].ENDTD ;
					echo TD.$user["country"].ENDTD ;
					echo TD.$user["visibility"].ENDTD ;
					echo TD.$user["status"].ENDTD ;
					echo TD."<a href='/admin/users/read?id= ". $user["id"]." ' class='btn btn-info'>Plus d'informations</a>".ENDTD;
					
                    echo " </tr> ";
				}
?>
    </tbody>
</table>
<?php require $_SERVER['DOCUMENT_ROOT']."/wiews/admin/footer.php" ?>
