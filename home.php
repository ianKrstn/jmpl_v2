<?php
require "controller.php";
if (!isset($_SESSION["success_login"])){
    header('location: index.php');
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
   </head>
<body style="background-color: #2596be">
<div class="wrapper">
  <h2>Anda Berhasil Masuk!</h2> <br><br>
  <br><br>
  <form action="index.php" method="POST">
    <div class="input-box button">
      <input type="Submit" value="Keluar" name="logout" style="background-color: #be4d25">
    </div>
  </form>
</body>
</html>