<?php
    require $_SERVER['DOCUMENT_ROOT'].'/core/functions.php';

if(isset($_POST)){
    if(isset($_POST['id']) && !empty($_POST['id'])
        && isset($_POST['produit']) && !empty($_POST['produit'])
        && isset($_POST['prix']) && !empty($_POST['prix'])
        && isset($_POST['nombre']) && !empty($_POST['nombre'])){
        $id = strip_tags($_GET['id']);
        $produit = strip_tags($_POST['produit']);
        $prix = strip_tags($_POST['prix']);
        $nombre = strip_tags($_POST['nombre']);

        $query = $db->prepare( "UPDATE `table` SET `produit`=:produit, `prix`=:prix, `nombre`=:nombre WHERE `id`=:id;");

        $query->execute([
            ':produit'=>$produit,
            ':prix'=> $prix,
            ':nombre'=> $nombre,
            ':id'=> $id
            ]);

        header('Location: index.php');
    }
}

if(isset($_GET['id']) && !empty($_GET['id'])){
    $id = strip_tags($_GET['id']);
    $query = $db->prepare("SELECT * FROM `table` WHERE `id`=:id;");
    $query->execute([':id'=> $id]);
    $result = $query->fetch();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des produits</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <h1>Modifier un produit</h1>
    <form method="post">
        <p>
            <label for="produit">Produit</label>
            <input type="text" name="produit" id="produit" value="<?= $result['produit'] ?>">
        </p>
        <p>
            <label for="prix">Prix</label>
            <input type="text" name="prix" id="prix" value="<?= $result['prix'] ?>">
        </p>
        <p>
            <label for="nombre">Nombre</label>
            <input type="number" name="nombre" id="nombre" value="<?= $result['nombre'] ?>">
        </p>
        <p>
            <button>Enregistrer</button>
        </p>
        <input type="hidden" name="id" value="<?= $result['id'] ?>">
    </form>
</body>
</html>