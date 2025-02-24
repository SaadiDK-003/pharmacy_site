<?php

require_once '../core/database.php';

if (isset($_POST['pharmacy_name'])):

    $pharmacy_name = $_POST['pharmacy_name'];

    $add_pharmacy = $db->query("INSERT INTO `pharmacy` (pharmacy_name) VALUES('$pharmacy_name')");

    if ($add_pharmacy) {
        echo json_encode(["status" => "success", "msg" => "Pharmacy added successfully."]);
    } else {
        echo json_encode(["status" => "error", "msg" => "Something went wrong!"]);
    }
endif;
