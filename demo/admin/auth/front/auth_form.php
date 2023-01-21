    <form class="form-auth" id="form-auth" action="/admin/auth/front/auth.php" method="POST" enctype="multipart/form-data">
      <?php if (isset($_SESSION["is_auth"]) && !$_SESSION["is_auth"]) : ?>
        <p class="form-auth__respond-message">Не корректный логин или пароль</p>
      <?php endif; ?>
      <div class="form-auth__input-wrapper">
        <input class="form-auth__input" type="text" name="login" value="" placeholder="Логин" required />
        <span class="form-auth__input-error form-auth__input-error_login"></span>
      </div>
      <div class="form-auth__input-wrapper">
        <input class="form-auth__input" type="password" name="password" placeholder="Пароль" value="" required />
        <span class="form-auth__input-error form-auth__input-error_pass"></span>
      </div>
      <div class="form-auth__buttons-wrapper">
        <button class="form-auth__submit-button" type="submit" />
        Войти</button>
      </div>
      <div class="form-respond__message"></div>
    </form>