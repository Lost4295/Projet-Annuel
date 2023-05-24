<?php require 'header.php' ?>
<h1>Paramètres</h1>
<a href="https://iredadmin.thearena.litecloud.fr/iredadmin" class="btn btn-primary">Modifier les paramètres mail</a>
<a href="https://sogo.thearena.litecloud.fr/sogo" class="btn btn-primary">Accéder aux mails de The Arena</a>

<h2> Ajouter une image</h2>

<form method="post" enctype="multipart/form-data">
    <input type="file" name="image" class="form-control" value="Ajouter une image" accept="image/*" onchange="loadFile(event)" />
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
$dirname = $_SERVER['DOCUMENT_ROOT'] . '\uploads\\captcha\\';

if (isset($_FILES['image'])) {
    $tmpName = $_FILES['image']['tmp_name'];
    $name = $_FILES['image']['name'];
    move_uploaded_file($tmpName, $dirname . $name);
} //FIXME : POTENTIAL BUG, Might not work so

$images = glob($dirname . "*.{jpg,gif,png}", GLOB_BRACE);
$active = $_SESSION['chosen_img'];

foreach ($images as $key => $image) { // TODO encoder les images en base64 pour les afficher
    $url = str_replace($_SERVER['DOCUMENT_ROOT'], '', $image);
    echo '<img src="' . $url . '" width=150px/><a href="/wiews/admin/delimg.php?src=' . $key . '" class="btn btn-primary">Supprimer l\'image</a><a href="/wiews/admin/chooseimg.php?src=' . $key . '" class="btn btn-primary">Choisir l\'image</a><br />';
}


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
$parties = array();

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

$responses = array();
$responses2 = array();
// Enregistrer les parties découpées
foreach ($parties as $index => $partie) {
    $nomFichier = 'partie' . generateRandCode() . '.jpg';
    imagejpeg($partie, $dirname . 'parts/' . $nomFichier, 100); // Enregistrement de la partie en tant que fichier JPEG avec une qualité de 100
    $name= str_replace('partie', '', $nomFichier);
    $name= str_replace('.jpg', '', $name);

    $responses[] = $nomFichier;
    $responses2[] = $name;
}
echo "<br />";
echo "<br />";
print_r($responses); echo '<br /><br />';
print_r($responses2);
// Libérer les ressources GD
imagedestroy($image);
foreach ($parties as $partie) {
    imagedestroy($partie);
}

// Afficher les parties découpées  
$images = glob($dirname . 'parts/' . "*.{jpg,gif,png}", GLOB_BRACE);
echo "<p>Captcha actuel :</p><div>";?>
<div class="drop-zone" id="resetZone"> Reset Zone
<?php foreach ($images as $key => $image) {
    $url = str_replace($_SERVER['DOCUMENT_ROOT'], '', $image);
    $name= str_replace('\uploads\captcha\parts/partie', '', $url);
    $name= str_replace('.jpg', '', $name);
    if ($key % 3 == 0) {
        echo "<br />";
    }

    echo '<img class="draggable" id="part' . $name . '" draggable="true" src="' . $url . '" width="100%" data-value="'.$name.'"/>';
}
echo "</div>"; ?>
</div>
<div>
    <div class="row">
        <div class="drop-zone" id="dropZone1"></div>
        <div class="drop-zone" id="dropZone2"></div>
        <div class="drop-zone" id="dropZone3"></div>
    </div>
    <div class="row">
        <div class="drop-zone" id="dropZone4"></div>
        <div class="drop-zone" id="dropZone5"></div>
        <div class="drop-zone" id="dropZone6"></div>
    </div>
    <div class="row">
        <div class="drop-zone" id="dropZone7"></div>
        <div class="drop-zone" id="dropZone8"></div>
        <div class="drop-zone" id="dropZone9"></div>
    </div>
</div>
<style>
    .draggable {
        width: 100px;
        height: 100px;
        background-color: #f1f1f1;
        margin: 0px;
        padding: 0px;
        cursor: move;
    }

    .drop-zone {
        width: 100px;
        height: 100px;
        background-color: #e0e0e0;
        margin: 0px;
        padding: 0px;
        border: 1px #000000 solid;
    }

    #resetZone {
        width: 500px;
        height: 500px;
        background-color: #e0e0e0;
        margin: 10px;
        padding: 20px;
    }
</style>
<script>
    // Sélection des éléments déplaçables et des éléments de dépôt
    const draggableElements = document.querySelectorAll('.draggable');
    const dropZoneElements = document.querySelectorAll('.drop-zone');
    const resetZone = document.getElementById('resetZone');


    // Ajout des gestionnaires d'événements aux éléments déplaçables
    draggableElements.forEach((draggable) => {
        draggable.addEventListener('dragstart', dragStart);
    });

    // Ajout des gestionnaires d'événements aux éléments de dépôt
    dropZoneElements.forEach((dropZone) => {
        dropZone.addEventListener('dragover', dragOver);
        dropZone.addEventListener('drop', drop);
    });

    // Gestionnaire d'événement pour la zone de réinitialisation
    resetZone.addEventListener('drop', resetDraggableElements);


    // Fonction de démarrage du glisser-déposer
    function dragStart(event) {
        const draggedElement = event.target;

        // Ajout de la classe CSS pour marquer l'élément en train d'être déplacé
        draggedElement.classList.add('dragging');

        // Définition des données à transférer
        event.dataTransfer.setData('text/plain', draggedElement.id);
    }

    // Fonction de survol de la zone de dépôt
    function dragOver(event) {
        event.preventDefault();

        // Vérifier si l'élément survolé est également un bloc "draggable"
        if (event.target.classList.contains('draggable')) {
            event.dataTransfer.dropEffect = 'none';
        } else {
            event.dataTransfer.dropEffect = 'move';
        }
    }

    // Fonction de largage dans la zone de dépôt
    function drop(event) {
        event.preventDefault();

        // Vérifier si la zone de dépôt contient déjà un élément draggable
        const existingDraggable = event.target.querySelector('.draggable');
        if (existingDraggable) {
            return;
        }

        const droppedElementId = event.dataTransfer.getData('text/plain');
        const droppedElement = document.getElementById(droppedElementId);

        // Déplacement de l'élément déposé dans la zone de dépôt
        event.target.appendChild(droppedElement);
    }

    function resetDraggableElements(event) {
        event.preventDefault();


        const droppedElementId = event.dataTransfer.getData('text/plain');
        const droppedElement = document.getElementById(droppedElementId);
        event.target.appendChild(droppedElement);
    }




    function getDataValuesInDropZone() {
  const dropZones = document.querySelectorAll('.drop-zone');
  const dataValues = [];

  dropZones.forEach(dropZone => {
    if (dropZone.parentNode.classList.contains('row')) {
      // Le div drop-zone est dans une drop zone
      const img = dropZone.querySelector('img');
      const dataValue = img.dataset.value;
      dataValues.push(dataValue);
    }
  });

  return dataValues;
}

// Utilisation de la fonction
const values = getDataValuesInDropZone();
console.log(values); // Affiche le tableau des data-values des divs dans les drop zones

</script>


<?php include 'footer.php' ?>