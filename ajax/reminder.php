<?php

require_once '../core/database.php';

if (isset($_POST['med_id']) && isset($_POST['intake_time'])):
    $msg = '';
    $medID = $_POST['med_id'];
    $time = $_POST['intake_time'];
    $phar_name = $_POST['phar_name'];

    $checkExists = $db->query("SELECT `med_id` FROM `reminder` WHERE `med_id`='$medID'");

    if (mysqli_num_rows($checkExists) > 0) :
        $msg = json_encode(["status" => "error", "msg" => "Already added, check your Dashboard."]);
    else:
        $ins_ = $db->query("INSERT INTO `reminder` (user_id,med_id,phar_name,reminder_time) VALUES('$userid','$medID','$phar_name','$time')");

        if ($ins_) {
            $msg = json_encode(["status" => "success", "msg" => "Reminder Added Successfully."]);
        } else {
            $msg = json_encode(["status" => "error", "msg" => "Something went wrong!"]);
        }
    endif;

    echo $msg;
endif;
