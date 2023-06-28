<?php 
require $_SERVER['DOCUMENT_ROOT']."/core/functions.php";
$db= connectToDB();
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = strip_tags($_GET['id']);
    $query = $db->prepare('SELECT * FROM '.PREFIX.'user_reports WHERE `id`=:id');
    $query->execute([':id'=>$id]);
    $report = $query->fetch();
    if (!$report) {
        header('Location: /admin/users');
    }
} else {
    header('Location: /admin/users');
}
require 'header.php'
?>

<h1>Signalement</h1>

<p>ID : <?php echo $report["id"] ?></p>
<p>ID de l'objet signalé : <?php echo $report["reported_id"] ?></p>
<p>Contenu signalé : <?php echo $report["content"] ?></p>
<p>Utilisateur signalant : <?php echo $report["user_id"] ?></p>
<p>Date : <?php echo $report["date"] ?></p>
<p>Discriminant : <?php echo $report["discr"] ?></p>




<!-- Ici mettre toutes les infos concernant un signalement, et un form avec ce qu'on fait :  boutons (oui, ou non) ;
oui ==> modale select (pour les punitions), et textarea (explication de la sentence)  -->
<?php include 'footer.php'?>

