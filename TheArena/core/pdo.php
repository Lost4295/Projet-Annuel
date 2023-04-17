<?php
function connectToDB():PDO
{
    try {
        $db = new PDO('54.36.180.242;dbname=pj_annuel;charset=utf8', 'websit', 'ConnardLV1');
    }
    catch (Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    }
    return $db;
}
