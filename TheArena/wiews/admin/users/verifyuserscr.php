<?php
    session_start();
    require($_SERVER['DOCUMENT_ROOT'].'/core/functions.php');
    if (isset($_POST)) {
        if (!isset($_POST['newsletter'])) {
            $_POST['newsletter']=0;
        }
        if (
            count($_POST)!=14
            ||!isset($_POST["type"])
            ||empty($_POST["username"])
            ||empty($_POST["email"])
            ||empty($_POST["pwd"])
            ||empty($_POST["confirmpwd"])
            ||empty($_POST["firstname"])
            ||empty($_POST["lastname"])
            ||empty($_POST["birthdate"])
            ||empty($_POST["phonenumber"])
            ||empty($_POST["address"])
            ||empty($_POST["cp"])
            ||empty($_POST["fulladdress"])
            ||empty($_POST["city"])
            ||!isset($_POST["newsletter"])
        ) { print_r($_POST);
            $val=0;
            foreach ($_POST as $elem){
                $val+=1;
            }
            echo "<br> Nombre total de values =".$val."<br>";
            die(
                "Il ne vous est pas possible de terminer l'action. Merci de réessayer.
                 Si cette page se réaffiche apèrs plusieurs essais, merci de vérifier vos informations,
                 puis de contacter un administrateur.");
        }





        $firstname= ucwords(strtoupper(trim($_POST["firstname"])));
        $lastname= strtoupper(trim($_POST["lastname"]));
        $birthdate=$_POST["birthdate"];
        $phonenumber=$_POST["phonenumber"];
        $address=$_POST["address"];
        $cp=$_POST["cp"];
        $city=$_POST["city"];
        $fulladdress=$_POST["fulladdress"];
        $type=$_POST["type"];
        $username=$_POST["username"];
        $email=strtolower(trim($_POST["email"]));
        $pwd=$_POST["pwd"];
        $confirmpwd=$_POST["confirmpwd"];
        $newsletterNotProcessed = $_POST["newsletter"];
        
        
        $errornewsletter="";
        $errorcaptcha="";
        $errortype="";
        $errorusername="";
        $erroremail="";
        $errorpwd="";
        $errorpwdconfirm="";
        $errorfirstname="";
        $errorlastname="";
        $errorbirthdate="";
        $errorphonenumber="";
        $erroraddress="";
        $errorcp="";
        $errorcity="";
        $errorfulladdress="";


        $types=[0,1,2,3];

        if (!in_array($type, $types)) {
            $errortype="Ce rôle n'existe pas.";
        } else {
            switch ($type) {
                case 0:
                    $typefinal['scope']=PLAYER;//joueur
                    $typefinal['nom']="Joueur";
                    break;
                case 2:
                    $typefinal['scope']=ADMIN;//joueur
                    $typefinal['nom']="Administrateur";
                    break;
                case 3:
                    $typefinal['scope']=SUPADMIN;//joueur
                    $typefinal['nom']="Super-Administrateur";
                    break;
                case 1:
                default:
                    $typefinal['nom']="Organisateur";
                    $typefinal['scope']=ORGANIZER;// orga
                    break;
            }
        }

        if (strlen($username)<3) {
            $errorusername="Ce nom d'utilisateur est trop court.";
        }
        if (strlen($username)>30) {
            $errorusername="Ce nom d'utilisateur est trop long.";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erroremail = "L'email est incorrect.";
        } else {
            $db=connectToDB();
            $queryPrepared = $db->prepare(" SELECT id FROM ".PREFIX."users WHERE email=:email");
            $queryPrepared->execute([
                "email"=>$email
            ]);
            $result=$queryPrepared->fetch();
            if ((!empty($result))&&(count($result)<2)) {
                $erroremail="L'email est déjà utilisé.";
            }
        }

        if (strlen($pwd)< 8 || !preg_match("#[a-z]#", $pwd)|| !preg_match("#[A-Z]#", $pwd) || !preg_match("#[\d]#", $pwd)) {
            $errorpwd="
                Votre mot de passe doit faire au minimum 8 caractères avec des minuscules,
                des majuscules et des chiffres.";
        }

        if ($pwd != $confirmpwd) {
            $errorpwdconfirm="Le mot de passe n'est pas bien copié.";
        }


        if (strlen($lastname)<2) {
            $errorlastname= "Le nom doit faire plus de 2 caractères.";
        }

        if (strlen($firstname)<2) {
            $errorfirstname= "Le prénom doit faire plus de 2 caractères.";
        }

        $birthdateExploded=explode("-", $birthdate);
        if (!checkdate($birthdateExploded[1], $birthdateExploded[2], $birthdateExploded[0])) {
        $errorbirthdate= "Format de date incorrect";
        } else {
            $todaySeconds= time();
            $birthdateSeconds = strtotime($birthdate);
            $ageSeconds= $todaySeconds - $birthdateSeconds;
            $age = $ageSeconds/60/60/24/365.25;
            if ($age < 16 || $age > 80) {
                $errorbirthdate = "Vous n'avez pas l'âge requis.";
            }
        }

        if (!preg_match("/^0[1-9](?:[ .-]?[\d]{2}){4}$/", $phonenumber)) {
            $errorphonenumber="Le numéro est invalide.";
        } else {
            $db = connectToDB();
            $queryPrepared = $db->prepare(" SELECT id FROM ".PREFIX."users WHERE phone=:phone");
            $queryPrepared->execute([
                "phone"=>$phonenumber
            ]);
            $result=$queryPrepared->fetch();
            if ((!empty($result))&&(count($result)<2)) {
                $errorphonenumber="Le numéro de téléphone est déjà utilisé.";
            }
        }

        if (strlen($address) > 200) {
            $erroraddress = '200 carctères maximum.';
        } elseif (strlen($address) < 5) {
            $erroraddress = 'Il faut au moins 5 carctères.';
        } elseif (!preg_match("/^[A-z0-9' -]+$/", $address)) {
            $erroraddress = 'Carctères invalides. Caractères autorisés : A-z, 0-9, espace, \' et -';
        }
    
        $fulladdressExploded=explode(",", $fulladdress);
        if (count($fulladdressExploded) != 3) {
            $errorfulladdress= "L'adresse est invalide.";
        } else {
            if (trim($address) != trim($fulladdressExploded[0])){
                $erroraddress= "L'adresse est invalide.";
            }
            if (trim($cp) != trim($fulladdressExploded[1])){
                $errorcp= "Le code postal est invalide.";
            } else {
                $depart = substr($cp, 0, 2);
            }
            if (trim($city) != trim($fulladdressExploded[2])){
                $errorcity= "La ville est invalide.";
            }
        }
        if ($newsletterNotProcessed== 1) {
            $newsletter=1;
        } elseif ($newsletterNotProcessed == 0) {
            $newsletter = 0;
        } else {
            $errornewsletter = "Format de données invalide.";
        }




        if (
            !empty($errorfirstname)
            ||!empty($errorlastname)
            ||!empty($errorbirthdate)
            ||!empty($errorphonenumber)
            ||!empty($erroremail)
            ||!empty($errorfulladdress)
            ||!empty($errorcity)
            ||!empty($errorcp)
            ||!empty($erroraddress)
            ||!empty($errortype)
            ||!empty($errorusername)
            ||!empty($errorpwd)
            ||!empty($errorpwdconfirm)
            ||!empty($erroremail)
            ||!empty($errornewsletter)
            ) {
            $error=true;
        } else {
            $error=false;
        }

        if ($error) {
            $_SESSION['errorfirstname']= $errorfirstname;
            $_SESSION['errorlastname']= $errorlastname;
            $_SESSION['errorbirthdate']= $errorbirthdate;
            $_SESSION['errorphonenumber']= $errorphonenumber;
            $_SESSION['erroraddress']= $erroraddress;
            $_SESSION['errorcp']= $errorcp;
            $_SESSION['errorcity']= $errorcity;
            $_SESSION['errorfulladdress']= $errorfulladdress;
            $_SESSION['errortype']= $errortype;
            $_SESSION['errorusername']= $errorusername;
            $_SESSION['erroremail']= $erroremail;
            $_SESSION['errorpwd']= $errorpwd;
            $_SESSION['errorpwdconfirm']= $errorpwdconfirm;
            $_SESSION['errornewsletter']= $errornewsletter;
            header("Location: /admin/users/create");
        } else {
            $pwd=password_hash($pwd, PASSWORD_DEFAULT);
            $query=$db->prepare("INSERT INTO ".PREFIX."users (scope,username,email,password,first_name,last_name,birthdate,phone,address,newsletter,activation_timeout,activation_code, department)
            VALUES (:scope,:username,:email,:password,
            :first_name,:last_name,:birthdate,:phone,
            :address,:newsletter
            ,:activation_timeout,:activation_code,:department)");
            $query->execute([
                "scope" =>$typefinal["scope"],
                "username"=>$username,
                "email"=>$email,
                "password"=>$pwd,
                "first_name"=>$firstname,
                "last_name"=>$lastname,
                "birthdate"=>$birthdate,
                "phone"=>$phonenumber,
                "address" => $address . ", ".$cp. " " . $city,
                "department" => $depart,
                "newsletter"=>$newsletter,
                "activation_timeout"=> date("Y-m-d H:i:s", strtotime("+1 day")),
                "activation_code"=>password_hash(generateActivationCode(), PASSWORD_DEFAULT),
            ]);
            header("Location:/admin/users");
        }
        print_r($_SESSION);

    } else {
        die('Pas de post.');
    }
