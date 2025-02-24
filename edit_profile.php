<?php
require_once 'core/database.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

if ($userRole != 'patient') {
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

<body id="edit_profile">
    <?php include_once 'includes/header.php'; ?>

    <main>
        <div class="container my-5">
            <div class="row">
                <div class="col-12 mb-4">
                    <h1 class="text-center">Edit Profile Page</h1>
                </div>
                <div class="col-6 mx-auto">
                    <?php if (isset($_POST['submit'])) {
                        Update_Profile($_POST);
                    } ?>
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label" for="username">Name</label>
                                    <input type="text" name="username" value="<?= $userName ?>" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" name="email" value="<?= $userEmail ?>" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label" for="phone">Phone</label>
                                    <input type="tel" name="phone" value="<?= $userPhone ?>" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label" for="dob">Date Of Birth</label>
                                    <input type="date" name="dob" value="<?= $userDOB ?>" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label" for="password">Password</label>
                                    <input type="password" name="password" class="form-control">
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label" for="diseases">Diseases</label>
                                    <input type="text" name="diseases" value="<?= $userDiseases ?? '' ?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label" for="address">Address</label>
                                    <input type="text" name="address" value="<?= $userAddr ?>" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-group d-flex justify-content-end">
                                    <input type="hidden" name="old_pwd" value="<?= $userPwd ?>">
                                    <input type="hidden" name="usr_id" value="<?= $userid ?>">
                                    <button type="submit" name="submit" class="btn btn-success">Update</button>
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