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
  <h1> Register an Account </h1>
<form action="login.php" method="POST">

<div>
<label for="email"> Email: </label>
<input required type="email" name="email" id="email">
</div>

<div>
<label for="password"> Password: </label>
<input required type="password" name="password" id="password">
</div>

<input type="submit" value="Create Account">
</form>
</body>
</html>