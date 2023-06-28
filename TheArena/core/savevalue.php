<?php
session_start();
$data = json_decode($_POST['data']);


$_SESSION['link1']['title'] = $data->link1->title;
$_SESSION['link1']['url'] = $data->link1->url;
$_SESSION['link2']['title'] = $data->link2->title;
$_SESSION['link2']['url'] = $data->link2->url;
$_SESSION['link3']['title'] = $data->link3->title;
$_SESSION['link3']['url'] = $data->link3->url;

echo json_encode(true);
