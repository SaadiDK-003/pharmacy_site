<?php
require_once 'core/database.php';
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

<body id="patientDashboard">
    <?php include_once 'includes/header.php'; ?>

    <main>
        <div class="container my-5">
            <div class="row">
                <div class="col-12 d-flex justify-content-end">
                    <a href="./edit_profile.php" class="btn btn-primary">Edit Profile</a>
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