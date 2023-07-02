<?php

if (
    isset($_POST['name']) && !empty($_POST['name']) &&
    isset($_POST['room']) &&
    (($_POST['room']==1 && isset($_POST['fulladdress']) && !empty($_POST['fulladdress']) &&
    isset($_POST['address']) && !empty($_POST['address']) &&
    isset($_POST['cp']) && !empty($_POST['cp']) &&
    isset($_POST['city']) && !empty($_POST['city']))|| $_POST['room']==0 &&)
) {
echo 'ok';
} else {
    echo 'pas ok';
}
print_r($_POST);