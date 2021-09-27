  <?php
  require_once('./helpers/requesthelper.php');
  require_once('./helpers/registervalidation.php');
  $request = validateRequest();
  $data = $request['data'];
  $errors = $request['errors'];
  if (count($errors) == 0) {
    //insert new user into user table
    /*
    Open connection with mysql db
    execute insert statement
    Close connection
    */
    $conn = mysqli_connect('localhost', 'root', '', 'blog');
    if ($conn) {
      $SQL = "INSERT INTO users (id,name,username,password,email,phone) values (null,'" . $data['name'] . "','" . $data['username'] . "',md5('" . $data['password'] . "'),'" . $data['email'] . "','" . $data['phone'] . "')";
      if (mysqli_query($conn, $SQL)) {
        $last_id = mysqli_insert_id($conn);
        session_start();
        $_SESSION['user'] = [
          'id' => $last_id,
          'name' => $data['name'],
          'email' => $data['email'],
          'username' => $data['username'],
          'type'=>0
        ];
        //session
        //redirect to home page
        header('Location:index.php');
        die();
      } {
        $errors['generic'] = mysqli_error($conn);
      }

      mysqli_close($conn);
    }
  }
  ?>
  <?php require_once('layout/header.php'); ?>
  <section class="register">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <h1>Register form</h1>
          <form method="POST" action="register.php">
            <div class="row">
              <label class="col-md-4">Name:</label><input name="name" class="col-md-8 form-control" required value="<?= getData($data, 'name') ?>" />
              <?= isset($errors['name']) ? $errors['name'] : '' ?>
            </div>
            <div class="row">
              <label class="col-md-4">Username:</label> <input name="username" class="col-md-8 form-control" required value="<?= getData($data, 'username') ?>" />
              <?= isset($errors['username']) ? $errors['username'] : '' ?>
            </div>
            <div class="row">
              <label class="col-md-4">Password:</label> <input name="password" type="password" required class="col-md-8 form-control" />
              <?= isset($errors['password']) ? $errors['password'] : '' ?>
              <span class="text text-danger"><?= isset($errors['password_confirm']) ? $errors['password_confirm'] : '' ?></span>

            </div>
            <div class="row">
              <label class="col-md-4">Confirm Password:</label> <input name="confirm_password" required type="password" class="col-md-8 form-control" />
              <?= isset($errors['confirm_password']) ? $errors['confirm_password'] : '' ?>
            </div>
            <div class="row">
              <label class="col-md-4">E-mail:</label> <input name="email" type="email" required class="col-md-8 form-control" value="<?= getData($data, 'email') ?>" />
              <?= isset($errors['email']) ? $errors['email'] : '' ?>
            </div>
            <div class="row">
              <label class="col-md-4">Phone:</label> <input name="phone" class="col-md-8 form-control" value="<?= getData($data, 'phone') ?>" />
            </div>

            <span class="text text-danger"><?= isset($errors['generic']) ? $errors['generic'] : '' ?></span>

            <button class="btn btn-success btn-block">Register</button>
          </form>
        </div>
      </div>
    </div>
  </section>
  <?php require_once('layout/footer.php') ?>