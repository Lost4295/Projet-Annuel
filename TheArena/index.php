<?php

$origine = str_replace(dirname($_SERVER['PHP_SELF']), '', $_SERVER['REQUEST_URI']);
/*** ROUTES ***/
$routes = array(
    "/route_ecrite_dans_le_fichier_php" => "localisation/du/fichier",
    "/register" => "wiews/register/inscription",
);
/*** Création de l'url de destination ***/
$destination = (array_key_exists($origine, $routes) ? $routes[$origine] : "wiews/index") . '.php';
/*** Appel du bon fichier ***/
require $destination;

