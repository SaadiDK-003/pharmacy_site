<?php
$totalReminders = 0;
$currentTime = time();

$reminder_result = $db->query("SELECT reminder_time_morning, reminder_time_afternoon, reminder_time_evening, reminder_time_night FROM `reminder` WHERE `user_id`='$userid'");

if (mysqli_num_rows($reminder_result) > 0) {

    while ($row = $reminder_result->fetch_assoc()) {

        foreach (['reminder_time_morning', 'reminder_time_afternoon', 'reminder_time_evening', 'reminder_time_night'] as $timeField) {
            if (!empty($row[$timeField])) {
                $reminderTimeStr = $row[$timeField];

                list($hours, $minutes, $seconds) = explode(':', $reminderTimeStr);
                $reminderTimestamp = mktime($hours, $minutes, 0, date('m'), date('d'), date('Y'));

                $diffMinutes = ($reminderTimestamp - $currentTime) / 60;

                if ($diffMinutes > 0 && $diffMinutes <= $reminderThreshold) {
                    $totalReminders++;
                }
            }
        }
    }
}
