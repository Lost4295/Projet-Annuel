<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/core/functions.php';

if (!isset($_POST['newsletter'])) {
    $_SESSION['newsletter'] = 1;
    $_POST['newsletter'] = 1;
}
if (
    (count($_POST) > 10 || count($_POST) < 7)
    || empty($_POST["pseudo"])
    || empty($_POST["email"])
    || (empty($_POST["pwd"]) && (!empty($_POST["confirmpwd"])))
    || ((!empty($_POST["pwd"])) && empty($_POST["confirmpwd"]))
    || empty($_POST["id"])
    || !isset($_POST["about"])
    || empty($_POST["newsletter"])
    || empty($_POST["visibility"])
) {
    print_r($_POST);
    print_r($_FILES);
    $val = 0;
    foreach ($_POST as $elem) {
        $val += 1;
    }
    echo "<br> Nombre total de values =" . $val . "<br>";
    die("Il ne vous est pas possible de terminer l'action. Merci de réessayer.
         Si cette page se réaffiche apèrs plusieurs essais, merci de vérifier vos informations,
         puis de contacter un administrateur.");
}


$pseudo = $_POST["pseudo"];
$email = strtolower(trim($_POST["email"]));
$pwd = $_POST["pwd"];
$id = $_POST["id"];
$confirmpwd = $_POST["confirmpwd"];
$about = $_POST["about"];
$avatarvals = $_POST["avatarvals"];
$visibility = $_POST["visibility"];
$erroravatar = "";
$errorabout = "";
$errorpseudo = "";
$erroremail = "";
$errorpwd = "";
$errorpwdconfirm = "";
$errorvisibility = "";

$possibleVisibility = [2, 1];

if (!in_array($visibility, $possibleVisibility)) {
    $errorvisibility = "La visibilité n'est pas correcte.";
}

if (strlen($pseudo) < 3) {
    $errorpseudo = "Ce nom d'utilisateur est trop court.";
}
if (strlen($pseudo) > 30) {
    $errorpseudo = "Ce nom d'utilisateur est trop long.";
}

if (strlen($about) > 500) {
    $errorabout = "La description est trop longue.";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erroremail = "L'email est incorrect.";
} else {
    $db = connectToDB();
    $queryPrepared = $db->prepare(" SELECT id FROM " . PREFIX . "users WHERE email=:email");
    $queryPrepared->execute([
        "email" => $email
    ]);
    $result = $queryPrepared->fetch(PDO::FETCH_ASSOC);
    if (($result['id'] != $id)) {
        $erroremail = "Vous n'avez pas renseigné le bon email. Si vous souhaitez changer d'email, merci de contacter un administrateur via la page de contact.";
    }
}
if (!empty($pwd) && !empty($confirmpwd)) {
    if (strlen($pwd) < 8 || !preg_match("#[a-z]#", $pwd) || !preg_match("#[A-Z]#", $pwd) || !preg_match("#[\d]#", $pwd)) {
        $errorpwd = "
        Votre mot de passe doit faire au minimum 8 caractères avec des minuscules,
        des majuscules et des chiffres.";
    }

    if ($pwd != $confirmpwd) {
        $errorpwdconfirm = "Le mot de passe n'est pas bien copié.";
    }
} else {
    $quez = $db->prepare("SELECT password FROM " . PREFIX . "users WHERE id=:id");
    $quez->execute([
        "id" => $id
    ]);
    $result = $quez->fetch(PDO::FETCH_ASSOC);
    $pwd = $result['password'];
}


if ($avatarvals == 'undefined') {
    $dirname = $_SERVER['DOCUMENT_ROOT'] . '\uploads\\users\\';

    $queryPrepared = $db->prepare("SELECT avatar FROM " . PREFIX . "users WHERE id=:id");
    $queryPrepared->execute([
        "id" => $id
    ]);
    $result = $queryPrepared->fetch(PDO::FETCH_ASSOC);
    $baseavatar = $result['avatar'];


    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
        $tmpName = $_FILES['avatar']['tmp_name'];
        $name = $_FILES['avatar']['name'];
        $type = $_FILES['avatar']['type'];
        $avatar = encodeImage($tmpName, $type);

        move_uploaded_file($tmpName, $dirname . $name);
    } elseif (isset($_FILES['avatar']) && $_FILES['avatar']['error'] != 0) {
        $uploadedImage = encodeImage($_SERVER['DOCUMENT_ROOT'] . '\\img\\placeholder_user.png', 'png');
        if ($baseavatar != $uploadedImage) {
            $avatar = $baseavatar;
        } else {
            $avatar = $uploadedImage;
        }
    }
} else {
    $avatarvals = json_decode($avatarvals);




$eyesPositions = [
    ['x' => "0", 'y' => "0"], ['x' => "47", 'y' => "0"], ['x' => "96", 'y' => "0"], ['x' => "143", 'y' => "0"], ['x' => "193", 'y' => "0"], ['x' => "240", 'y' => "0"], ['x' => "287", 'y' => "0"], ['x' => "335", 'y' => "0"],
    ['x' => "384", 'y' => "0"], ['x' => "431", 'y' => "0"], ['x' => "0", 'y' => "48"], ['x' => "48", 'y' => "48"], ['x' => "96", 'y' => "48"], ['x' => "143", 'y' => "48"], ['x' => "193", 'y' => "48"], ['x' => "240", 'y' => "48"],
    ['x' => "287", 'y' => "48"], ['x' => "337", 'y' => "48"], ['x' => "384", 'y' => "48"], ['x' => "431", 'y' => "48"], ['x' => "0", 'y' => "96"], ['x' => "48", 'y' => "96"], ['x' => "96", 'y' => "96"], ['x' => "143", 'y' => "96"],
    ['x' => "193", 'y' => "96"], ['x' => "240", 'y' => "96"], ['x' => "287", 'y' => "96"], ['x' => "337", 'y' => "96"], ['x' => "384", 'y' => "96"], ['x' => "431", 'y' => "96"], ['x' => "0", 'y' => "144"], ['x' => "48", 'y' => "144"],
    ['x' => "96", 'y' => "144"], ['x' => "143", 'y' => "144"], ['x' => "193", 'y' => "144"], ['x' => "240", 'y' => "144"], ['x' => "287", 'y' => "144"], ['x' => "337", 'y' => "144"], ['x' => "384", 'y' => "144"], ['x' => "431", 'y' => "144"],
    ['x' => "0", 'y' => "192"], ['x' => "48", 'y' => "192"], ['x' => "96", 'y' => "192"], ['x' => "143", 'y' => "192"], ['x' => "193", 'y' => "192"], ['x' => "240", 'y' => "192"], ['x' => "287", 'y' => "192"], ['x' => "337", 'y' => "192"],
    ['x' => "384", 'y' => "192"], ['x' => "431", 'y' => "192"], ['x' => "0", 'y' => "240"], ['x' => "48", 'y' => "240"], ['x' => "96", 'y' => "240"], ['x' => "145", 'y' => "240"], ['x' => "193", 'y' => "240"], ['x' => "240", 'y' => "240"],
    ['x' => "287", 'y' => "240"]
];
$colorPositions =  [
    ['x' => "0", 'y' => "0"], ['x' => "47", 'y' => "0"], ['x' => "96", 'y' => "0"], ['x' => "143", 'y' => "0"], ['x' => "193", 'y' => "0"], ['x' => "240", 'y' => "0"], ['x' => "287", 'y' => "0"],
    ['x' => "335", 'y' => "0"], ['x' => "384", 'y' => "0"], ['x' => "431", 'y' => "0"], ['x' => "0", 'y' => "48"], ['x' => "47", 'y' => "48"], ['x' => "96", 'y' => "48"], ['x' => "143", 'y' => "48"],
    ['x' => "193", 'y' => "48"], ['x' => "240", 'y' => "48"], ['x' => "287", 'y' => "48"], ['x' => "335", 'y' => "48"], ['x' => "384", 'y' => "48"], ['x' => "431", 'y' => "48"], ['x' => "0", 'y' => "96"],
    ['x' => "47", 'y' => "96"], ['x' => "96", 'y' => "96"], ['x' => "143", 'y' => "96"],  ['x' => "193", 'y' => "96"], ['x' => "240", 'y' => "96"], ['x' => "0", 'y' => "144"]
];



$mouthPositions = [
    ['x' => "0", 'y' => "0"], ['x' => "47", 'y' => "0"], ['x' => "96", 'y' => "0"], ['x' => "143", 'y' => "0"], ['x' => "193", 'y' => "0"], ['x' => "240", 'y' => "0"], ['x' => "287", 'y' => "0"],
    ['x' => "335", 'y' => "0"], ['x' => "384", 'y' => "0"], ['x' => "431", 'y' => "0"], ['x' => "0", 'y' => "48"], ['x' => "48", 'y' => "48"], ['x' => "96", 'y' => "48"], ['x' => "145", 'y' => "48"], ['x' => "192", 'y' => "48"],
    ['x' => "240", 'y' => "48"], ['x' => "289", 'y' => "49"], ['x' => "336", 'y' => "48"], ['x' => "384", 'y' => "48"], ['x' => "431", 'y' => "48"], ['x' => "0", 'y' => "96"], ['x' => "47", 'y' => "96"], ['x' => "96", 'y' => "96"],
    ['x' => "143", 'y' => "96"], ['x' => "192", 'y' => "96"], ['x' => "240", 'y' => "96"], ['x' => "289", 'y' => "96"], ['x' => "336", 'y' => "96"], ['x' => "384", 'y' => "96"], ['x' => "433", 'y' => "98"], ['x' => "0", 'y' => "144"],
    ['x' => "48", 'y' => "144"], ['x' => "96", 'y' => "144"], ['x' => "144", 'y' => "144"], ['x' => "193", 'y' => "144"], ['x' => "240", 'y' => "144"], ['x' => "289", 'y' => "144"], ['x' => "336", 'y' => "144"], ['x' => "384", 'y' => "144"],
    ['x' => "431", 'y' => "144"], ['x' => "0", 'y' => "192"], ['x' => "48", 'y' => "193"], ['x' => "96", 'y' => "192"], ['x' => "144", 'y' => "192"], ['x' => "192", 'y' => "192"], ['x' => "240", 'y' => "192"], ['x' => "289", 'y' => "192"],
    ['x' => "336", 'y' => "192"], ['x' => "384", 'y' => "192"], ['x' => "431", 'y' => "192"], ['x' => "0", 'y' => "240"]
];



$canvas = imagecreatetruecolor(48, 48);
$icon1 = imagecreatefromgif($_SERVER['DOCUMENT_ROOT'] . '/img/avatar/color_atlas.gif');
$icon2 = imagecreatefromgif($_SERVER['DOCUMENT_ROOT'] . '/img/avatar/eyes_atlas.gif');
$icon3 = imagecreatefromgif($_SERVER['DOCUMENT_ROOT'] . '/img/avatar/mouth_atlas.gif');
if ($avatarvals->owner == true) {
    $icon4 = imagecreatefromgif($_SERVER['DOCUMENT_ROOT'] . '/img/avatar/crown.gif');
}
// ... add more source images as needed
imagecopy($canvas, $icon1, 0, 0, $colorPositions[$avatarvals->color]['x'], $colorPositions[$avatarvals->color]['y'], 48, 48);
imagecopy($canvas, $icon2, 0, 0, $eyesPositions[$avatarvals->eyes]['x'], $eyesPositions[$avatarvals->eyes]['y'], 48, 48);
imagecopy($canvas, $icon3, 0, 0, $mouthPositions[$avatarvals->mouth]['x'], $mouthPositions[$avatarvals->mouth]['y'], 48, 48);
if ($icon4) {
    imagecopy($canvas, $icon4, 0, 0, 6, 8, 48, 48);
}
imagejpeg($canvas, $_SERVER['DOCUMENT_ROOT'] . '/uploads/users/' . $avatarvals->color . $avatarvals->eyes . $avatarvals->mouth . '.jpg', 100);
imagedestroy($canvas);
imagedestroy($icon1);
imagedestroy($icon2);
imagedestroy($icon3);
if ($icon4) {
    imagedestroy($icon4);
}
$avatar = encodeImage($_SERVER['DOCUMENT_ROOT'] . '/uploads/users/' . $avatarvals->color . $avatarvals->eyes . $avatarvals->mouth . '.jpg', 'jpg');
}



