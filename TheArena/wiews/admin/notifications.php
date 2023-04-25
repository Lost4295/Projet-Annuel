<?php require 'header.php' ?>
<?php 
    session_start();
    require 'functions.php';
?>
<?php 
    require 'constantes.php';
    isAdmin();
?>
<h1>Notifications</h1>
<table class="table table-hover table-borderless">
<div class="list-group">
    <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
        <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1">Nom de la notif</h5>
            <small>Date par rapport à maintenant</small>
        </div>
        <p class="mb-1">Info sur la notif</p>
    </a>
    <!-- <a href="#" class="list-group-item list-group-item-action">
        <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1">List group item heading</h5>
            <small class="text-body-secondary">3 days ago</small>          si besoin de faire un foreach c'est là
        </div>
        <p class="mb-1">Some placeholder content in a paragraph.</p>
        <small class="text-body-secondary">And some muted small print.</small>
    </a> -->
</div>
<?php include 'footer.php'?>
