<?php

require 'loginfuncts.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    // sanitize the email & activation code
    $inputs = filter_input_array(INPUT_GET, [
        'email' => FILTER_SANITIZE_EMAIL,
        'activationCode' => htmlspecialchars($_GET['activationCode'])
    ]);

    // if ($inputs['email'] && $inputs['activationCode']) {
    //     $user = findUnverifiedUser($inputs['activationCode'], $inputs['email']);
    //     // if user exists and activate the user successfully
    //     if ($user && activateUser($user['id'])) {
    //         $message='You account has been activated successfully. Please login here.';
    //         $url = APP_URL . '/login';
    //     }
    // }
}

// redirect to the register page in other cases
    $message='Invalid request. Please register here.';
    $url = APP_URL . '/register';
?>

<html>
<head>
    <title>Activate Account</title>
</head>
<body>
<h1>Activate Account</h1>
<p>
    <?php echo $message; ?>
</p>
<?php echo $inputs['email']."<br>"; ?>
<?php echo $inputs['activationCode']; ?>
<a href="<?php echo $url ?>">Bouton </a>
</body>
</html>
