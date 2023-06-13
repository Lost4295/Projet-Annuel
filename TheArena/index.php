<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$origine = str_replace(dirname($_SERVER['PHP_SELF']), '', $_SERVER['REQUEST_URI']);
/*** ROUTES ***/
$routes = [
    "/route_ecrite_dans_le_fichier_php" => $_SERVER['DOCUMENT_ROOT']."localisation/du/fichier",
    "" => $_SERVER['DOCUMENT_ROOT']."/wiews/index",
    "search" => $_SERVER['DOCUMENT_ROOT']."/core/search",
    "404" => $_SERVER['DOCUMENT_ROOT']."/wiews/important/errorpage",
    "resetPassword" => $_SERVER['DOCUMENT_ROOT']."/core/resetPassword",
    "hiddengame" => $_SERVER['DOCUMENT_ROOT']."/wiews/important/hiddengame",
    "authentification" => $_SERVER['DOCUMENT_ROOT']."/core/auth",
    "reactivation" => $_SERVER['DOCUMENT_ROOT']."/core/auth",
    "noNewsletter" => $_SERVER['DOCUMENT_ROOT']."/core/noNewsletter",
    "register" => $_SERVER['DOCUMENT_ROOT']."/wiews/register/inscription",
    "login" => $_SERVER['DOCUMENT_ROOT']."/wiews/register/login",
    "login_help" => $_SERVER['DOCUMENT_ROOT']."/wiews/register/problèmeconnexion",
    "logout" => $_SERVER['DOCUMENT_ROOT']."/wiews/register/logout",
    "admin" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/adminindex",
    "admin_forums" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/forums/forums",
    "admin_forum_create" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/forums/create",
    "admin_forum_status" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/forums/status",
    "admin_forum_update" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/forums/update",
    "admin_forum_delete" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/forums/delete",
    "admin_forum_read" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/forums/read",
    "admin_notifications" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/notifications",
    "admin_events" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/events/events",
    "admin_events_read" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/events/read",
    "admin_events_update" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/events/update",
    "admin_users_changes"=> $_SERVER['DOCUMENT_ROOT']."/wiews/admin/users/changes",
    "admin_events_delete" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/events/delete",
    "admin_events_create" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/events/create",
    "admin_signalements" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/signalements",
    "admin_shops" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/events/shops/shops",
    "admin_shop_read" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/events/shops/read",
    "admin_shops_read" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/events/shops/read",
    "admin_shops_edit" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/events/shops/update",
    "admin_items_create" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/events/shops/itcreate",
    "admin_items_edit" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/events/shops/itedit",
    "admin_items_delete" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/events/shops/itdelete",
    "admin_settings" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/settings",
    "admin_signalement" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/signalementpage",
    "admin_users" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/users/users",
    "admin_users_read" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/users/read",
    "admin_users_delete" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/users/delete",
    "admin_users_removeUser" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/users/removeUser",
    "admin_users_update" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/users/update",
    "admin_users_create" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/users/create",
    "admin_tournaments" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/events/tournaments/tournaments",
    "admin_tournament_read" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/events/tournaments/read",
    "admin_tournament_delete" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/events/tournaments/delete",
    "admin_tournament_update" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/events/tournaments/update",
    "admin_tournament_create" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/events/tournaments/create",
    "events" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/evenements",
    "powerranking" => $_SERVER['DOCUMENT_ROOT']."/wiews/powerranking/powerRankingIndex",
    "event" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/event",
    "item" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/item",
    "event_shop_create_item" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/createitemform",
    "event_shop" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/shop",
    "event_participants" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/participant",
    "event_tournament_create" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/createtournamentform",
    "event_create" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/createeventform",
    "event_management" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/gestionevent",
    "event_register" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/registereventform",
    "event_unregister" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/unregistereventform",
    "event_dashboard" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/dashboard",
    "me" => $_SERVER['DOCUMENT_ROOT']."/wiews/user/myuserpage",
    "forums" => $_SERVER['DOCUMENT_ROOT']."/wiews/forum/forumindex",
    "user" => $_SERVER['DOCUMENT_ROOT']."/wiews/user/userpage",
    "me_modify" => $_SERVER['DOCUMENT_ROOT']."/wiews/user/modifyuserpage",
    "cgu" => $_SERVER['DOCUMENT_ROOT']."/wiews/important/cgu",
    "cgv" => $_SERVER['DOCUMENT_ROOT']."/wiews/important/cgv",
    "checkCaptcha" => $_SERVER['DOCUMENT_ROOT']."/core/checkCaptcha",
    "contact" => $_SERVER['DOCUMENT_ROOT']."/wiews/important/contact",
    "legal" => $_SERVER['DOCUMENT_ROOT']."/wiews/important/mentionslégales",
    "forum" => $_SERVER['DOCUMENT_ROOT']."/wiews/forum/forumpage",
    "forum_create" => $_SERVER['DOCUMENT_ROOT']."/wiews/forum/createblogform",
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
