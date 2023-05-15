<?php
$sql = "INSERT INTO `liste` (`produit`, `prix`, `nombre`) VALUES (:produit, :prix, :nombre);";

$query = $db->prepare($sql);

$query->bindValue(':produit', $produit, PDO::PARAM_STR);
$query->bindValue(':prix', $prix, PDO::PARAM_STR);
$query->bindValue(':nombre', $nombre, PDO::PARAM_INT);

$query->execute();
?>

<form method="post">
    <label for="produit">Produit</label>
    <input type="text" name="produit" id="produit">
    <label for="prix">Prix</label>
    <input type="text" name="prix" id="prix">
    <label for="nombre">Nombre</label>
    <input type="number" name="nombre" id="nombre">
    <button>Enregistrer</button>
</form>


<?php
require_once('connect.php');

if(isset($_POST)){
    if(isset($_POST['produit']) && !empty($_POST['produit'])
        && isset($_POST['prix']) && !empty($_POST['prix'])
        && isset($_POST['nombre']) && !empty($_POST['nombre'])){
            $produit = strip_tags($_POST['produit']);
            $prix = strip_tags($_POST['prix']);
            $nombre = strip_tags($_POST['nombre']);

            $sql = "INSERT INTO `liste` (`produit`, `prix`, `nombre`) VALUES (:produit, :prix, :nombre);";

            $query = $db->prepare($sql);

            $query->bindValue(':produit', $produit, PDO::PARAM_STR);
            $query->bindValue(':prix', $prix, PDO::PARAM_STR);
            $query->bindValue(':nombre', $nombre, PDO::PARAM_INT);

            $query->execute();
            $_SESSION['message'] = "Produit ajouté avec succès !";
            header('Location: index.php');
        }
}

require_once('close.php');