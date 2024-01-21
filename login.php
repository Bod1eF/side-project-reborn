<?php
session_start();
require_once "sql_config.php";

//account register
$new_account = false;

if (isset($_POST["email"]) && isset($_POST["password"]) == true) { //if coming from register, update user table to create account
  if (filter_var(htmlspecialchars($_POST["email"]), FILTER_VALIDATE_EMAIL)) { //validates email is legit
  try {
  $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
  $sth = $dbh->prepare("INSERT INTO user (`email`, `password`, `isAdmin`)
  VALUES (:reg_email, :reg_password, false);"); //store account info into database
  $sth->bindValue(':reg_email', htmlspecialchars($_POST["email"]));
  $sth->bindValue(':reg_password', password_hash(htmlspecialchars($_POST["password"]), PASSWORD_DEFAULT));
  $sth->execute();
  $sth_id = $dbh->prepare("SELECT * FROM user WHERE `email`=:reg_email"); //gets user row of newly created account
  $sth_id->bindValue(':reg_email', htmlspecialchars($_POST["email"]));
  $sth_id->execute();
  $reg_id = $sth_id->fetch();
  $sth_char->execute();
  $new_account = true;
  }
  catch (PDOException $e) {
  echo "<p>Error: {$e->getMessage()}</p>";
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
<link href="index.css" rel="stylesheet" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="cssandjs/home.js"></script>
</head>
<body>
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
</body>
</html>