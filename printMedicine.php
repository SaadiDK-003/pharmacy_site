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
    <title><?= env("TITLE") ?></title>
    <?php include_once 'includes/external_css.php'; ?>
</head>

<body id="printMedicine">
    <?php include_once 'includes/header.php'; ?>
    <main>
        <div class="container mt-5">
            <div class="row">
                <div class="col-12">
                    <table id="example" class="table table-striped table-bordered text-center align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th class="no-print">Image</th>
                                <th>Quantity</th>
                                <th>Exp Date</th>
                                <th>Price</th>
                                <th>Pharmacist Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $q_med =  $db->query("CALL `medicines_list`()");
                            if (mysqli_num_rows($q_med) > 0):
                                while ($list_m = mysqli_fetch_object($q_med)): ?>
                                    <tr>
                                        <td><?= $list_m->medicine_name ?></td>
                                        <td class="no-print">
                                            <img src="<?= $list_m->img ?>" alt="medicine_<?= $list_m->med_id ?>" width="60" height="60" class="mx-auto">
                                        </td>
                                        <td><?= $list_m->quantity ?></td>
                                        <td><?= $list_m->exp_date ?></td>
                                        <td><?= $list_m->price ?></td>
                                        <td><?= $list_m->username ?></td>
                                    </tr>
                            <?php endwhile;
                            endif;
                            $q_med->close();
                            $db->next_result(); ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th class="no-print">Image</th>
                                <th>Quantity</th>
                                <th>Exp Date</th>
                                <th>Price</th>
                                <th>Pharmacist Name</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <?php include_once 'includes/footer.php'; ?>
    <?php include_once 'includes/external_js.php'; ?>
    <script>
        $(document).ready(function() {
            new DataTable('#example', {
                layout: {
                    topStart: {
                        buttons: [{
                                extend: 'print',
                                text: 'Print all',
                                exportOptions: {
                                    modifier: {
                                        selected: null
                                    },
                                    // columns: ':not(.no-print)'
                                    columns: [0, 2, 3, 4]
                                }
                            },
                            {
                                extend: 'print',
                                text: 'Print selected',
                                exportOptions: {
                                    columns: [0, 2, 3, 4]
                                }
                            }
                        ]
                    }
                },
                select: true
            });
        });
    </script>
</body>

</html>