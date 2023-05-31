<?php
$dirname = $_SERVER['DOCUMENT_ROOT'] . '\uploads\\captcha\\';

$images = glob($dirname . "*.{jpg,gif,png}", GLOB_BRACE);
$active = $images[array_rand($images)];
// Chemin vers l'image d'origine
$path_info = pathinfo($active);


if ($path_info['extension'] == 'jpg') {
    $image = imagecreatefromjpeg($active);
} elseif ($path_info['extension'] == 'png') {
    $image = imagecreatefrompng($active);
} elseif ($path_info['extension'] == 'gif') {
    $image = imagecreatefromgif($active);
} else {
    echo "Erreur : le format de l'image n'est pas supporté";
}

// Déterminer les dimensions de découpe
$largeur = imagesx($image);
$hauteur = imagesy($image);
$partieLargeur = $largeur / 3;
$partieHauteur = $hauteur / 3;
// Découper l'image en parties
$parties = [];

for ($i = 0; $i < 3; $i++) {
    for ($j = 0; $j < 3; $j++) {
        $x = $j * $partieLargeur;
        $y = $i * $partieHauteur;
        $partie = imagecrop($image, ['x' => $x, 'y' => $y, 'width' => $partieLargeur, 'height' => $partieHauteur]);
        $parties[] = $partie;
    }
}
$images = glob($dirname . 'parts/' . "*.{jpg,gif,png}", GLOB_BRACE);
foreach ($images as $oldImage) {
    unlink($oldImage);
}

$responses = [];
$responses2 = [];

foreach ($parties as $image) {
    $nomFichier = 'image' . generateRandCode() . '.jpg';
    imagejpeg($image, $dirname . 'parts/' . $nomFichier, 100); // Enregistrement de la partie en tant que fichier JPEG avec une qualité de 100
    $name = str_replace('image', '', $nomFichier);
    $name = str_replace('.jpg', '', $name);

    $responses[] = $nomFichier;
    $responses2[] = $name;
}

file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/core/captcha.json', json_encode($responses2));
// Libérer les ressources GD
imagedestroy($image);
foreach ($parties as $partie) {
    imagedestroy($partie);
}

// Afficher les parties découpées
$images = glob($dirname . 'parts/' . "*.{jpg,gif,png}", GLOB_BRACE);
?>

<img src="<?php echo str_replace($_SERVER['DOCUMENT_ROOT'], '',$active) ?>" alt="initial_image">

<div class="drop-zone" id="resetZone">
    <?php foreach ($images as $key => $image) {
        $url = str_replace($_SERVER['DOCUMENT_ROOT'], '', $image);
        $name = str_replace('\uploads\captcha\parts/image', '', $url);
        $name = str_replace('.jpg', '', $name);
        echo '<img class="draggable with-margin" id="part' . $name . '" draggable="true" src="' . $url . '" width="100%" data-value="' . $name . '"/>';
    } ?><script>
    function shuffleCaptcha(){
        var parent = document.getElementById("resetZone");
        var divs = parent.children;
        var frag = document.createDocumentFragment();
        while (divs.length) {
            frag.appendChild(divs[Math.floor(Math.random() * divs.length)]);
        }
        parent.appendChild(frag);
    } 
</script>
    <script>shuffleCaptcha();</script>
</div>
</div>
