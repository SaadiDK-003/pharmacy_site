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
    <title><?= env("TITLE") ?> | Register</title>
    <?php include_once 'includes/external_css.php'; ?>
</head>

<body id="login">
    <div class="container mx-auto vh-100 d-flex align-items-center justify-content-center">
        <div class="row">
            <div class="col-12 text-center mb-3">
                <h1><span class="text-primary"><?= env("TITLE") ?></span> <span class="text-secondary">|</span> Register</h1>
            </div>
            <div class="col-12 col-md-6 mx-auto">
                <?php if (isset($_POST['submit'])): register($_POST);
                endif; ?>
                <form action="" method="post">
                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <div class="form-group">
                                <label for="username" class="form-label">Name</label>
                                <input type="text" name="username" id="username" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <div class="form-group">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="tel" name="phone" id="phone" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <div class="form-group">
                                <label for="dob" class="form-label">Date Of Birth</label>
                                <input type="date" name="dob" id="dob" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <div class="form-group">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <div class="form-group">
                                <label for="role" class="form-label fw-bold">Are you <span class="text-info">Patient</span> / <span class="text-primary">Pharmacist</span></label>
                                <select name="role" id="role" class="form-select" required>
                                    <option value="" selected hidden>Select Role</option>
                                    <option value="patient">Patient</option>
                                    <option value="pharmacist">Pharmacist</option>
                                </select>
                            </div>
                        </div>
                        <!-- Patient -->
                        <div id="patient" class="col-12 patient col-md-5 mb-3 d-none">
                            <div class="form-group">
                                <h6>You have any diseases?</h6>
                                <input type="radio" name="have_disease" id="yes" value="yes" class="btn-check" required>
                                <label for="yes" class="btn btn-outline-success">Yes</label>
                                <span class="d-inline-block mx-1"></span>
                                <input type="radio" name="have_disease" id="no" value="no" class="btn-check" required checked>
                                <label for="no" class="btn btn-outline-danger">No</label>
                            </div>
                        </div>
                        <div id="disease_wrapper" class="col-12 mb-3 d-none">
                            <div class="form-group">
                                <label for="diseases" class="form-label">Enter your Diseases here</label>
                                <input name="diseases" id="diseases" class="form-control">
                            </div>
                        </div>
                        <!-- Pharmacist -->
                        <div id="pharmacist" class="col-12 pharmacist d-none">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="experience" class="form-label">Years Of Experience</label>
                                        <input name="experience" id="experience" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="phar" class="form-label">Select Pharmacy</label>
                                        <select name="pharmacy" id="phar" class="form-select">
                                            <?= getAllPharmacies($db) ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" name="address" id="address" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group d-flex justify-content-between">
                                <a href="./login.php" class="btn btn-primary">Login</a>
                                <button type="submit" name="submit" class="btn btn-success">REGISTER</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include_once 'includes/external_js.php'; ?>

    <script>
        $(document).ready(function() {

            $(document).on('change', 'select[id="role"]', function(e) {
                e.preventDefault();
                let val = $(this).val();
                $('.patient, .pharmacist').addClass('d-none');
                $(`#${val}`).removeClass('d-none');

            });

            $(document).on('click', 'input[type=radio]', function(e) {
                let val = $(this).val();
                if (val == 'yes') {
                    $("#disease_wrapper").removeClass('d-none');
                } else {
                    $("#disease_wrapper").addClass('d-none');
                }
            });
        });
    </script>

</body>

</html>