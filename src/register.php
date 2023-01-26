<?php
session_start();
$_SESSION['flash_message']="Unregisterd";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $password = $_POST['password'] ?? '';

    $email = $_POST['email'] ?? '';

    $name = $_POST['name'] ?? '';
    $username = $_POST['username'] ?? '';

    if (!file_exists("user.json") && ($password!=null)&& ($email!=null) && ($name!=null)&& ($username!=null)) {
        
        $user[] = [
            "name" => $name,
            "password" => $password,
            "email" => $email,
            "username" => $username
        ];
        $json_encode = json_encode($user);

        file_put_contents("user.json", $json_encode, FILE_APPEND);
        $_SESSION['flash_message']="registerd";
    }
    } 
    if(file_exists("user.json") && ($password!=null)&& ($email!=null) && ($name!=null)&& ($username!=null)) {
        $user = file_get_contents("user.json");
        $userDecode = json_decode($user, true);
        for ($i = 0; $i < count($userDecode); $i++) {
            if ((($email == $userDecode[$i]['email']))){
                $_SESSION['flash_message']="$email is available.";
                header("Location: registerForm.php");
                exit;
            } 
           $additionalArray = [
            "name" => $name,
            "password" => $password,
            "email" => $email,
            "username" => $username
        ];
        $data_results = file_get_contents('user.json');
        $tempArray = json_decode($data_results);

        //append additional json to json file
        $tempArray[] = $additionalArray;
        $jsonData = json_encode($tempArray);

        file_put_contents('user.json', $jsonData);  
        }
       
        $_SESSION['flash_message']="registerd";
    }
    


header("Location: registerForm.php");
?>

