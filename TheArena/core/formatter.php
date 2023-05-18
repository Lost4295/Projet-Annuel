<?php

function formatUsers($user)
{

}

function formatScope($scope)
{
    if ($scope== PLAYER) {
        $return = "Joueur";
    } elseif ($scope == ORGANIZER) {
        $return = "Organisateur";
    } elseif ($scope == ADMIN) {
        $return = "Administrateur";
    } elseif ($scope== SUPADMIN) {
        $return = "Super-Administrateur";
    } else {
        $return = $scope;
    }
    return $return;
}

function formatVisibility($visibility)
{
    if ($visibility == -1) {
        $return = "Supprimé au niveau du site (non visible)";
    } elseif ($visibility == 0) {
        $return = "Non activé";
    } elseif ($visibility == 1) {
        $return = "Actif, et privé";
    } elseif ($visibility == 2) {
        $return = "Actif, et public";
    } else {
        $return = $visibility." : Format étrange et non connu en base";
    }
    return $return;
}

function formatStatus($status)
{
    if ($status == -1) {
        $return = "Supprimé au niveau du site (non visible)";
    } elseif ($status == 0) {
        $return = "Créé mais inactif (non visible)";
    } elseif ($status == 1) {
        $return = "Actif (visible)";
    } else {
        $return = $status ." : Format étrange et non connu en base";
    }
    return $return;
}