<?php
require_once '../core/database.php';

if (isset($_POST['usr_id']) && isset($_POST['upd_status'])):
    $u_id = $_POST['usr_id'];
    $upd_status = $_POST['upd_status'];
    $table = $_POST['table'];
    $newPwd = '';
    $pwd = $_POST['password'];
    $old_pwd = $_POST['old_pwd'];

    if ($pwd != '') {
        $newPwd = md5($pwd);
    } else {
        $newPwd = $old_pwd;
    }

    try {
        $upd_user = $db->query("UPDATE `$table` SET `password`='$newPwd', `status`='$upd_status' WHERE `id`='$u_id'");

        if ($upd_user) {
            echo json_encode(["status" => "success", "msg" => "Updated Successfully."]);
        }
    } catch (\Throwable $th) {
        // $errorMsg = str_replace("'", "", $th->getMessage());
        echo json_encode(["status" => "error", "msg" => "Something went wrong!"]);
    }

endif;



if (isset($_POST['phr_id']) && isset($_POST['phr_msg']) && isset($_POST['phr_table'])):
    $phr_id = $_POST['phr_id'];
    $pharmacy_name = $_POST['upd_pharmacy_name'];
    $phr_msg = $_POST['phr_msg'];
    $table = $_POST['phr_table'];

    try {
        $upd_phr = $db->query("UPDATE `$tablea` SET `pharmacy_name`='$pharmacy_name' WHERE `id`='$phr_id'");

        if ($upd_phr) {
            echo json_encode(["status" => "success", "msg" => "Updated Successfully."]);
        }
    } catch (\Throwable $th) {
        echo json_encode(["status" => "error", "msg" => "Something went wrong!"]);
    }

endif;
