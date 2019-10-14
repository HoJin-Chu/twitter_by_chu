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
		<link rel="stylesheet" href="assets/css/index.css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	</head>
  <body>
    <div class="container-fuild">
      <div class="row container_height">
        <div class="col first_background">
          <ul class="intro">
            <li>
              <i class="fa fa-search fa-2x mr-4"></i>
              관심사를 팔로우하세요.
            </li>
            <li>
              <i class="fa fa-user fa-2x mr-4"></i>
              서로의 이야기 주제에 대해 알아보세요.
            </li>
            <li>
              <i class="fa fa-comments fa-2x mr-4"></i>
              대화에 참여하세요.
            </li>
          </ul>
        </div>
        <div class="col">

          <!-- Log In Section -->
          <div class="login-wrapper">
            <?php include "includes/login.php" ?>
          </div>

          <!-- Register Section -->
          <div class="register_form">
            <div class="card-body">
              <h3 class="card-title mb-5 mt-3">
                <i class="fa fa-twitter fa-2x" style="color:Dodgerblue;"></i>
                <br/>지금 세계 곳곳에서 무슨 일이 일어나고 있는지 확인하세요.
              </h3>
              <h5 class="card-subtitle mb-4">지금 트위터에 가입하세요.</h5>
              <div class="signup-wrapper">
                <?php include "includes/register_form.php" ?>
              </div>
            </div>
          </div>
          
        </div>
      </div>
    </div>
  </body>
</html>
