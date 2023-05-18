<?php require 'header.php' ?>
<h1>Paramètres</h1>
<a href="https://iredadmin.thearena.litecloud.fr/iredadmin" class="btn btn-primary">Modifier les paramètres mail</a>
<a href="https://sogo.thearena.litecloud.fr/sogo" class="btn btn-primary">Accéder aux mails de The Arena</a>

<h2> Ajouter une image</h2>

<form method="post" enctype="multipart/form-data">
    <input type="file" name="image" class="form-control" value="Ajouter une image" accept="image/*" />
    <button type="submit">Envoyer</button>
</form>

<?php
if (isset($_FILES['image'])) {
        $tmpName = $_FILES['image']['tmp_name'];
        $name = $_FILES['image']['name'];
        $dirname=$_SERVER['DOCUMENT_ROOT'].'\uploads\\';
        move_uploaded_file($tmpName, $dirname.$name);
    } //FIXME : POTENTIAL BUG, Might not work so

    $images = glob($dirname."*.{jpg,gif,png}", GLOB_BRACE);

    print_r($images);

    foreach ($images as $image) {
        echo '<img src="'.$image.'" width=150px/><br />';
    }

 include 'footer.php'?>