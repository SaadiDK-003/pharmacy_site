<?php
require_once 'core/database.php';
if (isLoggedIn()) {
      header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title><?= env("TITLE") ?> | Login</title>
      <?php include_once 'includes/external_css.php'; ?>
</head>

<body id="login">
      <div class="container mx-auto vh-100 d-flex align-items-center justify-content-center">
            <div class="row">
                  <div class="col-12 text-center mb-3">
                        <h1><span class="text-primary"><?= env("TITLE") ?></span> <span class="text-secondary">|</span> LOGIN</h1>
                  </div>
                  <div class="col-12 col-md-4 mx-auto">
                        <?php if (isset($_POST['submit'])): login($_POST);
                        endif; ?>
                        <form action="" method="post">
                              <div class="row">
                                    <div class="col-12 mb-3">
                                          <div class="form-group">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" name="email" id="email" class="form-control" required>
                                          </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                          <div class="form-group">
                                                <label for="password" class="form-label">Password</label>
                                                <input type="password" name="password" id="password" class="form-control" required>
                                          </div>
                                    </div>
                                    <div class="col-12">
                                          <div class="form-group d-flex justify-content-end">
                                                <button type="submit" name="submit" class="btn btn-success">LOGIN</button>
                                          </div>
                                    </div>
                              </div>
                        </form>
                  </div>
            </div>
      </div>

      <?php include_once 'includes/external_js.php'; ?>

</body>

</html>