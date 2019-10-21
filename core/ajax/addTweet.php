<?php 
  include '../init.php';
  $getFromUser->preventAccess($_SERVER['REQUEST_METHOD'], realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));
  
  if(isset($_POST) && !empty($_POST)) {
    $status     = $getFromUser->checkInput($_POST['status']);
    $user_id    = $_SESSION['user_id'];
    $tweetImage = ''; 

    if(!empty($status) or !empty($_FILES['file']['name'][0])) {
      if(!empty($_FILES['file']['name'][0])) {
        $tweetImage = $getFromUser->uploadImage($_FILES['file']);
      }

      if(strlen($status) > 140) {
        $error = "The text of your tweet is too long";
      }
      $tweet_id = $getFromUser->create('tweets', 
        array(
        'status' => $status, 
        'tweetBy' => $user_id, 
        'tweetImage' => $tweetImage, 
        'postedOn' => date('Y-m-d H:i:s')
      ));
      // 정규표현식
      preg_match_all("/#+([a-zA-Z0-9_]+)/i", $status, $hashtag);
      
      if(!empty($hashtag)) {
        $getFromTweet->addTrend($status);
      }
      $getFromTweet->addMention($status, $user_id, $tweet_id);

      $result['success'] = "Your tweet has been posted";
      echo json_encode($result);
      
    } else {
      $error = "Type or choose image to tweet";
    }
    
    if(isset($error)) {
      $result['error'] = $error;
      echo json_encode($result);
    }
  }
?>