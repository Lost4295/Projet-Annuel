<?php require $_SERVER['DOCUMENT_ROOT'] . '/core/header.php' ?>
<div class="row my-3 ">
    <div class="col my-3 d-flex">
        <video class="homevideo" src="/img/homevideo.mp4" autoplay loop muted disablePictureInPicture>
            <p>Votre navigateur ne prend pas en charge les vidéos HTML5.
                Voici <a href="/img/homevideo.mp4">un lien pour télécharger la vidéo</a>.</p>
        </video>
    </div>
</div>
<div class="row my-3">
    <div class="col my-3 d-flex flex-wrap title">
        <h2><strong>Événements à l'affiche :</strong></h2> <!-- 2ème truc qui slide-->
    </div>
</div>
<div class="row my-3">
    <div class="col my-3 d-flex justify-content-around">
        <img style="position: relative; left:0; width:200px; height:200px;" src="#">
        <img style="position: relative; left:0; width:200px; height:200px;" src="#">
    </div>
</div>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/core/footer.php' ?>