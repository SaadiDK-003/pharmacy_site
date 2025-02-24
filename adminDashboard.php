<?php
require_once 'core/database.php';
if ($userRole != 'admin') {
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

<body id="adminDashboard">
    <?php include_once 'includes/header.php'; ?>

    <main>
        <section class="tabs-section">
            <div class="container mt-5 mx-auto">
                <div class="row">
                    <div class="col-6 mx-auto">
                        <div class="btns_wrapper d-flex justify-content-center gap-2">
                            <a href="#!" class="btn btn-primary">View All Users</a>
                            <a href="#!" class="btn btn-primary">Add Pharmacy</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="tabs-content" class="container">
                <!-- List of All Users -->
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6 mx-auto">
                                <?php
                                $get_users_list = $db->query("CALL `get_all_users`()");
                                if (mysqli_num_rows($get_users_list) > 0):
                                ?>
                                    <table id="example" class="table table-striped table-bordered text-center align-middle" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            while ($list_user = mysqli_fetch_object($get_users_list)):
                                            ?>
                                                <tr>
                                                    <td><?= $list_user->id ?></td>
                                                    <td><?= $list_user->username ?></td>
                                                    <td><?= $list_user->status ?></td>
                                                    <td><a href="#!" class="btn btn-sm btn-primary btn-usr-edit" data-id="<?= $list_user->id ?>" data-table="categories"><i class="fas fa-pencil"></i></a>
                                                        <a href="#!" class="btn btn-sm btn-danger btn-del" data-id="<?= $list_user->id ?>" data-msg="User" data-table="users"><i class="fas fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                <?php else: ?>
                                    <h3 class="alert alert-info text-center">No Record Found For Users.</h3>
                                <?php
                                endif;
                                $get_users_list->close();
                                $db->next_result();
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="show_pharmacy" class="col-12 mt-5 d-none">
                    <div class="row">
                        <div class="col-3 mx-auto">
                            <form id="add_pharmacy">
                                <div class="form-group">
                                    <label for="pharmacy_name">Pharmacy Name</label>
                                    <input type="text" name="pharmacy_name" id="pharmacy_name" required class="form-control">
                                </div>
                                <div class="form-group mt-3 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-6 mx-auto">
                            <?php $get_Pharmacy = $db->query("CALL `get_all_pharmacy`()");
                            if (mysqli_num_rows($get_Pharmacy) > 0):
                            ?>
                                <table class="table table-striped table-bordered text-center align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Pharmacy Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($list_p = mysqli_fetch_object($get_Pharmacy)): ?>
                                            <tr>
                                                <td><?= $list_p->id ?></td>
                                                <td><?= $list_p->pharmacy_name ?></td>
                                                <td><a href="#!" class="btn btn-danger btn-del" data-id="<?= $list_p->id ?>" data-msg="Pharmacy" data-table="pharmacy"><i class="fas fa-trash"></i></a></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <h3 class="text-center alert alert-info">No Pharmacy Record Found.</h3>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include_once 'includes/footer.php'; ?>
    <?php include 'includes/external_js.php'; ?>

    <script>
        $(document).ready(function() {

            $(document).on('click', '.btns_wrapper a', function(e) {
                e.preventDefault();
                let index = $(this).index() + 1;

                $(`#tabs-content > div:nth-child(${index})`).removeClass('d-none').siblings().addClass('d-none');
            });
            // Tabs Selection
            $(document).on('click', '#tabs-buttons a', function(e) {
                if ($(this).hasClass('current-page')) {
                    e.preventDefault();
                    let index = $(this).index() + 1;
                    $(this).addClass('active').siblings().removeClass('active');
                    $(`#tabs-content > div:nth-child(${index})`).removeClass('d-none').siblings().addClass('d-none');
                }
            });

            // Add Category
            $("#add_pharmacy").on("submit", function(e) {
                e.preventDefault();
                let formData = $(this).serialize();

                $.ajax({
                    url: "ajax/pharmacy.php",
                    method: "post",
                    data: formData,
                    success: function(response) {
                        let res = JSON.parse(response);
                        $("#ToastSuccess").addClass("fade show");
                        $("#ToastSuccess .toast-body").html(res.msg);
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    }
                });
            });

            // Del Category
            $(document).on("click", ".btn-del", function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                let table = $(this).data('table');
                let msg = $(this).data('msg');

                $.ajax({
                    url: "ajax/delete.php",
                    method: "post",
                    data: {
                        del_id: id,
                        del_table: table,
                        msg: msg
                    },
                    success: function(response) {
                        console.log(response);

                        let res = JSON.parse(response);
                        $('#ToastDanger').addClass('fade show');
                        $("#ToastDanger .toast-body").html(res.msg);
                        setTimeout(() => {
                            window.location.reload();
                        }, 1800);
                    }
                });
            });

        });
    </script>
</body>

</html>