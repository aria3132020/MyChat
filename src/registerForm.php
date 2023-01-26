<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="../dist/output.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <title>Document</title>
</head>

<body>
  <div class=" m-20 ">
  <form action="register.php" method="post">
    <div class="flex gap-3 w-6/12">
      <div class="w-6/12">
        <p>Name:</p>
        <div class="flex py-1 border-2 border-green-500 rounded items-center">
          <input type="text" name="name" class="w-full placeholder-slate-400 disabled:border-slate-200 focus:outline-none" />
          <div class="text-green-500 material-symbols-outlined">done</div>
        </div>
      </div>
      <div class="w-6/12">
        <p>Email:</p>
        <div class="flex py-1 border-2 border-green-500 rounded items-center">
          <input type="text" name="email" class="w-full placeholder-slate-400 disabled:border-slate-200 focus:outline-none" />
          <div class="text-green-500 material-symbols-outlined">done</div>
        </div>
      </div>
      
    </div>

    <div class="flex gap-3 w-6/12 mt-2 ">
      <div class="w-full">
        <p>password:</p>
        


          <div class="flex py-1 border-2 border-pink-500 rounded-r items-center">
            <input type="text" name="password" class="w-full placeholder-slate-400 disabled:border-slate-200 focus:outline-none " />
            <div class="text-pink-500 material-symbols-outlined">
              check_circle
            </div>
          </div>
        
      </div>
    
    </div>
    <div class="w-6/12">
      <p>User Name:</p>
      <div class="flex">
       
        <div class="flex w-full py-1 border-2 border-pink-500 rounded-r items-center">
          <input type="text" name="username" class="w-full placeholder-slate-400 disabled:border-slate-200 focus:outline-none" />
          <div class="text-pink-500 material-symbols-outlined">
            check_circle
          </div>
        </div>
      </div>
    </div>
    <div class="flex gap-3 w-6/12 mt-5 justify-center">


      <div>

        <input type="submit" class="bg-blue-700 text-white px-20 py-2" value="Register">
        <p class="text-red-500 text-center">
          <?php
          if(isset($_SESSION['flash_message'])) {
            $message = $_SESSION['flash_message'];
            unset($_SESSION['flash_message']);
            echo $message;
          }
          ?>
        </p>
      </div>

  </form>
</div>
</body>

</html>