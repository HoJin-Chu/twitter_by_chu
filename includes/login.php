<?php
  if(isset($_POST['login']) && !empty($_POST['login'])) {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    if(!empty($email) or !empty($password)) {
      $email    = $getFromUser->checkInput($email);
      $password = $getFromUser->checkInput($password);

      // check email validate
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $login_error = "형식이 맞지 않습니다.";
      }
      else{
        if($getFromUser->login($email, $password) === false) {
          $login_error = "아이디 또는 비밀번호가 틀렸습니다.";
        }
      }

    } else {
      $login_error = "아이디와 비밀번호를 모두 입력하세요.";
    }
  }
?>

<div class="login-div">
  <form method="post" class="form-inline pa-4"> 
    <div style="margin:0 auto;">
      <input type="text" class="form-control mr-3" name="email" placeholder="이메일주소">
      <input type="password" class="form-control mr-3" name="password" placeholder="비밀번호">
      <!-- <input type="checkbox" Value="Remember me">아이디 저장 -->
      <input type="submit" class="btn btn-outline-primary" name="login" value="로그인">
      <?php 
        if(isset($login_error)) {
          echo '
            <div style="padding:10px; color:#DD0000;">'.$login_error.'</div>
          ';
        }
      ?>
    </div>
	</form>
</div>
