<?php
  session_start();
  require_once "sql_config.php";

  try {

    if (isset($_POST["user_login"]) && isset($_POST["pass_login"])) {//checks that user came from login
      $dbh =  new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
      $sth_password = $dbh->prepare("SELECT * FROM user WHERE email=:login_email");//find pass_hash where id matches login id
      $sth_password->bindValue(':login_email', htmlspecialchars($_POST["user_login"]));
      $sth_password->execute();
      $login_row = $sth_password->fetch();
      $user_id = $login_row["id"]; 
      $_SESSION["user_id"] = $user_id; //store user id in session

    if (password_verify(htmlspecialchars($_POST["pass_login"]), $login_row['password'])) { //verify password agaisnt hash
        echo "<h1 id='logged_in'> Succesfully Logged in as " . htmlspecialchars($_POST["user_login"]) . "</h2>";
    }
    else { //if password doesn't match send to sign in
      header('Location: index.php');
      exit;
    }
   }
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
#logged_in {
  display:flex;

}
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
    <img src="Untitled_Artwork.png"
        width="210"
        height="125">
  </div>
  <div class="w3-bar-block">
    <a href="loggedin.html" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Profile</a> 
    <a href="#showcase" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Recent Posts</a> 
    <a href="#contact" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Contact</a>
    <a href="frontpage.html" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Log Out</a>
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
  
    <!-- Post -->
    <div class="w3-container" id="Post" style="margin-top:75px">
      <h1 class="w3-xxxlarge w3-text-white"><b>Post</b></h1>
      <hr style="width:50px;border:5px solid white" class="w3-round">
      <p style="color:white">Share your projects with other students and join the Side Project community!</p>
      <form action="index.php">
        <div class="w3-section">
          <label><p style="color:white">Name</p></label>
          <input class="w3-input w3-border" type="text" name="Name" required>
        </div>
        <div class="w3-section">
          <label><p style="color:white">Title</p></label>
          <input class="w3-input w3-border" type="text" name="Title" required>
        </div>
        <input type="radio" id="Art" name="Category" value="Art">
        <label for="Art" style="color:white">Art</label><br>
        <input type="radio" id="Tech" name="Category" value="Tech">
        <label for="Tech" style="color:white">Tech</label><br>
        <input type="radio" id="Biology" name="Category" value="Biology">
        <label for="Biology" style="color:white">Biology</label><br>
        <input type="radio" id="Craftsmenship" name="Category" value="Craftsmenship">
        <label for="Craftsmenship" style="color:white">Craftsmenship</label><br>

        <div class="w3-section">
          <label><p style="color:white">Message</p></label>
          <textarea id="area" rows="4" cols="100" maxlength="300" name="body" placeholder="Enter your Text Here"> 
          </textarea>
          <p class="result" style="color:white"> 
            <span id="word" style="color:white">0</span> Words and
              <span id="char" style="color:white">0</span> Characters 
          </p>
        </div>
        <script> 
            let area = document.getElementById('area'); 
            let char = document.getElementById('char'); 
            let word = document.getElementById('word'); 
      
            area.addEventListener('input', function () { 
                // count characters  
                let content = this.value; 
                char.textContent = content.length; 
      
                // remove empty spaces from start and end  
                content.trim(); 
                console.log(content); 
      
                let wordList = content.split(/\s/); 
      
                // Remove spaces from between words  
                let words = wordList.filter(function (element) { 
                    return element != ""; 
                }); 
      
                // count words  
                word.textContent = words.length; 
            }); 
        </script> 
        <button type="submit" class="w3-button w3-block w3-padding-large w3-white w3-margin-bottom">Post</button>
      </form>  
    </div>
  
    <!-- Designers -->
    <div class="w3-container" id="designers" style="margin-top:75px">
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