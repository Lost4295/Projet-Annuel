<?php

require $_SERVER['DOCUMENT_ROOT'] . "/core/functions.php";
$db = connectToDB();
if (isset($_GET['name']) && !empty($_GET['name'])) {
    $name = strip_tags($_GET['name']);
    $query = $db->prepare('SELECT * FROM ' . PREFIX . 'events WHERE `name`=:name');
    $query->execute([':name' => $name]);
    $event = $query->fetch(PDO::FETCH_ASSOC);
    if (!$event) {
        $_SESSION['message'] = "Cet évènement n'existe pas.";
        $_SESSION['message_type'] = "danger";
        header('Location: /');
    } else {
        $nquery = $db->prepare('SELECT * FROM ' . PREFIX . 'tournaments WHERE `event_id`=:event_id');
        $nquery->execute([':event_id' => $event['id']]);
        $tournaments = $nquery->fetchAll(PDO::FETCH_ASSOC);
        if (!$tournaments) {
            $_SESSION['message'] = "Cet évènement n'a pas de tournoi.";
            $_SESSION['message_type'] = "danger";
            header('Location: /event?name=' . $name);
        }
    }
} else {
    $_SESSION['message'] = "Cet évènement n'existe pas.";
    $_SESSION['message_type'] = "danger";
    header('Location: /');
}
include $_SERVER['DOCUMENT_ROOT'] . "/core/header.php";
?>

