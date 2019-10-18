<?php
  class Message extends User {
    function __construct($pdo) {
      $this->pdo = $pdo;
    }

    public function recentMessages($user_id) {
      $sql = "SELECT * 
              FROM `messages` 
              LEFT JOIN `users` 
              ON messageFrom = `user_id` 
              WHERE messageTo = :user_id";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam("user_id", $user_id, PDO::PARAM_INT);
      $stmt->execute();

      return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getMessages($messageFrom, $user_id) {
      $sql = "SELECT * 
              FROM `messages` 
              LEFT JOIN `users` 
              ON `messageFrom` = `user_id` 
              WHERE `messageFrom` = :messageFrom 
              AND `messageTo` = :user_id 
              OR `messageTo` = :messageFrom 
              AND `messageFrom` = :user_id";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(":messageFrom", $messageFrom, PDO::PARAM_INT);
      $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
      $stmt->execute();

      $messages = $stmt->fetchAll(PDO::FETCH_OBJ);
      foreach ($messages as $message) {
        if($message->messageFrom === $user_id) {
          echo '
          <div class="main-msg-body-right">
            <div class="main-msg">
              <div class="msg-img">
                <a href="#"><img src="'.BASE_URL.$message->profileImage.'"/></a>
              </div>
              <div class="msg">'.$message->message.'
                <div class="msg-time">
                  '.$this->timeAgo($message->messageOn).'
                </div>
              </div>
              <div class="msg-btn">
                <a><i class="fa fa-ban" aria-hidden="true"></i></a>
                <a class="deleteMsg" data-message="'.$message->messageID.'"><i class="fa fa-trash" aria-hidden="true"></i></a>
              </div>
            </div>
          </div>
          ';
        } else {
          echo '
          <div class="main-msg-body-left">
            <div class="main-msg-l">
              <div class="msg-img-l">
                <a href="#"><img src="'.BASE_URL.$message->profileImage.'"/></a>
              </div>
              <div class="msg-l">'.$message->message.'
                <div class="msg-time-l">
                  '.$this->timeAgo($message->messageOn).'
                </div>	
              </div>
              <div class="msg-btn-l">	
                <a><i class="fa fa-ban" aria-hidden="true"></i></a>
                <a class="deleteMsg" data-message="'.$message->messageID.'"><i class="fa fa-trash" aria-hidden="true"></i></a>
              </div>
            </div>
          </div> 
          ';
        }
      }
    }

    public function deleteMsg($messageID, $user_id) {
      $sql = "DELETE FROM `messages` 
              WHERE `messageID` = :messageID 
              AND `messageFrom` = :user_id 
              OR `messageID` = :messageID 
              AND `messageTo` = :user_id";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(":messageID", $messageID, PDO::PARAM_INT);
      $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
      $stmt->execute();
    }
  }
?>