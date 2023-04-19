<?php require '../../core/header.php' ?>

<div class="w-100">
    <div class="d-flex justify-content-between flex-wrap align-items-center">
    <h1> Page utilisateur de <?php echo "username";?> </h1> <div><a class="more" href="#">···</a>&emsp;&emsp;&emsp;</div></div> 
    <div class="d-flex justify-content-center my-5"><img src="#" width="150" height="150"/></div>
    <h3>À propos de moi</h3>
    <div class="my-5">
        <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga accusantium dolorem enim quae veritatis
             minima totam. Quam reiciendis rem maiores necessitatibus magni doloremque distinctio autem, fugiat non quod
              unde labore.
        </p>
        <div class="text-center">0 J'aime &emsp;&emsp;12 amis <- nombres pouvant être privés</div>
    </div>
    <div class="d-flex justify-content-around">
        <div class="btn-danger btn"><i class="bi bi-heart-fill"></i> J'aime</div>
        <div class="btn-secondary btn"><i class="bi bi-person-add"></i> Demander en ami</div>
    </div>
</div>

<?php require '../../core/footer.php' ?>