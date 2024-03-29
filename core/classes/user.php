<?php

// 나중에 에러메세지 끄기 error_reporting
//php notice object of class stdclass could not be converted to int
  class User {
    protected $pdo;
    
    function __construct($pdo) {
      $this->pdo = $pdo;
    }

    public function checkInput($var) {
      $var = htmlspecialchars($var); // html code
      $var = trim($var);
      $var = stripcslashes($var); // remove \
      return $var;
    }

    public function preventAccess($request, $currentFile, $currently) {
      if($request == "GET" && $currentFile == $currently) {
        header('Location:'.BASE_URL.'index.php');
      } 
    }

    public function search($search) {
      $sql = "SELECT `user_id`, `username`, `screenName`, 
                     `profileImage`, `profileCover` 
              FROM `users` 
              WHERE `username` 
              LIKE ? 
              OR `screenName` 
              LIKE ?";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(1, $search.'%', PDO::PARAM_STR);
      $stmt->bindValue(2, $search.'%', PDO::PARAM_STR);
      $stmt->execute();

      return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // login
    public function login($email, $password) {
      $passHash = md5($password);
      $sql = "SELECT `user_id` 
              FROM `users` 
              WHERE `email` = :email 
              AND `password` = :password";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(":email", $email, PDO::PARAM_STR);
      $stmt->bindParam(":password", $passHash, PDO::PARAM_STR);
      $stmt->execute();

      $user  = $stmt->fetch(PDO::FETCH_OBJ);
      $count = $stmt->rowCount();

      if($count > 0) {
        $_SESSION['user_id'] = $user->user_id;
        header('Location: home.php');
      } else {
        return false;
      }
    }

    // register
    public function register($email, $password, $screenName) {
      // $passHash = password_hash("password", PASSWORD_BCRYPT);
      $sql = "INSERT INTO `users` 
              (`email`, `password`, `screenName`, 
              `profileImage`, `profileCover`) 
              VALUES (:email, :password, :screenName, 
                      'assets/images/defaultProfileImage.png', 
                      'assets/images/defaultCoverImage.png')";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(":email", $email, PDO::PARAM_STR);
      $stmt->bindParam(":password", md5($password), PDO::PARAM_STR);
      $stmt->bindParam(":screenName", $screenName, PDO::PARAM_STR);
      $stmt->execute();

      $user_id = $this->pdo->lastInsertId();
      $_SESSION['user_id'] = $user_id;
    }

    public function userData($user_id) {
      $sql = "SELECT * 
              FROM `users` 
              WHERE `user_id` = :user_id";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
      $stmt->execute();

      $user = $stmt->fetch(PDO::FETCH_OBJ);
      return $user;
    }

    public function logout() {
      $_SESSION = array();
      session_destroy();
      header('Location: '.BASE_URL.'index.php');
    }

    public function create($table, $fields = array()) {
      $columns = implode(',', array_keys($fields));
      $values  = ':'.implode(', :', array_keys($fields));
      $sql     = "INSERT INTO {$table} ({$columns}) 
                  VALUES ({$values})";
      if($stmt = $this->pdo->prepare($sql)) {
        foreach ($fields as $key => $data) {
          $stmt->bindValue(':'.$key, $data);
        }
        $stmt->execute();
        
        return $this->pdo->lastInsertId();
      }
    }

    public function update($table, $user_id, $fields = array()) {
      $columns = ''; 
      $i       = 1;

      foreach ($fields as $name => $value) {
        $columns .= "`{$name}` = :{$name}";
        if($i < count($fields)) {
          $columns .= ', ';
        }
        $i++;
      }
      $sql = "UPDATE {$table} 
              SET {$columns} 
              WHERE `user_id` = {$user_id}";
      if($stmt = $this->pdo->prepare($sql)) {
        foreach ($fields as $key => $value) {
          $stmt->bindValue(':'.$key, $value);
        }
        $stmt->execute();
      }
    }

    public function delete($table, $array) {
      $sql = "DELETE FROM `{$table}`";
      $where = " WHERE ";
      
      foreach ($array as $name => $value) {
        $sql .= "{$where} `{$name}` = :{$name}";
        $where = " AND ";
      }

      if($stmt = $this->pdo->prepare($sql)) {
        foreach ($array as $name => $value) {
          $stmt->bindValue(':'.$name, $value);
        } 
        
        $stmt->execute();
      }
    }

    public function checkUsername($username) {
      $sql = "SELECT `username` 
              FROM `users` 
              WHERE `username` = :username";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(":username", $username, PDO::PARAM_STR);
      $stmt->execute();

      $count = $stmt->rowCount();
      if($count > 0)
        return true;
      else
        return false;
    }

    public function checkPassword($password) {
      $sql = "SELECT `password` 
              FROM `users` 
              WHERE `password` = :password";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(":password", md5($password), PDO::PARAM_STR);
      $stmt->execute();

      $count = $stmt->rowCount();
      if($count > 0)
        return true;
      else
        return false;
    }

    // validate email 
    public function checkEmail($email) {
      $sql = "SELECT `email` 
              FROM `users` 
              WHERE `email` = :email";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(":email", $email, PDO::PARAM_STR);
      $stmt->execute();

      $count = $stmt->rowCount();
      if($count > 0)
        return true;
      else
        return false;
    }

    public function loggedIn() {
      return (isset($_SESSION['user_id'])) ? true : false;
    }

    public function userIdByUsername($username) {
      $sql = "SELECT `user_id` 
              FROM `users` 
              WHERE `username` = :username";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(":username", $username, PDO::PARAM_STR);
      $stmt->execute();

      $user = $stmt->fetch(PDO::FETCH_OBJ);
      return $user->user_id;
    }

    # 파일 업로딩
    public function uploadImage($file) {
      $filename = basename($file['name']);
      $fileTmp  = $file['tmp_name'];
      $fileSize = $file['size'];
      $error    = $file['error'];

      $ext         = explode('.', $filename);
      $ext         = strtolower(end($ext));
      $allowed_ext = array('jpg', 'png', 'jpeg');

      if(in_array($ext, $allowed_ext) === true) {
        if($error === 0) {
          if($fileSize <= 209272152) {
            $fileRoot = 'users/' . $filename;
            move_uploaded_file($fileTmp, $_SERVER['DOCUMENT_ROOT'].'/twitter/'.$fileRoot);
            return $fileRoot;
          } else {
            $GLOBALS['imageError'] = "The file size is too large";
          }
        }
      } else {
        $GLOBALS['imageError'] = "The extension is not allowed";
      }
    }

    public function timeAgo($datatime) {
      $time    = strtotime($datatime);
      $current = time();
      $seconds = $current - $time;
      $minutes = round($seconds / 60);
      $hours   = round($seconds / 3600);
      $months  = round($seconds / 2600640);

      if($seconds <= 60) {
        if($seconds == 0) {
          return '지금 막';
        }else {
          return $seconds.'초 전';
        }

      } else if($minutes <= 60) {
        return $minutes.'분 전';
      } else if($hours <= 24) {
        return $hours.'시간 전';
      } else if($months <= 12) {
        return date('M j', $time);
      } else {
        return date('j M Y', $time);
      }
    }
  }
?>