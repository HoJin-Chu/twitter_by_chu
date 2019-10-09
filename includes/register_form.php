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
    <h3>Sign up </h3>
    <ul>
      <li><input type="text" name="screenName" placeholder="Full Name"/></li>
      <li><input type="email" name="email" placeholder="Email"/></li>
      <li><input type="password" name="password" placeholder="Password"/></li>
      <li><input type="submit" name="register" Value="Signup for Twitter"></li>
    </ul>
    <?php
      if(isset($error)) {
        echo '
        <li class="error-li">
          <div class="span-fp-error">'.$error.'</div>
        </li> ';
      }
    ?>
  </div>
</form>