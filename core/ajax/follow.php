<?php
  include '../init.php';

  if(isset($_POST['unfollow']) && !empty($_POST['unfollow'])) {
    $user_id  = $_SESSION['user_id'];
    $followID = $_POST['unfollow'];
    $getFromFollow->unfollow($followID, $user_id);
  }

  if(isset($_POST['follow']) && !empty($_POST['follow'])) {
    $user_id  = $_SESSION['user_id'];
    $followID = $_POST['follow'];
    $getFromFollow->follow($followID, $user_id);
  }
?>