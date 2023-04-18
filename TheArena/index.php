<?php

$origine = str_replace(dirname($_SERVER['PHP_SELF']), '', $_SERVER['REQUEST_URI']);
/*** ROUTES ***/
$routes = array(
    "/route_ecrite_dans_le_fichier_php" => "localisation/du/fichier",
    "/register/1" => "wiews/register/inscription",
    "/register/2" => "wiews/register/suiteinscription",
    "/register/3" => "wiews/register/fininscription",
    "/admin" => "wiews/admin/indexadmin",
    "/admin/forums" => "wiews/admin/forums",
    "/admin/notifications" => "wiews/admin/notifications",
    "/admin/signalements" => "wiews/admin/signalements",
    "/admin/signalement" => "wiews/admin/signalementpage",
    "/admin/users" => "wiews/admin/users",
    "/events" => "wiews/event/evenements",
    "/event" => "wiews/event/evenement2",
    "/event/shop/create/item" => "wiews/event/createitemform",
    "/event/shop" => "wiews/event/shop",
    "/event/participants" => "wiews/event/participant",
    "/event/tournament/create" => "wiews/event/createtournamentform",
    "/event/create" => "wiews/event/createeventform",
    "/event/register" => "wiews/event/registereventform",
    "/event/dashboard" => "wiews/event/dashboard",
    "/me" => "wiews/user/myuserpage",
    "/user" => "wiews/user/userpage",
    "/me/modify" => "wiews/user/modifyuserpage",
);
/*** Création de l'url de destination ***/
$destination = (array_key_exists($origine, $routes) ? $routes[$origine] : "wiews/index") . '.php';
/*** Appel du bon fichier ***/
require $destination;
