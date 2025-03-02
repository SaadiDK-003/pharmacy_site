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
                <!-- Add Medicines -->
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
            <!-- Show Added Medicines -->
            <div class="row mt-5">
                <div class="col-12">
                    <?php
                    if (isset($_POST['e_submit'])) {
                        update_medicine($_POST);
                    }
                    if (isset($_POST['e_img_submit'])) {
                        update_medicine_img($_POST, $_FILES);
                    }
                    ?>
                </div>
                <div class="col-12">
                    <table id="medicine" class="table table-striped table-bordered text-center align-middle">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>img</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Exp Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $q_med =  $db->query("CALL `medicines_list_by_user`($userid)");
                            if (mysqli_num_rows($q_med) > 0):
                                while ($list_m = mysqli_fetch_object($q_med)): ?>
                                    <tr>
                                        <td><?= $list_m->medicine_name ?></td>
                                        <td class="no-print">
                                            <img src="<?= $list_m->img ?>" alt="medicine_<?= $list_m->med_id ?>" width="60" height="60" class="mx-auto">
                                        </td>
                                        <td><?= $list_m->quantity ?></td>
                                        <td><?= $list_m->price ?></td>
                                        <td><?= $list_m->exp_date ?></td>
                                        <td>
                                            <!-- update content -->
                                            <a href="#!" data-id="<?= $list_m->id ?>" class="btn btn-sm btn-primary edit-med" data-bs-toggle="modal" data-bs-target="#editMedicine"><i class="fas fa-pencil"></i></a>
                                            <!-- update img -->
                                            <a href="#!" data-id="<?= $list_m->id ?>" class="btn btn-sm btn-primary edit-med-img" data-bs-toggle="modal" data-bs-target="#editMedicineImage"><i class="fas fa-image"></i></a>
                                            <a href="#!" data-id="<?= $list_m->id ?>" class="btn btn-sm btn-danger del-med" data-table="medicines" data-msg="Medicine"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                            <?php endwhile;
                            endif;
                            $q_med->close();
                            $db->next_result(); ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>img</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Exp Date</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </main>


    <!-- Edit Medicine Modal -->
    <div class="modal fade" id="editMedicine" tabindex="-1" aria-labelledby="editMedicineLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="upd_med_form" method="post">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editMedicineLabel">Updata Medicine Content</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="e_medicine_name" class="form-label">Name</label>
                                    <input type="text" name="e_medicine_name" id="e_medicine_name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="e_medicine_qty" class="form-label">Quantity</label>
                                    <input type="number" min="1" name="e_medicine_qty" id="e_medicine_qty" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="e_medicine_price" class="form-label">Price</label>
                                    <input type="number" min="1" name="e_medicine_price" id="e_medicine_price" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="e_medicine_exp" class="form-label">Expiry Date</label>
                                    <input type="date" name="e_medicine_exp" id="e_medicine_exp" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="hidden" name="med_id" id="med_id">
                        <input type="hidden" name="old_img" id="old_img" value="">
                        <button type="submit" name="e_submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Edit Medicine Image Modal -->
    <div class="modal fade" id="editMedicineImage" tabindex="-1" aria-labelledby="editMedicineImageLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <form id="upd_med_img_form" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editMedicineImageLabel">Updata Medicine Image</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="form-group">
                                    <label for="e_medicine_img" class="form-label">Picture</label>
                                    <input type="file" name="e_medicine_img" id="e_medicine_img" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="hidden" name="med_img_id" id="med_img_id">
                        <button type="submit" name="e_img_submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <?php include_once 'includes/footer.php'; ?>
    <?php include 'includes/external_js.php'; ?>

    <script>
        $(document).ready(function() {
            new DataTable('#medicine');

            $(document).on("click", ".edit-med", function(e) {
                e.preventDefault();
                let id = $(this).data("id");

                $.ajax({
                    url: "ajax/medicine.php",
                    method: "post",
                    data: {
                        med_id: id
                    },
                    success: function(response) {
                        let res = JSON.parse(response);
                        $("#med_id").val(res.mID);
                        $("#e_medicine_name").val(res.mName);
                        $("#e_medicine_qty").val(res.qty);
                        $("#e_medicine_price").val(res.price);
                        $("#e_medicine_exp").val(res.exp_date);
                        $("#old_img").val(res.img);
                    }
                });
            });

            $(document).on("click", ".edit-med-img", function(e) {
                e.preventDefault();
                let med_id = $(this).data("id");
                $("#med_img_id").val(med_id);
            });

            $(document).on("click", ".del-med", function(e) {
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