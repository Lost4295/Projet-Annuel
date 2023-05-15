<?php


$origine = str_replace(dirname($_SERVER['PHP_SELF']), '', $_SERVER['REQUEST_URI']);
/*** ROUTES ***/
$routes = array(
    "/route_ecrite_dans_le_fichier_php" => $_SERVER['DOCUMENT_ROOT']."localisation/du/fichier",
    "/" => $_SERVER['DOCUMENT_ROOT']."/wiews/index",
    "/register/1" => $_SERVER['DOCUMENT_ROOT']."/wiews/register/inscription",
    "/register/2" => $_SERVER['DOCUMENT_ROOT']."/wiews/register/suiteinscription",
    "/register/3" => $_SERVER['DOCUMENT_ROOT']."/wiews/register/fininscription",
    "/login" => $_SERVER['DOCUMENT_ROOT']."/wiews/register/login",
    "/login/help" => $_SERVER['DOCUMENT_ROOT']."/wiews/register/problèmeconnexion",
    "/logout" => $_SERVER['DOCUMENT_ROOT']."/wiews/register/logout",
    "/admin" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/adminindex",
    "/admin/forums" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/forums/forums",
    "/admin/notifications" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/notifications",
    "/admin/events" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/events/events",
    "/admin/signalements" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/signalements",
    "/admin/settings" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/settings",
    "/admin/signalement" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/signalementpage",
    "/admin/users" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/users/users",
    "/events" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/evenements",
    "/powerranking" => $_SERVER['DOCUMENT_ROOT']."/wiews/powerranking/powerRankingIndex",
    "/event" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/evenement2",
    "/event/shop/create/item" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/createitemform",
    "/event/shop" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/shop",
    "/event/participants" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/participant",
    "/event/tournament/create" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/createtournamentform",
    "/event/create" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/createeventform",
    "/event/register" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/registereventform",
    "/event/dashboard" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/dashboard",
    "/me" => $_SERVER['DOCUMENT_ROOT']."/wiews/user/myuserpage",
    "/forums" => $_SERVER['DOCUMENT_ROOT']."/wiews/forum/forumindex",
    "/user" => $_SERVER['DOCUMENT_ROOT']."/wiews/user/userpage",
    "/me/modify" => $_SERVER['DOCUMENT_ROOT']."/wiews/user/modifyuserpage",
    "/cgu" => $_SERVER['DOCUMENT_ROOT']."/wiews/important/cgu",
    "/cgv" => $_SERVER['DOCUMENT_ROOT']."/wiews/important/cgv",
    "/contact" => $_SERVER['DOCUMENT_ROOT']."/wiews/important/contact",
    "/legal" => $_SERVER['DOCUMENT_ROOT']."/wiews/important/mentionslégales",
    "/forum" => $_SERVER['DOCUMENT_ROOT']."/wiews/forum/forumpage",
);
/*** Création de l'url de destination ***/
$urls = explode('?', $origine);
if (count($urls) > 1) {
    $origine = $urls[0];
    $args= $urls[1];
}
$destination = (array_key_exists($origine, $routes) ? $routes[$origine] : "wiews/important/errorpage") . '.php';
/*** Appel du bon fichier ***/
require $destination;
