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

                        <div class="col-12 col-md-4 mb-3">
                            <div class="content position-relative">
                                <a href="#!" class="del-reminder btn btn-danger btn-sm rounded-circle position-absolute" data-id="<?= $list_m->reminder_id ?>" data-table="reminder" data-msg="Reminder">
                                    <i class="fas fa-trash"></i>
                                </a>
                                <div class="image">
                                    <img src="<?= $list_m->img ?>" alt="a" width="" height="">
                                </div>
                                <div class="text-wrapper">
                                    <div class="top-section d-flex align-items-center justify-content-between">
                                        <h4 class="fw-bold"><?= $list_m->medicine_name ?></h4>
                                        <h5 class="btn btn-sm btn-secondary"><?= $list_m->phar_name ?></h5>
                                    </div>
                                    <hr>
                                    <h6>Medicine to take <strong>Days</strong>:</h6>
                                    <div class="days d-flex gap-2">
                                        <?php $days_arr = explode(',', $list_m->days);
                                        foreach ($days_arr as $value) {
                                            echo '<span class="btn btn-sm btn-success">' . $value . '</span>';
                                        }
                                        ?>
                                    </div>
                                    <div class="qty-price d-grid mt-3 gap-2" title="it's time to take this medicine">
                                        <h6>Medicine <strong>Intake Timing</strong>:</h6>
                                        <?php if ($list_m->morning_time != NULL && $list_m->morning_time != "00:00:00"): ?>
                                            <span class="btn btn-sm btn-success">Morning Time: <strong><span class="reminder_time"><?= date('h:i A', strtotime($list_m->morning_time)) ?></span></strong></span>
                                        <?php endif; ?>

                                        <?php if ($list_m->afternoon_time != NULL && $list_m->afternoon_time != "00:00:00"): ?>
                                            <span class="btn btn-sm btn-success">Afternoon Time: <strong><span class="reminder_time"><?= date('h:i A', strtotime($list_m->afternoon_time)) ?></span></strong></span>
                                        <?php endif; ?>

                                        <?php if ($list_m->evening_time != NULL && $list_m->evening_time != "00:00:00"): ?>
                                            <span class="btn btn-sm btn-success">Evening Time: <strong><span class="reminder_time"><?= date('h:i A', strtotime($list_m->evening_time)) ?></span></strong></span>
                                        <?php endif; ?>

                                        <?php if ($list_m->night_time != NULL && $list_m->night_time != "00:00:00"): ?>
                                            <span class="btn btn-sm btn-success">Night Time: <strong><span class="reminder_time"><?= date('h:i A', strtotime($list_m->night_time)) ?></span></strong></span>
                                        <?php endif; ?>

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

            // Medicine Reminder Alert Work
            let all_reminders = $("#medicines-list").find(".reminder_time");
            all_reminders.each((i, e) => {

                let reminderTimeStr = $(e).html().trim();
                let currentTime = new Date();
                let reminderTime = new Date();
                let timeParts = reminderTimeStr.match(/(\d+):(\d+) (\wM)/);

                if (timeParts) {
                    let hours = parseInt(timeParts[1], 10);
                    let minutes = parseInt(timeParts[2], 10);
                    let ampm = timeParts[3];

                    if (ampm === "PM" && hours !== 12) hours += 12;
                    if (ampm === "AM" && hours === 12) hours = 0;

                    reminderTime.setHours(hours, minutes, 0, 0);
                }
                let diffMinutes = (reminderTime - currentTime) / 60000;
                console.log(diffMinutes)
                if (diffMinutes > 0 && diffMinutes <= <?= $reminderTime ?>) {
                    $(e).parents('.qty-price').addClass("highlight");
                    $(e).parent().parent().addClass('btn-danger');
                }

            });
        });
    </script>
</body>

</html>