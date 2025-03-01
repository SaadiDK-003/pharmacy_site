<?php
require_once 'core/database.php';
if (!isLoggedIn()) {
    header('Location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= env("TITLE") ?> | Medicines List</title>
    <?php include_once 'includes/external_css.php'; ?>
</head>

<body id="medicines_list">
    <?php include_once 'includes/header.php'; ?>
    <main>
        <div class="container mt-5">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center">Medicines List</h1>
                </div>
            </div>
            <div id="medicines-list" class="row mt-4">

                <?php $q_med =  $db->query("CALL `medicines_list`()");
                if (mysqli_num_rows($q_med) > 0):
                    while ($list_m = mysqli_fetch_object($q_med)): ?>

                        <div class="col-12 col-md-3">
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
        $(document).ready(function() {});
    </script>
</body>

</html>