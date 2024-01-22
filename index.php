<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
<?php
session_start();
require_once "sql_config.php";
if (isset($_POST["title"]) && isset($_POST["body"]) && isset($_POST["category"]) && isset($_POST["name"]) && isset($_SESSION["user_id"])  == true) {//if coming from create post, add post to database
    
  try {
    $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $acceptable_categories = ["tech", "bio", "crafts", "art"];
    if (!in_array(htmlspecialchars($_POST["category"]), $acceptable_categories)) {
      header("Location: logout.php");
      exit;
    }
    $sth = $dbh->prepare("INSERT INTO posts (`title`, `body`, `category`, `name`,`num_collaborators`, `user_id`)
    VALUES (:reg_title, :reg_body, :reg_category, :reg_name, 1, :reg_user_id);"); //store post data in posts db
    $sth->bindValue(':reg_title', htmlspecialchars($_POST["title"]));
    $sth->bindValue(':reg_body', htmlspecialchars($_POST["body"]));
    $sth->bindValue(':reg_category', htmlspecialchars($_POST["category"]));
    $sth->bindValue(':reg_name', htmlspecialchars($_POST["name"]));
    $sth->bindValue(':reg_user_id', htmlspecialchars($_SESSION["user_id"]));
    $sth->execute();
    echo '<script>alert("Post Submitted!")</script>'; 
  }
  catch (PDOException $e) {
    echo "<p>Error: {$e->getMessage()}</p>";
  }
}

try { //fetch all posts in the posts table 
  $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
  $sth_posts= $dbh->prepare("SELECT email, title, body, name, category, date, num_collaborators FROM posts INNER JOIN user
  ON posts.user_id = user.id ORDER BY date DESC;");
  $sth_posts->execute();
  $arr_of_posts = $sth_posts->fetchAll(PDO::FETCH_ASSOC);  
}
catch (PDOException $e) {
  echo "<p>Error: {$e->getMessage()}</p>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Side Project</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
<style>

body {
 background-color: #e2d5ed; /* For browsers that do not support gradients */
 background-image: linear-gradient(#e2d5ed, #665375);
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
    <h3 class="w3-padding-64"><b>Welcome!</b></h3>
  </div>
  <div class="w3-bar-block">
 <?php 

    try {
        if (isset($_SESSION["user_id"])) {
            echo '<a href="logout.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Log Out</a>';

      }
       else {
        echo '<a href="login.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Log In</a>';
      }
}

catch (PDOException $e) {
    echo "<p>Error: {$e->getMessage()}</p>";
  }


?>
    <a href="form.php" class="w3-bar-item w3-button w3-hover-white">Post a Project</a> 
    <a href="#showcase" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Recent Posts</a> 
    <a href="#designers" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Designers</a>
  
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

  <!-- Header -->
  <div class="w3-container" style="margin-top:80px" id="showcase">
    <center><img src="Untitled_Artwork.png"
        width="600"
        height="300"></center>
  </div>
  
  <!-- Photo grid (modal) -->
  <div class="w3-row-padding">
  </div>

  <!-- Modal for full size images on click-->
  <div id="modal01" class="w3-modal w3-black" style="padding-top:0" onclick="this.style.display='none'">
    <span class="w3-button w3-black w3-xxlarge w3-display-topright">×</span>
    <div class="w3-modal-content w3-animate-zoom w3-center w3-transparent w3-padding-64">
      <img id="img01" class="w3-image">
      <p id="caption"></p>
    </div>
  </div>

  <!-- Services -->
  <div class="w3-container" id="services" style="margin-top:0px">
    <h1 class="w3-xxxlarge w3-text-white"><b>Recent Posts</b></h1>
    <hr style="width:50px;border:5px solid whitesmoke" class="w3-round">
    <p style="color:whitesmoke">See the most recent posts by fellow coders!</p>
  </div>
  
  <?php

  try {
  $count = 4;
  foreach($arr_of_posts as $post) {
    if ($count % 3 == 1) {
      echo "<div class='w3-row-padding w3-grayscale'>";
      echo "<p id='seperator'></p>";
    }
    echo '<div class="w3-col m4 w3-margin-bottom"><div class="w3-light-grey">';
    if ($post['category'] == "art") {
      echo '<img src="Art_Cat.png" alt="John" style="width:100%">';
    }
    elseif ($post['category'] == "bio") {
      echo '<img src="Bio_Cat.png" alt="John" style="width:100%">';
    }
    elseif ($post['category'] == "tech") {
      echo '<img src="Tech_Cat.png" alt="John" style="width:100%">';
    }
    else  {
      echo '<img src="Chainsaw_Cat.png" alt="John" style="width:100%">';
    }
    echo '<div class="w3-container">';
    echo '<h3>'  . $post['title'] .  '</h3>';
    echo '<p class="w3-opacity">' . $post['name'] . "  " . $post['email'] .  '</p>';
    echo '<p>' . $post['date'] . '<br>' .$post['body'] . '</p>';
    echo '</div></div></div>';
    $count++;
    if ($count % 3 == 1) {
      echo "</div>";
    }

  }
  }

  catch (PDOException $e) {
    echo "<p>Error: {$e->getMessage()}</p>";
  }
  ?>
  

  <!-- Designers -->
  <div class="w3-container" id="designers" style="margin-top:75px">
      <h1 class="w3-xxxlarge w3-text-white"><b>Designers</b></h1>
      <hr style="width:50px;border:5px solid whitesmoke" class="w3-round">
      <p style="color:white">The best team in the world.</p>
      <img src="Us_Cats.png" alt="Cat" style="width:100%">
    </div>
  

<!-- End page content -->
</div>


<script>
// Script to open and close sidebar
function w3_open() {
  document.getElementById("mySidebar").style.display = "block";
  document.getElementById("myOverlay").style.display = "block";
}
 
function w3_close() {
  document.getElementById("mySidebar").style.display = "none";
  document.getElementById("myOverlay").style.display = "none";
}

// Modal Image Gallery
function onClick(element) {
  document.getElementById("img01").src = element.src;
  document.getElementById("modal01").style.display = "block";
  var captionText = document.getElementById("caption");
  captionText.innerHTML = element.alt;
}
</script>

</body>
</html>
