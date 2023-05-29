<?php

session_start();

$dataValues = json_decode($_POST['dataValues']);
$responsejson = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/core/captcha.json');
$responsedata = json_decode($responsejson);


$rela = true;

foreach ($responsedata as $key => $response) {
    if ($response != $dataValues[$key]) {
        $rela = false;
        break;
    }
}

$response = array('success' => $rela, 'values' => $dataValues, 'responses' => 'haha, you thought they were here ? nope ;)');
header('Content-Type: application/json');
echo json_encode($response);
