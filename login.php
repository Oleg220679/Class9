<?php

$page_title = 'Login page';

require('base/header.php');

$user = array(
  // Логін, з яким можна зайти на сайт.
  'name' => 'admin',
  // пароль "123", але ми його не зберігаємо у відкритому вигляді, ми вписуємо тільки хеш md5.
  'pass' => '202cb962ac59075b964b07152d234b70',
);


// Якщо запис у користувача про сесію вже є, тоді пропонуємо йому розлогінитися.
// Тобто вийти з сайту.
if (!empty($_SESSION['login'])) {
  print 'Ви вже залоговані на сайті.';
  print '<a href="/logout.php">Вийти</a>';
}

// Якщо користувач відправляє форму, тоді аналізуємо дані з POST.
if (!empty($_POST['name']) && !empty($_POST['pass'])) {

  // Якщо доступи вірні, тоді робимо відповідний запис у сесії.
  if ($_POST['name'] == $user['name'] && md5($_POST['pass']) == $user['pass']) {
    $_SESSION['login'] = TRUE;
    // Направляємо користувача на головну сторінку.
    header('Location: /');
  }

}
?>

<!-- Якщо користувач немає запису у сесії, тоді виводимо йому форму. -->
<?php if(empty($_SESSION['login'])): ?>

  <div class="container">
  <a id="modal_trigger" href="#modal" class="btn">Click here to Login or register</a>

  <div id="modal" class="popupContainer" style="display:none;">
    <header class="popupHeader">
      <span class="header_title">Login</span>
      <span class="modal_close"><i class="fa fa-times"></i></span>
    </header>  
    <section class="popupBody">
      <!-- Форма соцмереж -->
      <div class="social_login">
        <div class="">
          <a href="#" class="social_box fb">
            <span class="icon"><i class="fa fa-facebook"></i></span>
            <span class="icon_title">Connect with Facebook</span>
            
          </a>

          <a href="#" class="social_box google">
            <span class="icon"><i class="fa fa-google-plus"></i></span>
            <span class="icon_title">Connect with Google</span>
          </a>
        </div>

        <div class="centeredText">
          <span>Or use your Email address</span>
        </div>

        <div class="action_btns">
          <div class="one_half"><a href="#" id="login_form" class="btn">Login</a></div>
          <div class="one_half last"><a href="#" id="register_form" class="btn">Sign up</a></div>
        </div>
      </div>

      <!-- Форма з використанням логіна і пароля -->
      <div class="user_login">
        <form name="myfrm" action="<?php print $_SERVER["PHP_SELF"]; ?>" method="POST" class="form-login">
          <label>Email / Username</label>
          <input type="text" name="name"/>
          <br />

          <label>Password</label>
          <input type="password" name="pass"/>
          <br />

          <div class="checkbox">
            <input id="remember" type="checkbox" />
            <label for="remember">Remember me on this computer</label>
          </div>

          <div class="action_btns">
            <div class="one_half"><a href="#" class="btn back_btn"><i class="fa fa-angle-double-left"></i> Back</a></div>
            <div class="one_half last" name="submit"><a href="#" onclick="document.myfrm.submit(); return false;" class="btn btn_red">Login</a></div>
          </div>
        </form>

        <a href="#" class="forgot_password">Forgot password?</a>
      </div>

      <!-- Форма реєстрації -->
      <div class="user_register">
        <form>
          <label>Full Name</label>
          <input type="text" />
          <br />

          <label>Email Address</label>
          <input type="email" />
          <br />

          <label>Password</label>
          <input type="password"/>
          <br />

          <div class="checkbox">
            <input id="send_updates" type="checkbox"/>
            <label for="send_updates">Send me occasional email updates</label>
          </div>

          <div class="action_btns">
            <div class="one_half"><a href="#" class="btn back_btn"><i class="fa fa-angle-double-left"></i> Back</a></div>
            <div class="one_half last"><a href="#" class="btn btn_red">Register</a></div>
          </div>
        </form>
      </div>
    </section>
   </div>
  </div>  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script type="text/javascript" src="js/jquery.leanModal.min.js"></script>
    <script type="text/javascript">

  $("#modal_trigger").leanModal({top : 200, overlay : 0.6, closeButton: ".modal_close" });

  $(function(){
    // Виклик форми для входу
    $("#login_form").click(function(){
      $(".social_login").hide();
      $(".user_login").show();
      return false;
    });

    // Виклик форми реєстрації
    $("#register_form").click(function(){
      $(".social_login").hide();
      $(".user_register").show();
      $(".header_title").text('Register');
      return false;
    });

    // Повернення до форми соцмереж
    $(".back_btn").click(function(){
      $(".user_login").hide();
      $(".user_register").hide();
      $(".social_login").show();
      $(".header_title").text('Login');
      return false;
    });

  })
</script>

<?php endif; ?>

<?php
// Підключаємо футер сайту.
require('base/footer.php');
?>
