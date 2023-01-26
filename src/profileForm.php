<?php

session_start();
if ($_SESSION['username']) {
  $username = $_SESSION['username'];
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="../dist/output.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <title>profile</title>
  </head>

  <body>

    <div class="flex flex-col w-6/12 mx-auto mt-3  ">
      <p><?= $_SESSION['username']; ?></p>

      <div class="flex flex-row w-5/12 g-1  ">



        <?php if (is_dir("$username/imgProfile")) {
          $scandir = scandir("$username/imgProfile");
          for ($i = 0; $i < count($scandir); $i++) {
            if ($scandir[$i] == '.' || $scandir[$i] == '..') {
              continue;
            } else { ?>

              <img class="border-2 border-blue-500 w-48 m-1" src=<?= "$username/imgProfile/$scandir[$i]"; ?>>
      </div><?php }
          }
        } else { ?>
  <img class="border-2 border-blue-500 w-4/12 " src=<?= "imgProfile.jpg"; ?>><?php
                                                                            }

                                                                              ?>


<div class="mt-2 flex flex-col w-6/12 mx-auto">
  <div class="border-2 border-green-400"><p><?php $profile = file_get_contents("profile.json");
      $profileDecode = json_decode($profile, true);
    echo $profileDecode[0]['profileName'];  ?></p>
    <p><?php echo $profileDecode[0]['profileTxt'];?></p></div>
  
  <form action="profile.php" method="post" enctype="multipart/form-data">
    <p>Profile Bio</p>
    <p><input type="text" name="profileTxt" placeholder="Profile Bio" class=" rounded-lg border-2 border-slate-700 m-1 w-full flex-wrap"></p>
    <p>Profile name</p>
    <p><input type="text" name="profileName" placeholder="Profile Name" class=" rounded-lg border-2 border-slate-700 m-1"></p>

    <p> <input name="file" type="file" placeholder="Choose image profile..." /></p>
    <p><input type="submit" name="submitImg" id="" value="submit" class="w-3/12 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2  rounded mt-3"></p>

  </form>
  <p class="text-red-500 text-center">
    <?php
    if (isset($_SESSION['flash_message'])) {
      $message = $_SESSION['flash_message'];
      unset($_SESSION['flash_message']);
      echo $message;
    }
    ?>
  </p>
</div>

    </div>
  </body>

  </html>
<?php } else {
  header("Location:loginForm.php");
} ?>