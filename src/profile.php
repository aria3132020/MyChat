<?php
session_start();
if ($_SERVER['REQUEST_MEETHOD'] = 'POST') {
    $username = $_SESSION['username'];
    $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
    // $fileExt = explode('.', $_FILES['file']['name']);
    // $ext = strtolower(end($fileExt));
    $fileType = $_FILES['file']['type'] ?? '';
    // echo $fileType;
    if (!is_dir("$username/imgProfile")) {
        // echo "enter";
        // exit;
        mkdir("$username/imgProfile");
    }
    if ($fileType == 'image/jpeg' || $fileType == 'image/jpg' || $fileType == 'image/png') {
        // echo "enter";
        // exit;
        if (!file_exists("$username/imgProfile/1.jpg") || !file_exists("$username/imgProfile/1.png")) {
            move_uploaded_file($_FILES['file']['tmp_name'], "$username/imgProfile/1.$ext");
            $_SESSION['flash_message'] = "copy image 1";
        } else {
            $id = count(scandir("$username/imgProfile/")) + 1;
            move_uploaded_file($_FILES['file']['tmp_name'], "$username/imgProfile/$id.$ext");
            $_SESSION['flash_message'] = "copy image $id";
        }
    }

    $profileTxt = $_POST['profileTxt'] ?? '';
    $profileName = $_POST['profileName'] ?? '';


    if (file_exists("profile.json")) {

        $profile = file_get_contents("profile.json");
        $profileDecode = json_decode($profile, true);

$profileDecode[0]['profileTxt']=$profileTxt;
$profileDecode[0]['profileName']=$profileName;


        // $additionalArray = [

        //     "profileTxt" => $profileTxt,
        //     "username" => $username,
        //     "profileName" => $profileName
        // ];
        // $data_results = file_get_contents('profile.json');
        // $tempArray = json_decode($data_results);

        // //append additional json to json file
        // $tempArray[] = $additionalArray;
        $jsonData = json_encode($profileDecode);

        file_put_contents('profile.json', $jsonData);


        
    }
    if (!file_exists("profile.json") ) {

        $profile[] = [
            "profileTxt" => $profileTxt,
            "username" => $username,
            "profileName" => $profileName
        ];
        $json_encode = json_encode($profile);

        file_put_contents("profile.json", $json_encode, FILE_APPEND);
        
    }


    header("Location:profileForm.php");
}
