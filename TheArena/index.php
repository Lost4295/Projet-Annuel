<?php

$origine = str_replace(dirname($_SERVER['PHP_SELF']), '', $_SERVER['REQUEST_URI']);
/*** ROUTES ***/
$routes = array(
    "/route_ecrite_dans_le_fichier_php" => $_SERVER['DOCUMENT_ROOT']."localisation/du/fichier",
    "" => $_SERVER['DOCUMENT_ROOT']."/wiews/index",
    "register" => $_SERVER['DOCUMENT_ROOT']."/wiews/register/inscription",
    "register_2" => $_SERVER['DOCUMENT_ROOT']."/wiews/register/suiteinscription",
    "register_3" => $_SERVER['DOCUMENT_ROOT']."/wiews/register/fininscription",
    "login" => $_SERVER['DOCUMENT_ROOT']."/wiews/register/login",
    "login_help" => $_SERVER['DOCUMENT_ROOT']."/wiews/register/problèmeconnexion",
    "logout" => $_SERVER['DOCUMENT_ROOT']."/wiews/register/logout",
    "admin" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/adminindex",
    "admin_forums" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/forums",
    "admin_notifications" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/notifications",
    "admin_events" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/events",
    "admin_signalements" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/signalements",
    "admin_settings" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/settings",
    "admin_signalement" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/signalementpage",
    "admin_users" => $_SERVER['DOCUMENT_ROOT']."/wiews/admin/users",
    "events" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/evenements",
    "powerranking" => $_SERVER['DOCUMENT_ROOT']."/wiews/powerranking/powerRankingIndex",
    "event" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/evenement2",
    "event_shop_create_item" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/createitemform",
    "event_shop" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/shop",
    "event_participants" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/participant",
    "event_tournament_create" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/createtournamentform",
    "event_create" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/createeventform",
    "event_register" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/registereventform",
    "event_dashboard" => $_SERVER['DOCUMENT_ROOT']."/wiews/events/dashboard",
    "me" => $_SERVER['DOCUMENT_ROOT']."/wiews/user/myuserpage",
    "forums" => $_SERVER['DOCUMENT_ROOT']."/wiews/forum/forumindex",
    "user" => $_SERVER['DOCUMENT_ROOT']."/wiews/user/userpage",
    "me_modify" => $_SERVER['DOCUMENT_ROOT']."/wiews/user/modifyuserpage",
    "cgu" => $_SERVER['DOCUMENT_ROOT']."/wiews/important/cgu",
    "cgv" => $_SERVER['DOCUMENT_ROOT']."/wiews/important/cgv",
    "contact" => $_SERVER['DOCUMENT_ROOT']."/wiews/important/contact",
    "legal" => $_SERVER['DOCUMENT_ROOT']."/wiews/important/mentionslégales",
    "forum" => $_SERVER['DOCUMENT_ROOT']."/wiews/forum/forumpage",
    "forum_create" => $_SERVER['DOCUMENT_ROOT']."/wiews/forum/createblogform",
);
/*** Création de l'url de destination ***/
$destination = (array_key_exists($origine, $routes) ? $routes[$origine] : "wiews/important/errorpage") . '.php';
/*** Appel du bon fichier ***/
require $destination;
