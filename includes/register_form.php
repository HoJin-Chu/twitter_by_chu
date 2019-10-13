<?php
  if(isset($_POST["register"])) {
    $screenName = $_POST['screenName'];
    $password   = $_POST['password'];
    $email      = $_POST['email'];
    $error      = "";
    
    if(empty($screenName) or empty($password) or empty($email)) {
      $error = "All fields are required";
    } else {
      $screenName = $getFromUser->checkInput($screenName);
      $password   = $getFromUser->checkInput($password);
      $email      = $getFromUser->checkInput($email);

      if(!filter_var($email)) {
        $error = "Invalid email format";
      } else if(strlen($screenName) > 20) {
        $error = "Name must be between in 6-20 characters";
      } else if(strlen($password) < 5) {
        $error = "Password is too short";
      } else {

        if($getFromUser->checkEmail($email) === true) {
          $error = 'Email is already in use';
        } else {
          $user_id = $getFromUser->create('users', 
            array(
            'email' => $email, 
            'password' => md5($password), 
            'screenName' => $screenName, 
            'profileImage' => 'assets/images/defaultProfileImage.png', 
            'profileCover' => 'assets/images/defaultCoverImage.png')
            );
          $_SESSION['user_id'] = $user_id;
          header('Location: includes/register.php?step=1');
        }

      }
    }
  }
?>

<form method="post">
  <div class="signup-div"> 
    <div>
      <input type="text" class="form-control mt-2" name="screenName" placeholder="Full Name"/>
    </div>
    <div>
      <input type="email" class="form-control mt-2" name="email" placeholder="휴대폰번호 또는 이메일주소"/>
    </div>
    <div>
      <input type="password" class="form-control mt-2" name="password" placeholder="비밀번호"/>
    </div>
    <div>
      <input type="submit" class="form-control btn-primary mt-3" name="register" Value="회원가입">
    </div>
    <?php
      if(isset($error)) {
        echo '
          <div style="padding:10px; color:#DD0000;">'.$error.'</div>
        ';
      }
    ?>
  </div>
</form>