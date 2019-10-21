<?php
  if($_SERVER['REQUEST_METHOD'] == "GET" && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('Location: ../index.php');
  } 

  include '../core/init.php';
  $user_id = $_SESSION['user_id'];
  $user = $getFromUser->userData($user_id);
  
  if(isset($_GET['step']) === true && empty($_GET['step']) ===false) {
    if(isset($_POST['next'])) {
      $username = $getFromUser->checkInput($_POST['username']);

      if(!empty($username)) {

        if(strlen($username) > 20) {
          $error = "username must be between in 6-20 charecters";
        } else if($getFromUser->checkUsername($username) === true) {
          $error = "Username is already teken";
        } else {
          $getFromUser->update('users', $user_id, array('username' => $username));
          header('Location: register.php?step=2');
        }

      } else {
        $error = "please enter your username to choose";
      }
    }
    ?>
    <!doctype html>
      <html>
        <head>
          <title>twitter</title>
          <meta charset="UTF-8" />
          <link rel="stylesheet" href="assets/css/font/css/font-awesome.css"/>
          <link rel="stylesheet" href="../assets/css/style-complete.css"/>
          <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
          <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        </head>
        <body>
          <div class="wrapper">
            <div class="nav-wrapper">
              <div class="nav-container">	
                <div class="nav-second">
                  <ul>
                    <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>							
                  </ul>
                </div>
              </div>
            </div>
            <!---Inner wrapper-->
            <div class="inner-wrapper">
              <!-- main container -->
              <div class="main-container">
                <!-- step wrapper-->
                <?php if($_GET['step'] == '1') {?>
                  <div class="step-wrapper">
                    <div class="step-container">
                      <form method="post">
                        <h2>Username을 설정해주세요</h2>
                        <h4>나중에 언제든지 바꿀 수 있으니 걱정하지 마세요.</h4>
                        <div>
                          <input type="text" name="username" placeholder="Username"/>
                        </div>
                        <div>
                          <ul>
                            <li><?php if(isset($error)) {echo $error;} ?></li>
                          </ul>
                        </div>
                        <div>
                          <input type="submit" name="next" value="Next"/>
                        </div>
                      </form>
                    </div>
                  </div>
                <?php } ?>
                <?php if($_GET['step'] == '2') {?>
                  <div class='lets-wrapper'>
                    <div class='step-letsgo'>
                      <h2>반갑습니다! <?php echo $user->screenName; ?>님</h2>
                      <p>트위터는 가장 멋지고, 가장 중요한 뉴스, 미디어, 스포츠, TV, 대화 등을 지속적으로 업데이트하는 소셜 네트워크 서비스입니다.</p>
                      <br/>
                      <p>당신이 느끼고 개선해야할 점이나 좋은점과 같은 모든 것에 대해 문의주시면 준비하겠습니다 !</p>
                      <span>
                        <a href='../home.php' class='backButton'>
                          <button class="btn btn-block btn-primary">시작하기</button>
                        </a>
                      </span>
                    </div>
                  </div>
                <?php } ?>
              </div><!-- main container end -->
            </div><!-- inner wrapper ends-->
          </div><!-- ends wrapper -->
        </body>
      </html>
  <?php } ?>