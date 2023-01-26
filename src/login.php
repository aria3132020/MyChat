<?php
session_start();
// var_dump($_SERVER);
$user = file_get_contents("user.json");
$userDecode = json_decode($user, true);

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';


$valid = false;




for ($i = 0; $i < count($userDecode); $i++) {
    if (($password == $userDecode[$i]['password']) && (($username == $userDecode[$i]['username']))) {


        $valid = true;
    }
}
if ($valid) {
    header("Location:chat.php");
    $_SESSION['username']=$username;
} 
elseif($valid==false) {

    $_SESSION['flash_message'] = 'username or password is wrong';
    header("Location:loginForm.php");
}
