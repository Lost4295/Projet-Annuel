<?php

$origine = str_replace(dirname($_SERVER['PHP_SELF']), '', $_SERVER['REQUEST_URI']);
/*** ROUTES ***/
$routes = array(
    "/route_ecrite_dans_le_fichier_php" => $_SERVER['DOCUMENT_ROOT']."localisation/du/fichier",
    "/register/1" => $_SERVER['DOCUMENT_ROOT']."/wiews/register/inscription",
    "/register/2" => $_SERVER['DOCUMENT_ROOT']."/wiews/register/suiteinscription",
    "/register/3" => $_SERVER['DOCUMENT_ROOT']."/wiews/register/fininscription",
    "/login" => $_SERVER['DOCUMENT_ROOT']."/wiews/register/login",
    "/admin" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/indexadmin",
    "/admin/forums" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/forums",
    "/admin/notifications" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/notifications",
    "/admin/signalements" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/signalements",
    "/admin/signalement" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/signalementpage",
    "/admin/users" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/users",
    "/events" => $_SERVER['DOCUMENT_ROOT']."/wiews/event/evenements",
    "/event" => $_SERVER['DOCUMENT_ROOT']."/wiews/event/evenement2",
    "/event/shop/create/item" => $_SERVER['DOCUMENT_ROOT']."/wiews/event/createitemform",
    "/event/shop" => $_SERVER['DOCUMENT_ROOT']."/wiews/event/shop",
    "/event/participants" => $_SERVER['DOCUMENT_ROOT']."/wiews/event/participant",
    "/event/tournament/create" => $_SERVER['DOCUMENT_ROOT']."/wiews/event/createtournamentform",
    "/event/create" => $_SERVER['DOCUMENT_ROOT']."/wiews/event/createeventform",
    "/event/register" => $_SERVER['DOCUMENT_ROOT']."/wiews/event/registereventform",
    "/event/dashboard" => $_SERVER['DOCUMENT_ROOT']."/wiews/event/dashboard",
    "/me" => $_SERVER['DOCUMENT_ROOT']."/wiews/user/myuserpage",
    "/user" => $_SERVER['DOCUMENT_ROOT']."/wiews/user/userpage",
    "/me/modify" => $_SERVER['DOCUMENT_ROOT']."/wiews/user/modifyuserpage",
);
/*** Création de l'url de destination ***/
$destination = (array_key_exists($origine, $routes) ? $routes[$origine] : "wiews/index") . '.php';
/*** Appel du bon fichier ***/
require $destination;
