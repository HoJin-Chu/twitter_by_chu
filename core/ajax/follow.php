<?php
  include '../init.php';
  $getFromUser->preventAccess($_SERVER['REQUEST_METHOD'], realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));
  
  if(isset($_POST['unfollow']) && !empty($_POST['unfollow'])) {
    $user_id  = $_SESSION['user_id'];
    $followID = $_POST['unfollow'];
    $profileID = $_POST['profile'];
    $getFromFollow->unfollow($followID, $user_id, $profileID);
  }

  if(isset($_POST['follow']) && !empty($_POST['follow'])) {
    $user_id  = $_SESSION['user_id'];
    $followID = $_POST['follow'];
    $profileID = $_POST['profile'];
    $getFromFollow->follow($followID, $user_id, $profileID);
  }
?>