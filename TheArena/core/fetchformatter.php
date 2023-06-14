<?php

include $_SERVER['DOCUMENT_ROOT'] . "/core/formatter.php";


switch ($_POST['action']) {
    case 'formatUsers':
        $result = formatUsers($_POST['data']);
        echo $result;
        break;
    case 'formatScope':
        $result = formatScope($_POST['data']);
        echo $result;
        break;
    case 'formatVisibility':
        $result = formatVisibility($_POST['data']);
        echo $result;
        break;
    case 'formatStatusUsers':
        $result = formatStatusUsers($_POST['data']);
        echo $result;
        break;
    case 'formatType':
        $result = formatType($_POST['data']);
        echo $result;
        break;
    case 'formatUsers':
        $result = formatUsers($_POST['data']);
        echo $result;
        break;
    case 'formatStatusForums':
        $result = formatStatusForums($_POST['data']);
        echo $result;
        break;
    case 'formatTypeEvents':
        $result = formatTypeEvents($_POST['data']);
        echo $result;
        break;
    case 'formatEventName':
        $result = formatEventName($_POST['data']);
        echo $result;
        break;
    case 'formatTypePriceEvents':
        $result = formatTypePriceEvents($_POST['data']);
        echo $result;
        break;
    case 'formatTypeItems':
        $result = formatTypeItems($_POST['data']);
        echo $result;
        break;
    case 'formatStateTournaments':
        $result = formatStateTournaments($_POST['data']);
        echo $result;
        break;
}













