<?php

require_once '../core/database.php';

if (isset($_POST['med_id'])):
    $medID = $_POST['med_id'];

    $Q_med = $db->query("SELECT * FROM `medicines` WHERE `id`='$medID'");

    $med_data = mysqli_fetch_object($Q_med);

    $arr = [
        "mID" => $med_data->id,
        "mName" => $med_data->medicine_name,
        "qty" => $med_data->quantity,
        "price" => $med_data->price,
        "img" => $med_data->img,
        "exp_date" => $med_data->exp_date
    ];

    echo json_encode($arr);

endif;