<h1>Inscription à <?php echo "\"" . $name . "\"" ?></h1>
<div class="row ps-2">
    <div class="col-5">
        <form action="" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Nom affiché </label>
                <input type="text" class="form-control" id="name" value="<?php if (isset($attr)) {
                                                                                echo $attr[1];
                                                                            } ?>">
                <div class="form-text"> Ce nom sera affiché pendant le(s) tournoi(s).</div>
            </div>
            <h4>Inscription aux événements</h4>
            <div class="mb-3">
                <?php print_r($tournaments);
                foreach ($tournaments as $key => $tournament) { ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="<?php echo $tournament['id'] ?>" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault"><?php echo $tournament['name'] ?></label>
                    </div>
                <?php } ?>
                <!-- if invalide bah bam-->
                <div class="invalid">Veuillez choisir au moins 1 événement.</div>
            </div>
            <h4>Paiement</h4>
            <div class="mb-3">
                <!-- le truc de paiment jsp-->
            </div>
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="paying" required>
                    <label class="form-check-label" for="paying">Je comprends que le paiement que j’effectue (s’il y en a un) part vers l’organisateur.trice.s et que je ne pourrai pas être remboursé par the Arena en cas de litige. </label>
                </div>
            </div>
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="cgu" required>
                    <label class="form-check-label" for="cgu">J’ai lu et accepté les <a href="/cgu">Termes et Conditions</a> de The Arena</label>
                </div>
            </div>
            <div class="mb-3">
                <div class="row mt-5 mb-3 pr-5">
                    <label class="form-check-label">
                        Vérifiez que vous n'êtes pas un robot, en reconstituant l'image ci-dessous.
                    </label>
                    <div class="col">
                        <?php require $_SERVER['DOCUMENT_ROOT'] . '/core/createCaptcha.php' ?>
                    </div>
                </div>
                <div class="row px-5">
                    <div class="col-auto p-0">
                        <div class="drop-zone" id="dropZone1"></div>
                    </div>
                    <div class="col-auto p-0">
                        <div class="drop-zone" id="dropZone2"></div>
                    </div>
                    <div class="col-auto p-0">
                        <div class="drop-zone" id="dropZone3"></div>
                    </div>
                </div>
                <div class="row px-5">
                    <div class="col-auto p-0">
                        <div class="drop-zone" id="dropZone4"></div>
                    </div>
                    <div class="col-auto p-0">
                        <div class="drop-zone" id="dropZone5"></div>
                    </div>
                    <div class="col-auto p-0">
                        <div class="drop-zone" id="dropZone6"></div>
                    </div>
                </div>
                <div class="row px-5">
                    <div class="col-auto p-0">
                        <div class="drop-zone" id="dropZone7"></div>
                    </div>
                    <div class="col-auto p-0">
                        <div class="drop-zone" id="dropZone8"></div>
                    </div>
                    <div class="col-auto p-0">
                        <div class="drop-zone" id="dropZone9"></div>
                    </div>
                </div>
                <div class="m-5">
                    <button type="submit" class="btn btn-primary d-block mx-auto btn-lg">Finaliser l'inscription</button>
                </div>
            </div>

        </form>
        <script>
            const draggableElements = document.querySelectorAll('.draggable');
            const dropZoneElements = document.querySelectorAll('.drop-zone');
            const resetZone = document.getElementById('resetZone');



            draggableElements.forEach((draggable) => {
                draggable.addEventListener('dragstart', dragStart);
            });


            dropZoneElements.forEach((dropZone) => {
                dropZone.addEventListener('dragover', dragOver);
                dropZone.addEventListener('drop', drop);
            });


            resetZone.addEventListener('drop', resetDraggableElements);



            function dragStart(event) {
                const draggedElement = event.target;


                draggedElement.classList.add('dragging');


                event.dataTransfer.setData('text/plain', draggedElement.id);
            }


            function dragOver(event) {
                event.preventDefault();


                if (event.target.classList.contains('draggable')) {
                    event.dataTransfer.dropEffect = 'none';
                } else {
                    event.dataTransfer.dropEffect = 'move';
                }
            }

            function drop(event) {
                event.preventDefault();

                const existingDraggable = event.target.querySelector('.draggable');
                if (existingDraggable) {
                    return;
                }

                const droppedElementId = event.dataTransfer.getData('text/plain');
                const droppedElement = document.getElementById(droppedElementId);

                event.target.appendChild(droppedElement);
                checkAllDropZonesFilled();
                draggableElements.forEach(function(image) {
                    if (resetZone.contains(image)) {
                        image.classList.add('with-margin');
                    } else {
                        image.classList.remove('with-margin');
                    }
                });
            }

            function resetDraggableElements(event) {
                event.preventDefault();


                const droppedElementId = event.dataTransfer.getData('text/plain');
                const droppedElement = document.getElementById(droppedElementId);
                event.target.appendChild(droppedElement);
                if (resetZone.contains(droppedElement)) {
                    droppedElement.classList.add('with-margin');
                } else {
                    droppedElement.classList.remove('with-margin');
                }
            };


            function checkAllDropZonesFilled() {
                let dropZones = document.getElementsByClassName("drop-zone");
                for (let i = 0; i < dropZones.length; i++) {
                    let dropZone = dropZones[i];
                    if (!dropZone.innerHTML.trim()) {
                        return false;
                    }
                }
                return getDataValuesInDropZone();
            }

            function getDataValuesInDropZone() {
                const dropZones = document.querySelectorAll('.drop-zone');
                const dataValues = [];

                dropZones.forEach(dropZone => {
                    if (dropZone.parentNode.classList.contains('row')) {
                        const img = dropZone.querySelector('img');
                        const dataValue = img.dataset.value;
                        dataValues.push(dataValue);
                    }
                });
                return dataValues;
            }

            function checkCaptcha() {
                if (document.getElementById('cgu').checked) {
                    let dataValues = checkAllDropZonesFilled();
                    if (dataValues) {
                        let xhr = new XMLHttpRequest();
                        xhr.onload = function() {
                            if (this.status == 200) {
                                let response = JSON.parse(this.responseText);
                                if (response.success == true) {
                                    document.getElementById('allform').submit();
                                } else {
                                    alert('Captcha invalide. Merci de réessayer.');
                                    text3.setAttribute("class", "text-danger");
                                }
                            }
                        }
                        xhr.open('POST', '/checkCaptcha', true);
                        let data = new FormData();
                        data.append('dataValues', JSON.stringify(dataValues));
                        xhr.send(data);
                    } else {
                        alert('Veuillez remplir tous les champs.');
                        text3.setAttribute("class", "text-danger");
                    }
                } else {
                    alert('Veuillez accepter les CGU.');
                    text3.setAttribute("class", "text-danger");
                }
            }
        </script>

        <div class="ms-5 col-6 float-end">
            <div class="border-start p-5">
                <div class="border-bottom">
                    <h3 class="text-center">Récapitulatif</h3>
                </div>
                <div class="d-flex justify-content-center py-3 border-bottom">
                    <table class="w-50">
                        <tr>
                            <td>Sous total</td>
                            <td class="text-success">Gratuit</td>
                        </tr>
                        <tr>
                            <td>Taxes</td>
                            <td class="text-success">Gratuit</td>
                        </tr>
                    </table>
                </div>
                <div class="d-flex justify-content-around py-3">
                    <div>Total</div>
                    <div class="text-success">Gratuit</div>
                </div>
            </div>
        </div>
    </div>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/core/footer.php" ?>