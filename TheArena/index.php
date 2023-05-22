<?php


$origine = str_replace(dirname($_SERVER['PHP_SELF']), '', $_SERVER['REQUEST_URI']);
/*** ROUTES ***/
$routes = [
    "/route_ecrite_dans_le_fichier_php" => $_SERVER['DOCUMENT_ROOT']."localisation/du/fichier",
    "/" => $_SERVER['DOCUMENT_ROOT']."/wiews/index",
    "/authentification" => $_SERVER['DOCUMENT_ROOT']."/core/auth",
    "/register/1" => $_SERVER['DOCUMENT_ROOT']."/wiews/register/inscription",
    "/register/2" => $_SERVER['DOCUMENT_ROOT']."/wiews/register/suiteinscription",
    "/register/3" => $_SERVER['DOCUMENT_ROOT']."/wiews/register/fininscription",
    "/login" => $_SERVER['DOCUMENT_ROOT']."/wiews/register/login",
    "/login/help" => $_SERVER['DOCUMENT_ROOT']."/wiews/register/problèmeconnexion",
    "/logout" => $_SERVER['DOCUMENT_ROOT']."/wiews/register/logout",
    "/admin" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/adminindex",
    "/admin/forums" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/forums/forums",
    "/admin/forum/create" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/forums/create",
    "/admin/forum/status" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/forums/status",
    "/admin/forum/update" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/forums/update",
    "/admin/forum/delete" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/forums/delete",
    "/admin/forum/read" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/forums/read",
    "/admin/notifications" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/notifications",
    "/admin/events" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/events/events",
    "/admin/events/read" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/events/read",
    "/admin/events/update" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/events/update",
    "/admin/users/changes"=> $_SERVER['DOCUMENT_ROOT']."/wiews/admin/users/changes",
    "/admin/events/delete" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/events/delete",
    "/admin/events/create" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/events/create",
    "/admin/signalements" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/signalements",
    "/admin/shops" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/events/shops",
    "/admin/settings" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/settings",
    "/admin/signalement" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/signalementpage",
    "/admin/users" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/users/users",
    "/admin/users/read" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/users/read",
    "/admin/users/delete" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/users/delete",
    "/admin/users/update" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/users/update",
    "/admin/users/create" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/users/create",
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
    "/forum/create" => $_SERVER['DOCUMENT_ROOT']."/wiews/forum/createblogform",
];
/*** Création de l'url de destination ***/
$urls = explode('?', $origine);
if (count($urls) > 1) {
    $origine = $urls[0];
    $args= $urls[1];
}
$destination = (array_key_exists($origine, $routes) ? $routes[$origine] : "wiews/important/errorpage") . '.php';
/*** Appel du bon fichier ***/
require $destination;
