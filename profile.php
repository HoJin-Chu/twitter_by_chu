<?php
  if(isset($_GET['username']) === true && empty($_GET['username']) === false) {
    include 'core/init.php';
    $username = $getFromUser->checkInput($_GET['username']);
    $profileId = $getFromUser->userIdByUsername($username);
  }
?>