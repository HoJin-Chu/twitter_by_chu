<?php
  include "database/connection.php";
  include "classes/user.php";
  include "classes/tweet.php";
  include "classes/follow.php";
  include "classes/message.php";

  global $pdo;

  session_start();

  $getFromUser   = new User($pdo);
  $getFromTweet  = new Tweet($pdo);
  $getFromFollow = new Follow($pdo);
  $getFromMessage = new Message($pdo);

  define("BASE_URL", "http://localhost/twitter/");

?>