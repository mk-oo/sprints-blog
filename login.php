  <?php
  require_once('./config.php');
  require_once(BASE_PATH . '/logic/auth.php');
  if (isset($_REQUEST['username']) && isset($_REQUEST['password'])) {
    $success = tryLogin($_REQUEST['username'], $_REQUEST['password']);
    if ($success) {
      header('Location:index.php');
      die();
    } else {
      $errors['generic'] = "Please enter a valid username or password";
    }
  }
  ?>
  <?php require_once('layout/header.php'); ?>
  <section class="register">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <h1>Login form</h1>
          <form method="POST" action="login.php">
            <div class="row">
              <label class="col-md-4">Username:</label> <input name="username" class="col-md-8 form-control" required />
            </div>
            <div class="row">
              <label class="col-md-4">Password:</label> <input name="password" type="password" required class="col-md-8 form-control" />
              <span class="text text-danger"><?= isset($errors['generic']) ? $errors['generic'] : '' ?></span>

              <button class="btn btn-success btn-block">Login</button>
          </form>
        </div>
      </div>
    </div>
  </section>
  <?php require_once('layout/footer.php') ?>