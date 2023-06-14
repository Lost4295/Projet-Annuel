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
        <h2><strong>Événements à l'affiche :</strong></h2>
        <?php $db = connectToDB();
        $query = $db->query("SELECT * FROM " . PREFIX . "events");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        ?>
    </div>
</div>
<div class="row my-3">
    <div class="col my-3 d-flex justify-content-around" id="actualevents">
        <img style="position: relative; left:0; width:200px; height:200px;" src="<?php echo '#' ?>">
        <img style="position: relative; left:0; width:200px; height:200px;" src="#">
    </div>
</div>
<script>
    let dataEvents = <?php echo json_encode($result); ?>;
    if (dataEvents) {
        var i = 1
    } else {
        var i = 0
    }
    for (element of dataEvents) {
        i += 1
        let a = document.createElement('a')
        let img = document.createElement('img')
        img.src = element.image
        img.style = "position: relative; left:0; width:200px; height:200px; transition:0.5s"
        a.style.display = 'none';
        a.href = `/event?name=${element.name}`;
        a.dataset.set('value', i)
        a.appendChild(img)
        document.getElementById("actualevents").appendChild(a)
    }
    let size = dataEvents.length
    setInterval(function() {



    }, 5000)
</script>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/core/footer.php' ?>