if (!empty($erroravatar) || !empty($errorpseudo) || !empty($errorpwd) || !empty($errorpwdconfirm) || !empty($erroremail) || !empty($errorabout) || !empty($errorvisibility)) {
    $error = false;
} else {
    $error = true;
}


if (!$error) {
    $_SESSION['erroravatar'] = $erroravatar;
    $_SESSION['errorpseudo'] = $errorpseudo;
    $_SESSION['erroremail'] = $erroremail;
    $_SESSION['errorpwd'] = $errorpwd;
    $_SESSION['errorabout'] = $errorabout;
    $_SESSION['errorpwdconfirm'] = $errorpwdconfirm;
    $_SESSION['errorvisibility'] = $errorvisibility;
    header("Location: /me/modify");
} else {
    unsetSessionErrors();
    $queryPrepared = $db->prepare("UPDATE " . PREFIX . "users SET avatar=:avatar, username=:username, email=:email, password=:password, about=:about, visibility=:visibility WHERE id=:id");
    $queryPrepared->execute([
        "avatar" => $avatar,
        "username" => $pseudo,
        "email" => $email,
        "password" => $pwd,
        "about" => $about ?? 'toto',
        "visibility" => $visibility,
        "id" => $id
    ]);
    $_SESSION['message'] = "Votre profil a bien été modifié.";
    $_SESSION["message_type"] = "success";
    header("Location:  /me");
}
