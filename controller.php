<?php
session_start();
require "db.php";
$con = $conn;
$errors = array();
if ($_SERVER['PHP_SELF'] == "/jmpl/controller.php"){
    if ($_SERVER['REQUEST_METHOD'] != "POST") {
        header("location: index.php");
        die();
    }
}

if(isset($_POST["signup"])){
    $username = $_POST["username"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    if (empty($username) || empty($password) || empty($cpassword)){
        $errors["field"] = "Please fill all fields";
    }
    if(isusernameExists($username)){
        $errors["username"] = "username already registered";
    }
    if ($password != $cpassword){
        $errors["password"] = "Confirm password not matched";
    }
    if(count($errors) === 0){
        $insert_query = "INSERT INTO users (username, password)
        values('$username', '$password')";
        $run = mysqli_query($conn, $insert_query);
        $_SESSION["username_verification"] = $username;
        header('location: index.php');
        exit();
    }
}

if (isset($_POST["login"])){
    $username = $_POST["username"];
    $password = $_POST["password"];
    if (empty($username) || empty($password)){
        $errors["field"] = "Please fill all fields";
    }
    # Ini adalah query yang buruk, memungkinkan sql injection
    $username_check = "SELECT * FROM users WHERE username = '".$username."' and password = '".$password."'";
    $result = mysqli_query($conn, $username_check);
    $count = mysqli_num_rows($result);
    if ($count > 0){
                $name = $username;
                $_SESSION["success_login"] = "True";
                header('location: home.php');
                exit();
        } else {
            $errors["login"] = "Wrong username or password";
        }
    }


if (isset($_POST["logout"])){
    unset($_SESSION['success_login']);
}

function isusernameExists($username){
    require "db.php";
    $username_check = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
    $result = mysqli_query($conn, $username_check);
    $count = mysqli_num_rows($result);
    return $count;
}

function isTokenExists($token){
    require "db.php";
    $token_check = "SELECT * FROM users WHERE verify_token = '$token' LIMIT 1";
    $result = mysqli_query($conn, $token_check);
    if(mysqli_num_rows($result) > 0){
        return True;
    }
    else{
        return False;
    }
}

function generate_token($strength = 30) {
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $input_length = strlen($permitted_chars);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $permitted_chars[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }
    return $random_string;
}

function recaptchaGetResponse() {
    $secret = "6LejWUUlAAAAAMGizQQ3okAIlWAo4f28RsheUExz";
    $response = $_POST['g-recaptcha-response'];
    $remoteip = $_SERVER['REMOTE_ADDR'];
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip";
    $data = file_get_contents($url);
    $row = json_decode($data, true);
    return $row["success"];
}

function generateGoogleAuth() {
    global $Authenticator;
    $secret = $Authenticator->generateRandomSecret();
    $_SESSION["auth_secret"] = $secret;

    $name = "JMPL: {$_SESSION["username_login"]}";
    $qrCodeUrl = $Authenticator->getQR($name, $secret);
    return [$qrCodeUrl,$secret];
}

function isAuthActive($username) {
    require "db.php";
    $auth_check = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
    $result = mysqli_query($conn, $auth_check);
    $row = mysqli_fetch_assoc($result);
    if($row["auth"] != '0'){
        return True;
    }
    else{
        return False;
    }
}

function verifyAuth($secret, $code){
    global $Authenticator;
    $checkResult = $Authenticator->verifyCode($secret, $code, 2);
    return $checkResult;
}

?>