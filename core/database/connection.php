<?php

  // set Database variable information
  $dsn = 'mysql:host=localhost; dbname=twitter';
  $user = 'root';
  $password = '49600905';

  // Database PDO connection
  try {
    $pdo = new PDO($dsn, $user, $password);
  } catch(PDOExeception $e) {
    echo 'Connection Error'. $e -> getMessage();
  }

?>