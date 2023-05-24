<?php require 'header.php' ?>
<h1>Paramètres</h1>
<a href="https://iredadmin.thearena.litecloud.fr/iredadmin" class="btn btn-primary">Modifier les paramètres mail</a>
<a href="https://sogo.thearena.litecloud.fr/sogo" class="btn btn-primary">Accéder aux mails de The Arena</a>

<h2> Ajouter une image</h2>

<form method="post" enctype="multipart/form-data">
    <input type="file" name="image" class="form-control"  value="Ajouter une image" accept="image/*" onchange="loadFile(event)"/>
    <div id="captchaHelpBlock" class="form-text">Tentez de prendre une image carrée, pour aider les utilisateurs.</div>
    <img id="output" src=" " width="500" height=auto />
        <script>
            var loadFile = function(event) {
                var output = document.getElementById('output');
                output.src = URL.createObjectURL(event.target.files[0]);
            };
        </script>
    <button type="submit" class="btn btn-primary">Envoyer</button>
</form>

<?php
$dirname=$_SERVER['DOCUMENT_ROOT'].'/uploads/captcha/';

if (isset($_FILES['image'])) {
        $tmpName = $_FILES['image']['tmp_name'];
        $name = $_FILES['image']['name'];
        move_uploaded_file($tmpName, $dirname.$name);
    } //FIXME : POTENTIAL BUG, Might not work so

    $images = glob($dirname."*.{jpg,gif,png}", GLOB_BRACE);
    $active = array_rand($images);

    foreach ($images as $key => $image) {// TODO encoder les images en base64 pour les afficher
        $url = str_replace($_SERVER['DOCUMENT_ROOT'], '', $image);
        echo '<img src="'.$image.'" width=150px/><a href="/wiews/admin/delimg.php?src='.$key.'" class="btn btn-primary">Supprimer l\'image</a><br />';
    }


// Chemin vers l'image d'origine
$path_info = pathinfo($images[$active]);

if ($path_info['extension'] == 'jpg') {
    $image = imagecreatefromjpeg($images[$active]);
} elseif ($path_info['extension'] == 'png') {
    $image = imagecreatefrompng($images[$active]);
} elseif ($path_info['extension'] == 'gif') {
    $image = imagecreatefromgif($images[$active]);
} else {
    echo "Erreur : le format de l'image n'est pas supporté";
}

// Déterminer les dimensions de découpe
$largeur = imagesx($image);
$hauteur = imagesy($image);
$partieLargeur = $largeur / 3;
$partieHauteur = $hauteur / 3;
// Découper l'image en parties
$parties = array();

for ($i = 0; $i < 3; $i++) {
  for ($j = 0; $j < 3; $j++) {
    $x = $j * $partieLargeur;
    $y = $i * $partieHauteur;
    $partie = imagecrop($image, ['x' => $x, 'y' => $y, 'width' => $partieLargeur, 'height' => $partieHauteur]);
    $parties[] = $partie;
  }
}
$images = glob($dirname.'/parts/'."*.{jpg,gif,png}", GLOB_BRACE);
foreach ($images as $oldImage) {
    unlink($oldImage);
}
// Enregistrer les parties découpées
foreach ($parties as $index => $partie) {
  $nomFichier = 'partie' . ($index + 1) . '.jpg';
  imagejpeg($partie, $dirname.'/parts/'.$nomFichier, 100); // Enregistrement de la partie en tant que fichier JPEG avec une qualité de 100
}

// Libérer les ressources GD
imagedestroy($image);
foreach ($parties as $partie) {
  imagedestroy($partie);
}
 include 'footer.php'?>

