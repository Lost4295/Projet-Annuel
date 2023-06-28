<?php 

require $_SERVER['DOCUMENT_ROOT']."/core/functions.php";
redirectIfNotConnected();
require $_SERVER['DOCUMENT_ROOT']."/core/header.php";
$connection = connectToDB();
$queryPrepared = $connection->prepare("SELECT * FROM " . PREFIX . "users WHERE email=:email");
$queryPrepared->execute([
    "email" => $_SESSION["email"]
]);

$result = $queryPrepared->fetch(PDO::FETCH_ASSOC);
if (!empty($result)) {
    $firstname = $result["first_name"];
    $lastname = $result["last_name"];
    $username = $result["username"];
    $birthdate = $result["birthdate"];
    $email = $result["email"];
    $password = $result["password"];
    $scope = $result["scope"];
    $phone = $result["phone"];
    $address = $result["address"];
    $newsletter = $result["newsletter"];
    $avatar = $result["avatar"];
    $about = $result["about"];
} else {
    $_SESSION["message"] = "Une erreur est survenue.";
    $_SESSION["message_type"] = "danger";
    header("Location: /");
    exit(); 
}
?>

<div class="w-100">
    <h1> Ma page </h1>
    <div class="d-flex justify-content-center my-5"><img src="<?php echo $avatar ?>" width="150" height="150"/></div>
    <h3>À propos de moi</h3>
    <h3><?php echo $username ?></h3>
    <div class="my-3"><p><?php echo $about ?></p></div>
    <div class="d-flex justify-content-center"><a title="Modifier les informations" href="me_modify" class="btn btn-primary mb-5">Modifier les informations</a></div>
    <div class="d-flex justify-content-center"><a title="Obtenir mes informations (PDF)" href="/core/exporteddata.php" class="btn btn-primary mb-5">Obtenir mes informations en PDF</a></div>
</div>



<?php require $_SERVER['DOCUMENT_ROOT']."/core/footer.php" ?>