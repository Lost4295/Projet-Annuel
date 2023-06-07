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

function formatStatusUsers($status)
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

function formatType($type)
{
    if ($type==0){
    $return="En ligne";
    } elseif ($type==1){
        $return="En local";
    } else {
        $return=$type." : Format étrange et non connu en base";
    }
    return $return;
}

function findUserById($id)
{
    $db = connectToDB();
    $query = $db->prepare("SELECT username as u FROM ".PREFIX."users WHERE id=:id");
    $query->execute(['id'=>$id]);
    $result = $query->fetch(PDO::FETCH_ASSOC);
    return $result['u'];
}

function formatStatusForums($status)
{
    if ($status==0) {
        $return="Effacé";
        } elseif ($status==1) {
            $return="Actif";
        } else {
            $return=$status." : Format étrange et non connu en base";
        }
        return $return;
}

function formatTypeEvents($type)
{
    if ($type==0) {
        $return="En ligne";
        } elseif ($type==1) {
            $return="En local";
        } else {
            $return=$type." : Format étrange et non connu en base";
        }
        return $return;
}

function formatEventName($namez)
{
    $db = connectToDB();
    $query = $db->prepare("SELECT name as n FROM ".PREFIX."events WHERE id=:id");
    $query->execute(['id'=>$namez]);
    $result = $query->fetch(PDO::FETCH_ASSOC);
    $name = $result['n'];
    if ($name) {
        $return=$name;
    } else {
        $return=$name." : Format étrange et non connu en base";
    }
    return $return;
}