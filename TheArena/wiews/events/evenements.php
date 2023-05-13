<?php require $_SERVER['DOCUMENT_ROOT']."/core/header.php" ?>

        <div class="col-9 my-3 py-4 d-flex align-content-center flex-column flex-wrap">
            <div class="row my-3">
                <h2>Événements</h2>
            </div>
            <div class="row my-3">
                <div class="col"> 
                    <a href="/event"><img style="position: relative; left:0; width: 250px; height:250px;" src="../img/evenement1.jpg" ></a>
                </div>
                <div class="col"> 
                    <img style="position: relative; left:0; width: 250px; height:250px;" src="#">
                </div>
                <div class="col"> 
                    <img style="position: relative; left:0; width: 250px; height:250px;" src="#">
                </div>
            </div>
        <div class="row my-3">
            <div class="col"> 
                    <img style="position: relative; left:0; width: 250px; height:250px;" src="#" href="#">
                </div>
                <div class="col"> 
                    <img style="position: relative; left:0; width: 250px; height:250px;" src="#">
                </div>
                <div class="col"> 
                    <img style="position: relative; left:0; width: 250px; height:250px;" src="#">
                </div>
            </div>
            <div class="col">
                <nav aria-label="Page navigation example" class="d-flex justify-content-center">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="#">Précédent</a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Suivant</a></li>
                    </ul>
                </nav>
            </div>
        </div>
<?php if ((isConnected()) && (whoIsConnected()[0] == ORGANIZER || whoIsConnected()[0] == ADMIN || whoIsConnected()[0] == SUPADMIN)){?>
        <div class="row my-3">
            <div>
                <a href="/event/create">Créer un événement</a>
            </div>
        </div>
        <?php
        }
require $_SERVER['DOCUMENT_ROOT']."/core/footer.php" ?>
