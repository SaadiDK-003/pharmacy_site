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
                    <table id="example" class="table table-striped table-bordered text-center align-middle"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="no-print text-center">Image</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Exp Date</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Pharmacy Name</th>
                                <th class="text-center">Pharmacist Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $q_med = $db->query("CALL `medicines_list`()");
                            if (mysqli_num_rows($q_med) > 0):
                                while ($list_m = mysqli_fetch_object($q_med)): ?>
                                    <tr>
                                        <td class="text-center"><?= $list_m->medicine_name ?></td>
                                        <td class="no-print text-center">
                                            <img src="<?= $list_m->img ?>" alt="medicine_<?= $list_m->med_id ?>" width="60"
                                                height="60" class="mx-auto">
                                        </td>
                                        <td class="text-center"><?= $list_m->quantity ?></td>
                                        <td class="text-center"><?= $list_m->exp_date ?></td>
                                        <td class="text-center"><?= $list_m->price ?></td>
                                        <td class="text-center"><?= $list_m->pharmacy_name ?></td>
                                        <td class="text-center"><?= $list_m->username ?></td>
                                    </tr>
                                <?php endwhile;
                            endif;
                            $q_med->close();
                            $db->next_result(); ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="no-print text-center">Image</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Exp Date</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Pharmacist Name</th>
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
        $(document).ready(function () {
            let options = '';
            <?php if ($userRole != 'patient'): ?>
                options = {
                    ordering: false,
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
                                    columns: [0, 2, 3, 4, 5]
                                }
                            },
                            {
                                extend: 'print',
                                text: 'Print selected',
                                exportOptions: {
                                    columns: [0, 2, 3, 4, 5]
                                }
                            }
                            ]
                        }
                    },
                    select: true
                }
            <?php else: ?>
                options = [];
            <?php endif; ?>
            new DataTable('#example', options);
        });
    </script>
</body>

</html>