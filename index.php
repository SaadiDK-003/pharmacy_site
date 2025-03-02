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
                                          <a href="./medicines-list.php" class="btn btn-primary">Medicines List</a>
                                          <a href="./printMedicine.php" class="btn btn-secondary">Print List</a>
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

            <div class="container mt-4">
                  <div id="medicines-list" class="row">

                        <div class="col-12 mb-3">
                              <h2 class="text-center">Recently Added</h2>
                        </div>

                        <?php $q_med =  $db->query("CALL `medicines_list_recent`()");
                        if (mysqli_num_rows($q_med) > 0):
                              while ($list_m = mysqli_fetch_object($q_med)): ?>

                                    <div class="col-12 col-md-3 mb-3">
                                          <div class="content">
                                                <div class="image">
                                                      <img src="<?= $list_m->img ?>" alt="a" width="" height="">
                                                </div>
                                                <div class="text-wrapper position-relative">
                                                      <h5 class="btn btn-sm btn-secondary position-absolute"><?= $list_m->pharmacy_name ?></h5>
                                                      <h4 class="fw-bold"><?= $list_m->medicine_name ?></h4>
                                                      <div class="qty-price d-flex justify-content-between">
                                                            <span class="qty">Quantity: <strong><?= $list_m->quantity ?></strong></span>
                                                            <span class="price">Price: <strong>SR. <?= $list_m->price ?></strong></span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>

                        <?php endwhile;
                        endif;
                        $q_med->close();
                        $db->next_result(); ?>
                  </div>
            </div>
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