<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Out</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
      <?php
      session_start();
      session_destroy();
      session_unset();
      header("Location: index.php");
      ?>
  </body>
</html>