<header class="d-flex align-items-center">
      <div class="container d-flex align-items-center justify-content-between">
            <a class="text-decoration-none" href="./"><h3 class="ff_livvic text-white"><?= env("TITLE") ?></h3></a>
            <div class="buttons-wrapper d-flex gap-3">
                  <?php if (isLoggedIn()): ?>
                        <?php if ($userRole == 'admin'): ?>
                              <a href="./adminDashboard.php" class="btn btn-primary">Dashboard</a>
                        <?php elseif ($userRole == 'patient'): ?>
                              <a href="./patientDashboard.php" class="btn btn-primary">Dashboard</a>
                        <?php endif; ?>
                        <a href="./logout.php" class="btn btn-danger">Logout</a>
                  <?php else: ?>
                        <a href="./login.php" class="btn btn-success">Login</a>
                        <a href="./register.php" class="btn btn-primary">Register</a>
                  <?php endif; ?>
            </div>
      </div>
</header>