<?php
require_once 'core/database.php';
// if (!isLoggedIn()) {
//       header('Location: login.php');
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title><?= env("TITLE") ?> | Home</title>
      <?php include_once 'includes/external_css.php'; ?>
</head>

<body id="home">
      <?php include_once 'includes/header.php'; ?>
      <main>
            <section class="hero d-flex align-items-center justify-content-center">
                  <div class="container">
                        <div class="row">
                              <div class="col-12 col-md-6">
                                    <div class="content text-white">
                                          <h1 class="ff_livvic"><?= env('TITLE') ?></h1>
                                          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos magnam omnis fuga provident quis obcaecati doloribus dolorum reprehenderit, quas veritatis!</p>
                                          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe pariatur odio esse consequuntur magni, perspiciatis a. Quibusdam quas voluptatum nisi, quis obcaecati quisquam iusto veniam.</p>
                                          <a href="#!" class="btn btn-primary">Demo Button</a>
                                    </div>
                              </div>
                              <div class="col-12 col-md-6">
                                    <div class="hero_slider owl-carousel">
                                          <div class="item">
                                                <img src="img/201-800x350.jpg" alt="img-1">
                                          </div>
                                          <div class="item">
                                                <img src="img/48-800x350.jpg" alt="img-2">
                                          </div>
                                          <div class="item">
                                                <img src="img/180-800x350.jpg" alt="img-3">
                                          </div>
                                    </div>
                              </div>
                        </div>
                  </div>
            </section>
      </main>
      <?php include_once 'includes/footer.php'; ?>
      <?php include_once 'includes/external_js.php'; ?>
      <script>
            $(document).ready(function() {
                  $('.hero_slider').owlCarousel({
                        loop: true,
                        margin: 10,
                        nav: false,
                        autoplay: true,
                        dots: false,
                        responsive: {
                              0: {
                                    items: 1
                              },
                              600: {
                                    items: 1
                              },
                              1000: {
                                    items: 1
                              }
                        }
                  })
            });
      </script>
</body>

</html>