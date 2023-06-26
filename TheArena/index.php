<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$origine = str_replace(dirname($_SERVER['PHP_SELF']), '', $_SERVER['REQUEST_URI']);
/*** ROUTES ***/
$routes = [
    "/route_ecrite_dans_le_fichier_php" => $_SERVER['DOCUMENT_ROOT']."localisation/du/fichier",
    "/" => $_SERVER['DOCUMENT_ROOT']."/wiews/index",
    "/search" => $_SERVER['DOCUMENT_ROOT']."/core/search",
    "/relaunch" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/relaunch",
    "/404" => $_SERVER['DOCUMENT_ROOT']."/wiews/important/errorpage",
    "/resetPassword" => $_SERVER['DOCUMENT_ROOT']."/core/resetPassword",
    "/hiddengame" => $_SERVER['DOCUMENT_ROOT']."/wiews/important/hiddengame",
    "/chat" => $_SERVER['DOCUMENT_ROOT']."/wiews/chat/index",
    "/chat/chat" => $_SERVER['DOCUMENT_ROOT']."/wiews/chat/chat",
    "/authentification" => $_SERVER['DOCUMENT_ROOT']."/core/auth",
    "/reactivation" => $_SERVER['DOCUMENT_ROOT']."/core/auth",
    "/noNewsletter" => $_SERVER['DOCUMENT_ROOT']."/core/noNewsletter",
    "/register" => $_SERVER['DOCUMENT_ROOT']."/wiews/register/inscription",
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
    "/admin/shops" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/events/shops/shops",
    "/admin/shop/read" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/events/shops/read",
    "/admin/shops/read" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/events/shops/read",
    "/admin/shops/edit" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/events/shops/update",
    "/admin/items/create" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/events/shops/itcreate",
    "/admin/items/edit" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/events/shops/itedit",
    "/admin/items/delete" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/events/shops/itdelete",
    "/admin/settings" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/settings",
    "/admin/signalement" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/signalementpage",
    "/admin/users" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/users/users",
    "/admin/users/read" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/users/read",
    "/admin/users/delete" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/users/delete",
    "/admin/users/removeUser" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/users/removeUser",
    "/admin/users/update" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/users/update",
    "/admin/users/create" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/users/create",
    "/admin/tournaments" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/events/tournaments/tournaments",
    "/admin/tournament/read" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/events/tournaments/read",
    "/admin/tournament/delete" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/events/tournaments/delete",
    "/admin/tournament/update" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/events/tournaments/update",
    "/admin/tournament/create" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/events/tournaments/create",
    "/events" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/evenements",
    "/powerranking" => $_SERVER['DOCUMENT_ROOT']."/wiews/powerranking/powerRankingIndex",
    "/event" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/event",
    "/item" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/item",
    "/event/shop/create/item" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/createitemform",
    "/event/shop" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/shop",
    "/event/participants" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/participant",
    "/event/tournament/create" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/createtournamentform",
    "/event/room/create" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/createroomform",
    "/event/create" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/createeventform",
    "/event/management" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/gestionevent",
    "/event/register" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/registereventform",
    "/event/unregister" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/unregistereventform",
    "/event/dashboard" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/dashboard",
    "/me" => $_SERVER['DOCUMENT_ROOT']."/wiews/user/myuserpage",
    "/forums" => $_SERVER['DOCUMENT_ROOT']."/wiews/forum/forumindex",
    "/user" => $_SERVER['DOCUMENT_ROOT']."/wiews/user/userpage",
    "/user/interact/friend" => $_SERVER['DOCUMENT_ROOT']."/wiews/user/interact/friend",
    "/user/interact/like" => $_SERVER['DOCUMENT_ROOT']."/wiews/user/interact/like",
    "/me/modify" => $_SERVER['DOCUMENT_ROOT']."/wiews/user/modifyuserpage",
    "/cgu" => $_SERVER['DOCUMENT_ROOT']."/wiews/important/cgu",
    "/cgv" => $_SERVER['DOCUMENT_ROOT']."/wiews/important/cgv",
    "/checkCaptcha" => $_SERVER['DOCUMENT_ROOT']."/core/checkCaptcha",
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
