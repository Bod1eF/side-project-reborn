<?php
  session_start();
  require_once "sql_config.php";

  try {
    
    $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);


  if (isset($_POST["user_login"]) && isset($_POST["pass_login"])) {//checks that user came from login
    $sth_password = $dbh->prepare("SELECT * FROM user WHERE email=:login_email");//find pass_hash where id matches login id
    $sth_password->bindValue(':login_email', htmlspecialchars($_POST["user_login"]));
    $sth_password->execute();
    $login_row = $sth_password->fetch();

    if (password_verify(htmlspecialchars($_POST["pass_login"]), $login_row['password'])) { //verify password agaisnt hash
        echo "<h1 id='logged_in'> Succesfully Logged in as " . htmlspecialchars($_POST["user_login"]) . "</h2>";
        //Fetch Character location, and echo link redirecting to that page
        $_SESSION["email"] = htmlspecialchars($_POST["user_login"]); //store email in session to allow for login checks later on
        $user_id = $login_row["id"]; //store the user id of the user to find its associated character(s)
        $_SESSION["user_id"] = $user_id; //store user id in session
    else { //if password doesn't match send to sign in
      header('Location: login.php');
    }
  }
}

  catch (PDOException $e) {
    echo "<p>Error: {$e->getMessage()}</p>";
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
  <a href="signin.php">Sign In</a>

</body>
</html>