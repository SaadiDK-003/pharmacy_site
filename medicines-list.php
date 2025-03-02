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
        <div class="container my-5">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center">Medicines List</h1>
                </div>
            </div>
            <div id="medicines-list" class="row mt-4">

                <?php $q_med =  $db->query("CALL `medicines_list`()");
                if (mysqli_num_rows($q_med) > 0):
                    while ($list_m = mysqli_fetch_object($q_med)): ?>

                        <div class="col-12 col-md-3 mb-3">
                            <div class="content position-relative">
                                <?php if ($userRole == 'patient'): ?>
                                    <a href="#!" data-bs-toggle="modal" data-bs-target="#reminderModal" class="add-to-reminder btn btn-danger btn-sm rounded-circle position-absolute" data-med="<?= $list_m->med_id ?>" data-usr="<?= $userid ?>" data-phar="<?= $list_m->pharmacy_name ?>">
                                        <i class="fas fa-bell"></i>
                                    </a>
                                <?php endif; ?>
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


    <!-- Modal Add Reminder -->
    <div class="modal fade" id="reminderModal" tabindex="-1" aria-labelledby="reminderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="reminder_form">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="reminderModalLabel">Add Reminder</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-6 mb-3">
                                <label for="intake-time-mor" class="form-label">Intake Time Morning</label>
                                <input type="time" name="intake_time_mor" id="intake-time-mor" class="form-control">
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label for="intake-time-aft" class="form-label">Intake Time Afternoon</label>
                                <input type="time" name="intake_time_aft" id="intake-time-aft" class="form-control">
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label for="intake-time-eve" class="form-label">Intake Time Evening</label>
                                <input type="time" name="intake_time_eve" id="intake-time-eve" class="form-control">
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label for="intake-time-nig" class="form-label">Intake Time Night</label>
                                <input type="time" name="intake_time_nig" id="intake-time-nig" class="form-control">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="days" class="form-label">Select Days</label>
                                <select name="days[]" id="days" multiple class="form-select">
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                    <option value="Saturday">Saturday</option>
                                    <option value="Sunday">Sunday</option>
                                </select>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="check_all_days" class="form-check-label">All Days</label>
                                <input type="checkbox" name="all_days" id="check_all_days" value="all days" class="form-check-input">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="hidden" name="med_id" id="med_id">
                        <input type="hidden" name="phar_name" id="phar_name">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include_once 'includes/footer.php'; ?>
    <?php include_once 'includes/external_js.php'; ?>
    <script>
        $(document).ready(function() {
            $(document).on("click", ".add-to-reminder", function(e) {
                e.preventDefault();
                let med_id = $(this).data("med");
                let phar = $(this).data("phar");
                $("#med_id").val(med_id);
                $("#phar_name").val(phar);
            });

            $(document).on("submit", "#reminder_form", function(e) {
                e.preventDefault();
                let formData = $(this).serialize();
                $.ajax({
                    url: "ajax/reminder.php",
                    method: "POST",
                    data: formData,
                    success: function(response) {
                        let res = JSON.parse(response);
                        if (res.status == 'success') {
                            $("#ToastSuccess .toast-body").html(res.msg);
                            $("#ToastSuccess").addClass("fade show");
                            setTimeout(() => {
                                $("input[type='time']").val("");
                                $("#reminderModal").modal('hide');
                                $("#ToastSuccess").removeClass("fade show");
                            }, 1500);
                        } else {
                            $("#ToastDanger .toast-body").html(res.msg);
                            $("#ToastDanger").addClass("fade show");
                            setTimeout(() => {
                                $("input[type='time']").val("");
                                $("#reminderModal").modal('hide');
                                $("#ToastDanger").removeClass("fade show");
                            }, 1500);
                        }
                    }
                });
            });

            $(document).on("change", "#check_all_days", function(e) {
                e.preventDefault();
                if ($(this).is(":checked")) {
                    $("#days").attr("disabled", true).val("");
                } else {
                    $("#days").attr("disabled", false);
                }
            });
        });
    </script>
</body>

</html>