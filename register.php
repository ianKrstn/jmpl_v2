<?php
require_once "controller.php";
if(isset($_SESSION["success_login"])){
  header('location:home.php');
  exit();
}

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
    <h2>Daftarkan Dirimu!</h2>
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
    <form action="register.php" method="post">
      <div class="input-box">
        <input type="text" placeholder="Masukkan username kamu" name="username" required>
      </div>
      <div class="input-box">
        <input type="password" placeholder="Buat kata sandi" name="password" required>
      </div>
      <div class="input-box">
        <input type="password" placeholder="Masukkan kembali kata sandi" name="cpassword" required>
      </div>
      <div class="input-box button">
        <input type="Submit" value="Daftar" name="signup">
      </div>
      <div class="text">
        <h3>Sudah punya akun? <a href="index.php">Masuk sekarang</a></h3>
      </div>
    </form>
  </div>
</body>
</html>
