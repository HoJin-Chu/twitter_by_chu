<?php
  // set Database variable information
  $dsn = "mysql:host=localhost; dbname=twitter";
  $db_user = "root";
  $db_password = "49600905";

  // Database PDO connection
  try {
    $pdo = new PDO($dsn, $db_user, $db_password);
  } catch(PDOExeception $e) {
    echo "Connection Error". $e -> getMessage();
  }
?>