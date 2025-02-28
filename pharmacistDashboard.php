<?php
require_once 'core/database.php';
if (($userStatus == '0' && $userRole == 'pharmacist') || $userRole != 'pharmacist') {
    header('Location: index.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= env('TITLE') ?></title>
    <?php include 'includes/external_css.php'; ?>
    <link rel="stylesheet" href="css/style.min.css">
</head>

<body id="patientDashboard">
    <?php include_once 'includes/header.php'; ?>

    <main>
        <div class="container my-5">
            <div class="row">
                <div class="col-12 d-flex justify-content-end">
                    <a href="./edit_profile.php" class="btn btn-primary">Edit Profile</a>
                </div>
            </div>
            <div class="row">
                <div class="col-8 mx-auto my-3">
                    <h3 class="text-center">Add Medicine</h3>
                    <?php
                    if (isset($_POST['submit'])):
                        addMedicine($_POST, $_FILES, $userid);
                    endif;
                    ?>
                </div>
                <div class="col-12 col-md-6 mx-auto">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-12 col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="medicine_name" class="form-label">Name</label>
                                    <input type="text" name="medicine_name" id="medicine_name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-3 mb-3">
                                <div class="form-group">
                                    <label for="medicine_qty" class="form-label">Quantity</label>
                                    <input type="number" min="1" name="medicine_qty" id="medicine_qty" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-3 mb-3">
                                <div class="form-group">
                                    <label for="medicine_price" class="form-label">Price</label>
                                    <input type="number" min="1" name="medicine_price" id="medicine_price" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="medicine_exp" class="form-label">Expiry Date</label>
                                    <input type="date" name="medicine_exp" id="medicine_exp" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="medicine_img" class="form-label">Picture</label>
                                    <input type="file" name="medicine_img" id="medicine_img" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="form-group d-flex justify-content-end">
                                    <button type="submit" name="submit" class="btn btn-success">Add Medicine</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <?php include_once 'includes/footer.php'; ?>
    <?php include 'includes/external_js.php'; ?>

    <script>
        $(document).ready(function() {

        });
    </script>
</body>

</html>