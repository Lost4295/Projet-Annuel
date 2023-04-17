<?php require '../../core/header.php' ?>

<h1>Inscription à <?php echo "\"the evennnt\"" ?></h1>
<div class= "row">
    <div class= "col-7">
        <form action="" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Nom affiché </label>
                <input type="text" class="form-control" id="name" value="<?php echo "pseudo de baase"?>">
                <div class="form-text"> Ce nom sera affiché pendant le(s) tournoi(s).</div>
            </div>
            <h4>Inscription aux événements</h4>
            <div class="mb-3">
                <?php // foreach évent écho la checkbox" ?> 
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">Smash Bros. les potoos</label>
                </div>
                <!-- if invalide bah bam--><div class="invalid">Veuillez choisir au moins 1 événement.</div>
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
                    <label class="form-check-label" for="cgu">J’ai lu les <a href="#">Termes et Conditions</a> de The Arena</label>
                </div>
            </div>
            <div class="mb-3">
<!--EL CAPTCHAA-->

            </div>
            <div class="mb-3">
            <button type="submit" class="btn btn-primary d-block mx-auto btn-lg">Finaliser l'inscription</button>
            </div>
        </form>
    </div>
    <div class="col-5">
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
<?php require '../../core/footer.php' ?>