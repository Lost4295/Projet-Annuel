<?php require '../core/header.php' ?>

<div class="container-fluid ">
    <div class="row">
        <div class="col-3 d-flex flex-wrap flex-column justify-content-around align-content-center bg-secondary"><!--notre sidebar-->
            <div class="w-100 d-flex flex-column justify-content-between">
                <a href="#" class="my-3 w-100 btn btn-warning">Accueil</a>
                <a href="#" class="my-3 w-100 btn btn-warning">Événements</a>
                <a href="#" class="my-3 w-100 btn btn-warning">Power Ranking</a>
                <a href="#" class="my-3 w-100 btn btn-warning">Forum</a>
            </div>
        <p>Pages récentes:</p>
        <div class="w-75 justify-content-center d-flex">
            <ul>
                <li>bla</li>
                <li>bla</li>
                <li>bli</li>
            </ul>  
        </div>
        </div>
        <div class="col-9 my-3 py-4 d-flex align-content-center flex-column flex-wrap">
            <div class="row my-3">
                <div class="col my-3"> <!--Caroussel-->
                    <img style="position: relative; left:0; width:500px; height:200px;" src="#">
                </div>
            </div>
            <div class="row my-3">
                <div class="col my-3" style="position:relative; right:215px;">
                    <h2><strong><u>Événements à l'affiche :</u></strong></h2> <!-- 2ème truc qui slide-->
                </div>
            </div>
            <div class="row my-3">
                <div class="col my-3 d-flex justify-content-around">
                    <img style="position: relative; left:0; width:200px; height:200px;" src="#">
                    <img style="position: relative; left:0; width:200px; height:200px;" src="#">
                </div>
            </div>
        </div>
    </div>
</div>

<?php require '../core/footer.php' ?>