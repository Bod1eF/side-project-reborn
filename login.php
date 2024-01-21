<?php
session_start();
require_once "sql_config.php";

//account register
$new_account = false;

if (isset($_POST["email"]) && isset($_POST["password"]) == true) { //if coming from register, update user table to create account
  if (filter_var(htmlspecialchars($_POST["email"]), FILTER_VALIDATE_EMAIL)) { //validates email is legit

    echo "registering account";
    try {
      $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
      echo "Connected successfully";
      $sth = $dbh->prepare("INSERT INTO user (`email`, `password`, `isAdmin`)
      VALUES (:reg_email, :reg_password, false);"); //store account info into database
      $sth->bindValue(':reg_email', htmlspecialchars($_POST["email"]));
      $sth->bindValue(':reg_password', password_hash(htmlspecialchars($_POST["password"]), PASSWORD_DEFAULT));
      $sth->execute();
      $sth_id = $dbh->prepare("SELECT * FROM user WHERE `email`=:reg_email"); //gets user row of newly created account
      $sth_id->bindValue(':reg_email', htmlspecialchars($_POST["email"]));
      $sth_id->execute();
      $reg_id = $sth_id->fetch();
      $new_account = true;
      echo "Account registered";
    } 
    catch(PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
}
}
?>
<!doctype html>
<html lang="en">
<head>
 <title>Side Project</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<link href="index.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="cssandjs/home.js"></script>
<style>

body {
 background-color: #e2d5ed;
}
    
body,h1,h2,h3,h4,h5 {font-family: "Poppins", sans-serif}
body {font-size:16px;}
.w3-half img{margin-bottom:-6px;margin-top:16px;opacity:0.8;cursor:pointer}
.w3-half img:hover{opacity:1}
</style>
</head>

<body>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-silver w3-collapse w3-top w3-large w3-padding" style="z-index:3;width:300px;font-weight:bold;" id="mySidebar"><br>
    <a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-hide-large w3-display-topleft" style="width:100%;font-size:22px">Close Menu</a>
    <div class="w3-container">
    </div>
    <div class="w3-bar-block">
      <h1> Side Project </h1>
  <form action="listing.php" method="POST">
<div>
<label for="user_login"> Email: </label>
<input type="email" name="user_login" id="user_login">
</div>
<br><br>
<div>
<label for="pass_login"> Password: </label>
<input type="password" name="pass_login" id="pass_login">
</div>
<br><br>
<input type="submit" value="Login">
</form>
<div id="links">
<a href="signup.php">Don't have an account? Register one here</a>
    </div>
  </nav>    

<!-- Top menu on small screens -->
<header class="w3-container w3-top w3-hide-large w3-white w3-xlarge w3-padding">
    <a href="javascript:void(0)" class="w3-button w3-white w3-margin-right" onclick="w3_open()">☰</a>
    <span>Side Project</span>
  </header>
  
<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>
  
<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:340px;margin-right:40px">
<img src="Untitled_Artwork.png"
    width="900"
    height="500">
    <p style="color:#383436">The #1 website to find collaborators for any project!</p>
</body>
</html>