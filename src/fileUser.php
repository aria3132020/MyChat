<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_SESSION['username'];
  $fileSize = $_FILES['file']['size'];
  $fileName = $_FILES['file']['name'] ?? '';
  $tmpName = $_FILES['renameFile']['tmp_name'] ?? '';
  $fileExt = explode('.', $fileRenamein);
  $fileActualExt = strtolower(end($fileExt));

  if (!is_dir($username)) {
    mkdir($username);
    $_SESSION['flash_message'] = "make dirctory";
  }
  if ($fileSize < 500000) {
    move_uploaded_file($_FILES['file']['tmp_name'], "$username/$fileName");
    $_SESSION['path_img'] = "$username/$fileName";
  } else {
    $_SESSION['flash_message'] = "file size more than 50MB";
  }
  if (file_exists("post.json")) {

    $post = file_get_contents("post.json");
    $postDecode = json_decode($post, true);
    $id = $postDecode[count($postDecode) - 1]['id'] + 1;


    $additionalArray = [
      "id" => $id,
      "postText" => '',
      "username" => $username,
      "pathFile" => "$username/$fileName"
    ];
    $data_results = file_get_contents('post.json');
    $tempArray = json_decode($data_results);

    //append additional json to json file
    $tempArray[] = $additionalArray;
    $jsonData = json_encode($tempArray);

    file_put_contents('post.json', $jsonData);


    $_SESSION['flash_message'] = "posted";
  }
  if (!file_exists("post.json") && ($_POST['postText'] != null) && (strlen($postText) <= 100)) {

    $post[] = [
      "id" => 1,
      "postText" => '',
      "username" => $username,
      "pathFile" => "$username/$fileName"
    ];
    $json_encode = json_encode($post);

    file_put_contents("post.json", $json_encode, FILE_APPEND);
    $_SESSION['flash_message'] = "posted";
  }

  header("Location:chat.php");
}
