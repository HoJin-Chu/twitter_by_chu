<?php 
  include 'core/init.php';

  $user_id = $_SESSION['user_id'];
  $user    = $getFromUser->userData($user_id);
  $notify  = $getFromMessage->getNotificationCount($user_id);

  if($getFromUser->loggedIn() === false) {
    header('Location : '.BASE_URL.'index.php');
  }

  if(isset($_POST['submit'])) {
    $currentPwd  = $_POST['currentPwd'];
    $newPassword = $_POST['newPassword'];
    $rePassword  = $_POST['rePassword'];
    $error       = array();

    if(!empty($currentPwd) && !empty($newPassword) && !empty($rePassword)) {
      if($getFromUser->checkPassword($currentPwd) === true) {
        
        if(strlen($newPassword) < 6) {
          $error['newPassword'] = "password is too short";
        } else if($newPassword != $rePassword) {
          $error['rePassword'] = "password does not match";
        } else {
          $getFromUser->update('users', $user_id, array('password' => md5($newPassword)));
          header('Location: '.BASE_URL.$user->username);
        } 

      }else {
        $error['currentPwd'] = "passord is incorrect";
      }

    } else {
      $error['fields'] = "All fields are required!";
    }
  }
?>

<html>
	<head>
		<title>Password settings page</title>
		<meta charset="UTF-8" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css"/>
		<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
		<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style-complete.css"/>
	</head>
  <body>
    <div class="wrapper">
      <div class="header-wrapper">
        <div class="nav-container">
          <div class="nav">
            <div class="nav-left">
              <ul>
                <li><a href="<?php echo BASE_URL; ?>home.php"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>
                <?php if($getFromUser->loggedIn() === true) { ?>
                  <li>
                    <a href="<?php echo BASE_URL ?>i/notifications">
                      <i class="fa fa-bell" aria-hidden="true"></i>Notification
                      <span id="notification"><?php if($notify->totalN > 0) {echo '<span class="span-i">'.$notify->totalN.'</span>'; } ?></span>
                    </a>
                  </li>
                  <li id="messagePopup">
                    <i class="fa fa-envelope" aria-hidden="true"></i>Messages
                    <span id="messages"><?php if($notify->totalM > 0) {echo '<span class="span-i">'.$notify->totalM.'</span>'; } ?></span>
                  </li>
                <?php } ?> 
              </ul>
            </div>
            <div class="nav-right">
              <ul>
                <li>
                  <input type="text" placeholder="Search" class="search"/><i class="fa fa-search" aria-hidden="true"></i>
                </li>
                <div class="nav-right-down-wrap">
                  <ul class="search-result"></ul>
                </div>
                <li class="hover">
                  <label class="drop-label" for="drop-wrap1"><img src="<?php echo BASE_URL.$user->profileImage; ?>"/></label>
                  <input type="checkbox" id="drop-wrap1">
                  <div class="drop-wrap">
                    <div class="drop-inner">
                      <ul>
                        <li><a href="<?php echo BASE_URL.$user->username; ?>"><?php echo $user->username; ?></a></li>
                        <li><a href="<?php echo BASE_URL; ?>settings/account">Settings</a></li>
                        <li><a href="<?php echo BASE_URL; ?>includes/logout.php">Log out</a></li>
                      </ul>
                    </div>
                  </div>
                </li>
                <li>
                  <label for="pop-up-tweet" class="addTweetBtn">Tweet</label>
                </li>
              </ul>
            </div>
            <!-- nav right ends-->
          </div>
          <!-- nav ends -->

          <script src="<?php echo BASE_URL; ?>assets/js/popupForm.js"></script>
          <script src="<?php echo BASE_URL; ?>assets/js/search.js"></script>
          <script src="<?php echo BASE_URL; ?>assets/js/hastag.js"></script>
          <script src="<?php echo BASE_URL; ?>assets/js/delete.js"></script>
          <script src="<?php echo BASE_URL; ?>assets/js/messages.js"></script>
          <script src="<?php echo BASE_URL; ?>assets/js/notification.js"></script>

        </div><!-- nav container ends -->
      </div><!-- header wrapper end -->
      <div class="container-wrap">
        <div class="lefter">
          <div class="inner-lefter">
            <div class="acc-info-wrap">
              <div class="acc-info-bg">
                <!-- PROFILE-COVER -->
                <img src="<?php echo BASE_URL.$user->profileCover; ?>"/>  
              </div>
              <div class="acc-info-img">
                <!-- PROFILE-IMAGE -->
                <img src="<?php echo BASE_URL.$user->profileImage; ?>"/>
              </div>
              <div class="acc-info-name">
                <h3><?php echo $user->screenName; ?></h3>
                <span><a href="<?php echo BASE_URL.$user->username; ?>">@<?php echo $user->username; ?></a></span>
              </div>
            </div>
            <!--Acc info wrap end-->
            <div class="option-box">
              <ul> 
                <li>
                  <a href="<?php echo BASE_URL; ?>settings/account" class="bold">
                    <div>Account<span><i class="fa fa-angle-right" aria-hidden="true"></i></span></div>
                  </a>
                </li>
                <li>
                  <a href="<?php echo BASE_URL; ?>settings/password">
                    <div>Password<span><i class="fa fa-angle-right" aria-hidden="true"></i></span></div>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div><!--LEFTER ENDS-->
        
        <div class="righter">
          <div class="inner-righter">
            <div class="acc">
              <div class="acc-heading">
                <h2>Password</h2>
                <h3>Change your password or recover your current one.</h3>
              </div>
              <form method="POST">
                <div class="acc-content">
                  <div class="acc-wrap">
                    <div class="acc-left">password</div>
                    <div class="acc-right">
                      <input type="password" name="currentPwd"/>
                      <span>
                        <?php if(isset($error['currentPwd'])) {echo $error['currentPwd'];} ?>
                      </span>
                    </div>
                  </div>
                  <div class="acc-wrap">
                    <div class="acc-left">New password</div>
                    <div class="acc-right">
                      <input type="password" name="newPassword" />
                      <span>
                        <?php if(isset($error['newPassword'])) {echo $error['newPassword'];} ?>
                      </span>
                    </div>
                  </div>
                  <div class="acc-wrap">
                    <div class="acc-left">
                      Verify password
                    </div>
                    <div class="acc-right">
                      <input type="password" name="rePassword"/>
                      <span>
                        <?php if(isset($error['rePassword'])) {echo $error['rePassword'];} ?>
                      </span>
                    </div>
                  </div>
                  <div class="acc-wrap">
                    <div class="acc-left">
                  </div>
                  <div class="acc-right">
                    <input type="Submit" name="submit" value="Save changes"/>
                  </div>
                  <div class="settings-error">
                    <?php if(isset($error['fields'])) {echo $error['fields'];} ?>
                  </div>	
                </div>
              </form>
            </div>
          </div>
          <div class="content-setting">
            <div class="content-heading"></div>
            <div class="content-content">
              <div class="content-left"></div>
              <div class="content-right"></div>
            </div>
          </div>
          </div>	
        </div>
        <!--RIGHTER ENDS-->
      </div>

      <div class="popupTweet"></div>
      <script src="<?php echo BASE_URL; ?>assets/js/postMessage.js"></script>
      
      <!--CONTAINER_WRAP ENDS-->
    </div>
    <!-- ends wrapper -->
  </body>
</html>
