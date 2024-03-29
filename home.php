<?php
  include "core/init.php";
  $user_id = $_SESSION["user_id"];
  $user    = $getFromUser->userData($user_id);
  $notify  = $getFromMessage->getNotificationCount($user_id);
  if($getFromUser->loggedIn() === false) {
    header('Location: index.php');
  }
  
  if(isset($_POST['tweet'])) {
    $status     = $getFromUser->checkInput($_POST['status']);
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
      
    } else {
      $error = "Type or choose image to tweet";
    }
  }
?>

<!DOCTYPE HTML> 
 <html>
	<head>
		<title>트위터</title>
		  <meta charset="UTF-8" />
		  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css"/>  
 	  	  <link rel="stylesheet" href="assets/css/style-complete.css"/> 
         <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
	</head>
  <body>
    <div class="wrapper">
      <div class="header-wrapper">
        <div class="nav-container">
          <div class="nav">
            <div class="nav-left">
              <ul>
                <li><a href="#"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>
                <li>
                  <a href="i/notifications">
                    <i class="fa fa-bell" aria-hidden="true"></i>Notification
                    <span id="notification"><?php if($notify->totalN > 0) {echo '<span class="span-i">'.$notify->totalN.'</span>'; } ?></span>
                  </a>
                </li>
                <li id="messagePopup">
                  <i class="fa fa-envelope" aria-hidden="true"></i>Messages
                  <span id="messages"><?php if($notify->totalM > 0) {echo '<span class="span-i">'.$notify->totalM.'</span>'; } ?></span>
                </li>
              </ul>
            </div>
            <div class="nav-right">
              <ul>
                <li>
                  <input type="text" placeholder="Search" class="search"/>
                  <i class="fa fa-search" aria-hidden="true"></i>
                  <div class="search-result">			
                  </div>
                </li>
                <li class="hover"><label class="drop-label" for="drop-wrap1"><img src="<?php echo $user->profileImage ?>"/></label>
                  <input type="checkbox" id="drop-wrap1">
                  <div class="drop-wrap">
                    <div class="drop-inner">
                      <ul>
                        <li><a href="<?php echo $user->username ?>"><?php echo $user->username ?></a></li>
                        <li><a href="settings/account">Settings</a></li>
                        <li><a href="includes/logout.php">Log out</a></li>
                      </ul>
                    </div>
                  </div>
                </li>
                <li>
                  <label class="addTweetBtn">Tweet</label>
                </li>
              </ul>
            </div><!-- nav right ends-->
          </div><!-- nav ends -->
        </div><!-- nav container ends -->
      </div><!-- header wrapper end -->

      <script type="text/javascript" src="assets/js/search.js"></script>
      <script type="text/javascript" src="assets/js/hashtag.js"></script>

      <!---Inner wrapper-->
      <div class="inner-wrapper">
        <div class="in-wrapper">
          <div class="in-full-wrap">
            <div class="in-left">
              <div class="in-left-wrap">
                <div class="info-box">
                  <div class="info-inner">
                    <div class="info-in-head">
                      <!-- PROFILE-COVER-IMAGE -->
                      <img src="<?php echo $user->profileCover ?>"/>
                    </div><!-- info in head end -->
                    <div class="info-in-body">
                      <div class="in-b-box">
                        <div class="in-b-img">
                          <!-- PROFILE-IMAGE -->
                          <img src="<?php echo $user->profileImage ?>"/>
                        </div>
                      </div><!--  in b box end-->
                      <div class="info-body-name">
                        <div class="in-b-name">
                          <div><a href="<?php echo $user->username ?>"><?php echo $user->screenName ?></a></div>
                          <span><small><a href="<?php echo $user->username ?>">@<?php echo $user->username ?></a></small></span>
                        </div>
                      </div><!-- info body name end-->
                    </div><!-- info in body end-->
                    <div class="info-in-footer">
                      <div class="number-wrapper">
                        <div class="num-box">
                          <div class="num-head">TWEETS</div>
                          <div class="num-body">
                            <?php $getFromTweet->countTweets($user_id); ?>
                          </div>
                        </div>
                        <div class="num-box">
                          <div class="num-head">FOLLOWING</div>
                          <div class="num-body"><span class="count-following"><?php echo $user->following ?></span></div>
                        </div>
                        <div class="num-box">
                          <div class="num-head">FOLLOWERS</div>
                          <div class="num-body"><span class="count-followers"><?php echo $user->followers ?></span></div>
                        </div>	
                      </div><!-- mumber wrapper-->
                    </div><!-- info in footer -->
                  </div><!-- info inner end -->
                </div><!-- info box end-->
                <!--==TRENDS==-->
                  <?php $getFromTweet->trends() ?>
                <!--==TRENDS==-->
              </div><!-- in left wrap-->
            </div><!-- in left end-->
            <div class="in-center">
              <div class="in-center-wrap">
                <!--TWEET WRAPPER-->
                <div class="tweet-wrap">
                  <div class="tweet-inner">
                    <div class="tweet-h-left">
                      <div class="tweet-h-img">
                        <!-- PROFILE-IMAGE -->
                        <img src="<?php echo $user->profileImage ?>"/>
                      </div>
                    </div>
                    <div class="tweet-body">
                      <form method="post" enctype="multipart/form-data">
                        <textarea class="status" name="status" placeholder="Type Something here!" rows="4" cols="50"></textarea>
                        <div class="hash-box">
                          <ul>
                            <!-- ajax here -->
                          </ul>
                        </div>
                        <div class="tweet-footer">
                          <div class="t-fo-left">
                            <ul>
                              <input type="file" name="file" id="file"/>
                              <li>
                                <label for="file"><i class="fa fa-camera" aria-hidden="true"></i></label>
                                <span class="tweet-error">
                                  <?php if(isset($error)){echo $error;} else if(isset($imageError)){echo $imageError;} ?>
                                </span>
                              </li>
                            </ul>
                          </div>
                          <div class="t-fo-right">
                            <span id="count">140</span>
                            <input type="submit" name="tweet" value="tweet"/>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!--TWEET WRAP END-->
              
                <!--Tweet SHOW WRAPPER-->
                <div class="tweets">
                  <?php $getFromTweet->tweets($user_id, 4); ?>
                </div>
                <!--TWEETS SHOW WRAPPER-->

                <div class="loading-div">
                  <img id="loader" src="assets/images/loading.svg" style="display: none;"/>
                </div>
                <div class="popupTweet">
                  <!-- retweet ajax here -->
                </div>
                <!--Tweet END WRAPER-->

                <script src="assets/js/like.js"></script>
                <script src="assets/js/retweet.js"></script>
                <script src="assets/js/popuptweets.js"></script>
                <script src="assets/js/delete.js"></script>
                <script src="assets/js/comment.js"></script>
                <script src="assets/js/popupForm.js"></script>
                <script src="assets/js/fetch.js"></script>
                <script src="assets/js/messages.js"></script>
                <script src="assets/js/postMessage.js"></script>
                <script src="assets/js/notification.js"></script>

              </div><!-- in left wrap-->
            </div><!-- in center end -->
            <div class="in-right">
              <div class="in-right-wrap">

                <!--Who To Follow-->
                  <?php $getFromFollow->whoToFollow($user_id, $user_id); ?>
                <!--Who To Follow-->

              </div><!-- in left wrap-->
            </div><!-- in right end -->

            <script src="assets/js/follow.js"></script>

          </div><!--in full wrap end-->
        </div><!-- in wrappper ends-->
      </div><!-- inner wrapper ends-->
    </div><!-- ends wrapper -->
  </body>
</html>