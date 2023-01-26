<?php
session_start();
if (isset($_SESSION['username'])) {


  if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    // echo '100';
    if (isset($_POST['logout'])) {
      unset($_SESSION['username']);
      unset($_SESSION['flash_message']);
      header("Location:login.php");
    }
    $postText = $_POST['postText'] ?? '';
    $username = $_SESSION['username'] ?? '';
    if (strlen($postText) > 100) {
      $_SESSION['flash_message'] = "text post must less than 100 character";
    }
    if (file_exists("post.json") && (strlen($_POST['postText']) > 0) && (strlen($postText) <= 100)) {

      $post = file_get_contents("post.json");
      $postDecode = json_decode($post, true);
      if (count($postDecode) == 0) {
        $id = 1;
      } else {
        $id = $postDecode[count($postDecode) - 1]['id'] + 1;
      }



      $additionalArray = [
        "id" => $id,
        "postText" => $postText,
        "username" => $username,
        "pathFile" => ''
      ];
      $data_results = file_get_contents('post.json');
      $tempArray = json_decode($data_results);

      //append additional json to json file
      $tempArray[] = $additionalArray;
      $jsonData = json_encode($tempArray);

      file_put_contents('post.json', $jsonData);


      $_SESSION['flash_message'] = "posted";
    }
    if (!file_exists("post.json") && (strlen($_POST['postText']) > 0) && (strlen($postText) <= 100)) {

      $post[] = [
        "id" => 1,
        "postText" => $postText,
        "username" => $username,
        "pathFile" => ''
      ];
      $json_encode = json_encode($post);

      file_put_contents("post.json", $json_encode, FILE_APPEND);
      $_SESSION['flash_message'] = "posted";
    }
    if (isset($_POST['btnDel'])) {

      // exit;
      $idDel = $_POST['btnDel'];
      // echo $idDel;
      $post = file_get_contents("post.json");
      $postDecode = json_decode($post, true);
      // var_dump($postDecode);
      unset($postDecode[$idDel]);
      $postDecode = array_values($postDecode);
      file_put_contents('post.json', json_encode($postDecode));
      header('Location:chat.php');
    }
  }
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="../dist/output.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <title>Chat Room</title>
  </head>

  <body class="">
    <div class=" w-6/12 mx-auto flex flex-col  ">
      <p class="text-64 text-blue-700 text-lg font-bold m-1">Username: <?= $_SESSION['username'] ?> <a href="profileForm.php" class="text-green-500 border-2 boder-slate-500 rounded px-1">profile</a> </p>

      <div id="scroll" class="overflow-auto bg-cyan-300  h-96">
        <?php
        $post = file_get_contents("post.json");

        $postDecode = json_decode($post, true);
        for ($i = 0; $i < count($postDecode); $i++) {
          if (isset($postDecode[$i]['username'])) {
            if ($postDecode[$i]['username'] ==  $_SESSION['username']) {
        ?>
              <div class="flex flex-row ">
                <div class="flex flex-col bg-green-500 w-6/12 rounded-lg border border-white  m-1 text-white">
                  <p class="bg-green-600 rounded-t-lg px-1"><?php echo $postDecode[$i]['username']; ?></p>
                  <p class="p-1"><?php echo $postDecode[$i]['id'] . ": " . $postDecode[$i]['postText']; ?></p>
                  <img class="w-full" src="<?= $postDecode[$i]['pathFile']; ?>" alt="">
                  <form action="" method="post"><button name="btnDel" value=<?= $i; ?>>delete</button></form>
                </div>
              </div>
            <?php
            } else { ?>
              <div class="flex flex-row-reverse ">
                <div class="flex flex-col bg-blue-500 w-6/12 rounded-lg border border-white  m-1 text-white">
                  <p class="bg-blue-600 rounded-t-lg px-1"><?php echo $postDecode[$i]['username']; ?></p>
                  <p class="p-1"><?php echo $postDecode[$i]['id'] . ": " . $postDecode[$i]['postText']; ?></p>
                  <img class="w-full" src="<?= $postDecode[$i]['pathFile']; ?>" alt="">
                  <form action="" method="post"><button name="btnDel" value=<?= $i; ?>>delete</button>
                    <p class="mx-2">seen</p>
                  </form>
                </div>
              </div>
        <?php }
          }
        }
        ?>
      </div>
      <div class="  ">
        <form action="" method="post">
          <div>
            <input type="text" name="postText" class="w-full outline outline-1 outline-cyan-700 mt-2" />
          </div>
          <div>
            <input type="submit" name="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2  rounded mt-3" value="send" />
          </div>
          <input type="submit" name="logout" value="logout" class="w-full bg-red-500 hover:bg-blue-700 text-white font-bold py-2  rounded mt-3">
        </form>
        <p class="text-white bg-red-700 text-lg text-center mt-1"> <?php if (isset($_SESSION['flash_message'])) {
                                                                      $message = $_SESSION['flash_message'];
                                                                      unset($_SESSION['flash_message']);
                                                                      echo $message;
                                                                    } ?></p>
      </div>
      <form action="fileUser.php" method="post" enctype="multipart/form-data">
        <input type="file" name="file" placeholder="Choose file">
        <input type="submit" name="fileSubmit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2  rounded mt-3">

      </form>
    </div>
    <script src="jquery.js"></script>
    <script>
      // $("form").submit(function(event) {
      // event.preventDefault();
      // alert("enter")
      $(document).ready(function() {
        // event.preventDefault();
        // var scroll = $('#scroll').scrollTop($('#scroll').height());
        var element = document.getElementById("scroll");
        element.scrollTop = element.scrollHeight;
        // scroll({
        // scrollTop: 
        // scroll.prop("scrollHeight")
        // });
      })
      // $("input[name='submit']").hover(function(e){
      // alert("enter")

      // })

      //   var $target = $('#scroll');
      // $target.animate({
      //   scrollTop: $target.height()
      // }, 500);
      // });
      // $(document).load(function() {

      //   $("[name='submit']").click(function() {
      //     alert("enter")
      //     $("#scroll").scrollTop($("#scroll").height());
      //   });
      // });
    </script>
  </body>

  </html>
<?php } else {
  header("Location: login.php");
}
?>