<?php
  include "database/connection.php";
  include "classes/user.php";
  include "classes/tweet.php";
  include "classes/follow.php";

  global $pdo;

  session_start();

  $getFromUser = new User($pdo);
  $getFromTweet = new Tweet($pdo);
  $getFromFollow = new Follow($pdo);

  define("BASE_URL", "http://localhost/twitter/");

?>