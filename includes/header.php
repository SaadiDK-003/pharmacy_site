<header class="d-flex align-items-center">
      <div class="container d-flex align-items-center justify-content-between">
            <h3 class="ff_livvic text-white"><?= env("TITLE") ?></h3>
            <div class="buttons-wrapper d-flex gap-3">
                  <?php if (isLoggedIn()): ?>
                        <a href="#!dashboard.php" class="btn btn-primary">Dashboard</a>
                        <a href="./logout.php" class="btn btn-danger">Logout</a>
                  <?php else: ?>
                        <a href="./login.php" class="btn btn-success">Login</a>
                        <a href="./register.php" class="btn btn-primary">Register</a>
                  <?php endif; ?>
            </div>
      </div>
</header>