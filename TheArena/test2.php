<!-- TODO implémenter l'api de recherhe dans la création de compte -->
<!-- TODO ajouter l'api fetch pour faie des reherches sur le site -->
<!-- TODO faire en sorte de finir les events en entier (crud sur shop, back + front avec tout ce qu'il faut) -->
<!doctype html>
<html lang=fr>

<head>
    <meta charset=utf-8>
    <title>Test addok + fetch</title>
    <link rel="icon" href="data:;base64,iVBORw0KGgo=">
    <script>
        /* Use http://localhost:7878 if you run a local instance. */
        const url = new URL('http://api-adresse.data.gouv.fr/search')
        const params = {
            q: 'lil'
        }
        Object.keys(params).forEach(
            key => url.searchParams.append(key, params[key])
        )
        fetch(url)
            .then(response => {
                if (response.status >= 200 && response.status < 300) {
                    return response
                } else {
                    const error = new Error(response.statusText)
                    error.response = response
                    throw error
                }
            })
            .then(response => response.json())
            .then(data => console.log('request succeeded with JSON response', data))
            .catch(error => console.log('request failed', error))
    </script>
    <style>
        .draggable {
            width: 100px;
            height: 100px;
            background-color: #f1f1f1;
            margin: 5px;
            padding: 10px;
            cursor: move;
        }

        .drop-zone {
            width: 200px;
            height: 200px;
            background-color: #e0e0e0;
            margin: 10px;
            padding: 10px;
        }
    </style>
</head>

<body>
    <div class="draggable" id="part1" draggable="true">Part 1</div>
    <div class="draggable" id="part2" draggable="true">Part 2</div>
    <div class="draggable" id="part3" draggable="true">Part 3</div>

    <div class="drop-zone" id="dropZone1"></div>
    <div class="drop-zone" id="dropZone2"></div>
    <div class="drop-zone" id="dropZone3"></div>

    <div class="drop-zone" id="resetZone">Reset Zone</div>


</body>
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
</script>

</html>