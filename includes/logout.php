<?php
  include '../core/init.php';
  $getFromUser->logout();
  if($getFromUser->loggedIn() === false) {
    header('Location: '.BASE_URL.'index.php');
  }
?>