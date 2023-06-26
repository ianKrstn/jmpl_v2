<?php
require "controller.php";
if(isset($_SESSION["success_login"])){
  header('location:home.php');
  exit();
}
unset($_SESSION["auth"]);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
   </head>
<body style="background-color: #2596be">
  <div class="wrapper">
    <h2>Selamat Datang!</h2>
    <?php
      if(count($errors) == 1){
          ?>
          <p style="color:red">
              <?php
              foreach($errors as $showerror){
                  echo $showerror;
              }
              ?>
          </p>
          <?php
      }elseif(count($errors) > 1){
          ?>
              <?php
              foreach($errors as $showerror){
                  ?>
                  <li style="color:red"><?php echo $showerror; ?></li>
                  <?php
              }
              ?>
          <?php
      }
    ?>
    <form action="index.php" method="POST">
      <div class="input-box">
        <input placeholder="Username" name="username" required>
      </div>
      <div class="input-box">
        <input type="password" placeholder="Kata sandi" name="password" required>
      </div>
      <div class="input-box button">
        <input type="Submit" value="Masuk" name="login">
      </div>
      <div class="text">
        <h3>Tidak punya akun? <a href="register.php">Daftar sekarang</a></h3>
      </div>
    </form>
  </div>
</body>
</html>