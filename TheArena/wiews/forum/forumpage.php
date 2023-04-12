<?php require 'core/header.php' ?>

<h1>Nom du forum du coup</h1>


<?php session_start(); if (isset($_SESSION["forum"])){
foreach ($_SESSION["forum"] as $element){};}
?>
<div class="w-100">
    <ul class="list-group list-group-flush mb-4" >
        <li href="#" class="list-group-item">
            <div class="d-flex w-100 justify-content-between flex-wrap align-items-center">
            <h5 class="mb-1">Ici, on aura l'username de la personne qui envoie le mess</h5>
            <a class="more" href="#">···</a>
            </div>
            <div class="d-flex w-100 justify-content-end">
                <small class="text-body-secondary">Date du dernier mess</small>
            </div>
            <p class="mb-1">Le texte du message Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam, nisi quasi quos facilis quidem sed harum quo libero voluptate, aliquam iure! Quisquam officia doloribus beatae voluptatem eligendi magni quia minima.</p>
        </li>
        <li href="#" class="list-group-item">
            <div class="d-flex w-100 justify-content-between flex-wrap align-items-center">
                <h5 class="mb-1">List group item heading</h5>
                <a class="more" href="#">···</a>
            </div>
            <div class="d-flex w-100 justify-content-end">
                <small>3 days ago</small>
            </div>
            <p class="mb-1">Some placeholder content in a paragraph.</p>
        </li>
        <li href="#" class="list-group-item">
            <div class="d-flex w-100 justify-content-between flex-wrap align-items-center">
                <h5 class="mb-1">List group item heading</h5>
                <a class="more" href="#">···</a>
            </div>
            <div class="d-flex w-100 justify-content-end">
                <small>3 days ago</small>
            </div>
            <p class="mb-1">Some placeholder content in a paragraph.</p>
        </li>
        <li href="#" class="list-group-item">
            <div class="d-flex w-100 justify-content-between flex-wrap align-items-center">
                <h5 class="mb-1">List group item heading</h5>
                <a class="more" href="#">···</a>
            </div>
            <div class="d-flex w-100 justify-content-end">
                <small>3 days ago</small>
            </div>
            <p class="mb-1">Some placeholder content in a paragraph.</p>
        </li>
        <li href="#" class="list-group-item">
            <div class="d-flex w-100 justify-content-between flex-wrap align-items-center">
                <h5 class="mb-1">List group item heading</h5>
                <a class="more" href="#">···</a>
            </div>
            <div class="d-flex w-100 justify-content-end">
                <small>3 days ago</small>
            </div>
            <p class="mb-1">Some placeholder content in a paragraph.</p>
        </li>
        <li href="#" class="list-group-item">
            <div class="d-flex w-100 justify-content-between flex-wrap align-items-center">
                <h5 class="mb-1">List group item heading</h5>
                <a class="more" href="#">···</a>
            </div>
            <div class="d-flex w-100 justify-content-end">
                <small>3 days ago</small>
            </div>
            <p class="mb-1">Some placeholder content in a paragraph.</p>
        </li>
        <li href="#" class="list-group-item">
            <div class="d-flex w-100 justify-content-between flex-wrap align-items-center">
                <h5 class="mb-1">List group item heading</h5>
                <a class="more" href="#">···</a>
            </div>
            <div class="d-flex w-100 justify-content-end">
                <small>3 days ago</small>
            </div>
            <p class="mb-1">Some placeholder content in a paragraph. Lorem ipsum dolor sit amet consectetur adipisicing elit. Provident, amet repellendus? Facilis, ratione? Saepe non architecto soluta sequi, blanditiis atque! Esse eveniet aut asperiores aperiam laborum at quo ex quidem. Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eligendi odit ducimus placeat vel possimus. Unde iusto nobis molestiae modi molestias ex soluta consequatur tempore! Temporibus molestias explicabo facilis aliquam eum! Lorem ipsum dolor sit amet consectetur adipisicing elit. Cupiditate officiis nulla alias quas sunt. Sint commodi eum quaerat adipisci vitae voluptatum repudiandae officiis, fuga repellendus similique id excepturi? Perspiciatis, ullam!</p>
        </li>
        <li href="#" class="list-group-item">
            <div class="d-flex w-100 justify-content-between flex-wrap align-items-center">
                <h5 class="mb-1">List group item heading</h5>
                <a class="more" href="#">···</a>
            </div>
            <div class="d-flex w-100 justify-content-end">
                <small>3 days ago</small>
            </div>
            <p class="mb-1">Some placeholder content in a paragraph.</p>
        </li>
        <li href="#" class="list-group-item">
            <div class="d-flex w-100 justify-content-between flex-wrap align-items-center">
                <h5 class="mb-1">List group item heading</h5>
                <a class="more" href="#">···</a>
            </div>
            <div class="d-flex w-100 justify-content-end">
                <small>3 days ago</small>
            </div>
            <p class="mb-1">Some placeholder content in a paragraph.</p>
        </li>
    </ul>
    <form class="pb-5">
        <textarea type="textarea" id="message" name="message" placeholder="Entrez un message ici.." rows="5" class="form-control mb-5 pb-5"></textarea>
    </form>
</div>
<?php require '/core/footer.php' ?>