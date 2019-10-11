<?php
  include 'core/init.php';
  // is login = home = index
  if(isset($_SESSION['user_id'])) {
    header("Location: home.php");
  }
?>

<!--
   This template created by Meralesson.com 
   This template only use for educational purpose 
-->
<html>
	<head>
		<title>트위터</title>
		<meta charset="UTF-8" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css"/>
		<link rel="stylesheet" href="assets/css/style-complete.css"/>
		<!-- <link rel="stylesheet" href="assets/css/bootstrap.min.css"/> -->
	</head>
  <body>
    <div class="front-img">
      <img src="assets/images/home.jpg"></img>
    </div>	
    <div class="wrapper">
      <div class="header-wrapper">
        <div class="nav-container">
          <div class="nav">
            <div class="nav-left">
              <ul>
                <li><i class="fa fa-twitter" aria-hidden="true"></i><a href="#">Home</a></li>
                <li><a href="#">About</a></li>
              </ul>
            </div>
            <div class="nav-right">
              <ul>
                <li><a href="#">Language</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="inner-wrapper">
        <div class="main-container">
          <div class="content-left">
            <h1>Welcome to Tweety.</h1>
            <br/>
            <p>A place to connect with your friends — and Get updates from the people you love, And get the updates from the world and things that interest you.</p>
          </div>
          <div class="content-right">
            <!-- Log In Section -->
            <div class="login-wrapper">
              <?php include "includes/login.php" ?>
            </div>
            <!-- Register Section -->
            <div class="signup-wrapper">
              <?php include "includes/register_form.php" ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
