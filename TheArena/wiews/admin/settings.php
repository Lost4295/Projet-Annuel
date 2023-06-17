<?php require 'header.php' ?>
<div class="my-3">
    <h1>Paramètres</h1>
    <a href="https://iredadmin.thearena.litecloud.fr/iredadmin" class="btn btn-primary">Modifier les paramètres mail</a>
    <a href="https://sogo.thearena.litecloud.fr/sogo" class="btn btn-primary">Accéder aux mails de The Arena</a>


    <?php if (isset($_POST)) {
        if (count($_POST) == 2 && isset($_POST["number"]) && isset($_POST["time"])) {
            $number = $_POST["number"];
            $time = $_POST["time"];

            $possibleTimes = ["day", "month"];

            if (!in_array($time, $possibleTimes)) {
                $_SESSION["message_type"] = "danger";
                $_SESSION["message"] = "Le temps n'est pas valide !";
                header('Location: /admin/settings');
                exit();
            } else {
                $time = $time == "day" ? "jours" : "mois";


                if (!is_numeric($number)) {
                    $_SESSION["message_type"] = "danger";
                    $_SESSION["message"] = "Le nombre n'est pas valide !";
                    header('Location: /admin/settings');
                    exit();
                } else {
                    $number = intval($number);
                    if ($number < 0) {
                        $_SESSION["message_type"] = "danger";
                        $_SESSION["message"] = "Le nombre n'est pas valide !";
                        header('Location: /admin/settings');
                        exit();
                    } else {
                        if ($time === "jours") {
                            $number = $number * 60 * 60 * 24;
                        } else {
                            $number = $number * 60 * 60 * 24 * 30;
                        }
                        if (!file_put_contents($_SERVER["DOCUMENT_ROOT"]."\\core\\number.php",'<?php $number='.$number.';')){
                                echo "erreur rjifdercuedhdehujhfjhzferjhfzs";
                            };
                    }
                }
            }
            $_SESSION["message_type"] = "success";
            $_SESSION["message"] = "Les paramètres ont bien été modifiés !";
        }
    } ?>
    <form method="post">
        <input type="number" name="number" class="form-control">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="time" value="day" id="day">
            <label class="form-check-label" for="day">
                Jour(s)
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="time" value="month" id="month">
            <label class="form-check-label" for="month">
                Moi(s)
            </label>
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>

</div>
<div class="my-3">
    <h2> Ajouter une image</h2>
</div>
<form method="post" enctype="multipart/form-data" class="mb-4">
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
}

$images = glob($dirname . "*.{jpg,gif,png}", GLOB_BRACE);

echo "<table class='table'><thead><tr><th scope='col'>Image</th><th scope='col'>Supprimer</th></tr></thead><tbody>";
foreach ($images as $key => $image) {
    echo '<tr>';
    $url = str_replace($_SERVER['DOCUMENT_ROOT'], '', $image);
    echo '<td><img src="' . $url . '" width=150px/></td>';
    echo '<td><a href="/wiews/admin/delimg.php?src=' . $key . '" class="btn btn-primary">Supprimer l\'image</a></td></tr>';
}
echo "</tbody></table>";



include 'footer.php' ?>