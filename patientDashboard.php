<?php
require_once 'core/database.php';
if (($userStatus == '0' && $userRole == 'patient') || $userRole != 'patient') {
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

            <div id="medicines-list" class="row mt-4">
                <div class="col-12 mb-3">
                    <h3>Medicine Intake List</h3>
                </div>
                <?php $q_med =  $db->query("CALL `get_user_reminder`($userid)");
                if (mysqli_num_rows($q_med) > 0):
                    while ($list_m = mysqli_fetch_object($q_med)): ?>

                        <div class="col-12 col-md-3 mb-3">
                            <div class="content position-relative">
                                <a href="#!" class="del-reminder btn btn-danger btn-sm rounded-circle position-absolute" data-id="<?= $list_m->reminder_id ?>" data-table="reminder" data-msg="Reminder">
                                    <i class="fas fa-trash"></i>
                                </a>
                                <div class="image">
                                    <img src="<?= $list_m->img ?>" alt="a" width="" height="">
                                </div>
                                <div class="text-wrapper position-relative">
                                    <h5 class="btn btn-sm btn-secondary position-absolute"><?= $list_m->phar_name ?></h5>
                                    <h4 class="fw-bold"><?= $list_m->medicine_name ?></h4>
                                    <div class="qty-price">
                                        <span class="btn btn-sm btn-success">Intake Time: <strong><?= date('h:i A', strtotime($list_m->reminder_time)) ?></strong></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endwhile;
                else: ?>
                    <div class="col-12">
                        <h4 class="alert alert-info">No Record Found.</h4>
                    </div>
                <?php
                endif;
                $q_med->close();
                $db->next_result(); ?>
            </div>
        </div>
    </main>

    <?php include_once 'includes/footer.php'; ?>
    <?php include 'includes/external_js.php'; ?>

    <script>
        $(document).ready(function() {
            $(document).on("click", ".del-reminder", function(e) {
                e.preventDefault();
                let id = $(this).data("id");
                let table = $(this).data("table");
                let msg = $(this).data("msg");
                $.ajax({
                    url: "ajax/delete.php",
                    method: "POST",
                    data: {
                        del_id: id,
                        del_table: table,
                        msg: msg
                    },
                    success: function(response) {
                        let res = JSON.parse(response);
                        if (res.status == 'success') {
                            $("#ToastDanger .toast-body").html(res.msg);
                            $("#ToastDanger").addClass("fade show");
                            setTimeout(() => {
                                window.location.reload();
                            }, 1200);
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>