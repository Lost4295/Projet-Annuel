<?php

session_start();

$dataValues = json_decode($_POST['dataValues']);
$responses = $_SESSION['response'];

$rela = true;

foreach ($responses as $key => $response) {
    if ($response != $dataValues[$key]) {
        $rela = false;
        break;
    }
}

$response = array('success' => $rela, 'values' => $dataValues, 'responses' => 'haha, you thought they were here ? nope ;)');
header('Content-Type: application/json');
echo json_encode($response);
