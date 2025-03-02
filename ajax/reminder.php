<?php

require_once '../core/database.php';

if (isset($_POST['med_id']) && isset($_POST['intake_time_mor'])):

    $msg = '';
    $days = '';
    $medID = $_POST['med_id'];
    $Mor_time = $_POST['intake_time_mor'] == "" ? null : $_POST['intake_time_mor'];
    $Aft_time = $_POST['intake_time_aft'] == "" ? null : $_POST['intake_time_aft'];
    $Eve_time = $_POST['intake_time_eve'] == "" ? null : $_POST['intake_time_eve'];
    $Nig_time = $_POST['intake_time_nig'] == "" ? null : $_POST['intake_time_nig'];
    $all_days = $_POST['all_days'];

    if ($all_days == ''):
        $days = implode(',', $_POST['days']);
    else:
        $days = $all_days;
    endif;
    $phar_name = $_POST['phar_name'];

    $checkExists = $db->query("SELECT `med_id` FROM `reminder` WHERE `med_id`='$medID'");

    if (mysqli_num_rows($checkExists) > 0) :
        $msg = json_encode(["status" => "error", "msg" => "Already added, check your Dashboard."]);
    else:
        $ins_ = $db->query("INSERT INTO `reminder` (user_id,med_id,phar_name,reminder_time_morning,reminder_time_afternoon,reminder_time_evening,reminder_time_night,days) VALUES('$userid','$medID','$phar_name','$Mor_time','$Aft_time','$Eve_time','$Nig_time','$days')");

        if ($ins_) {
            $msg = json_encode(["status" => "success", "msg" => "Reminder Added Successfully."]);
        } else {
            $msg = json_encode(["status" => "error", "msg" => "Something went wrong!"]);
        }
    endif;

    echo $msg;
endif;
