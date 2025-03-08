<?php
session_start();
function env($value)
{
      $env = dirname(__DIR__, 1) . '/.env';
      $core = parse_ini_file($env);
      return $core[$value];
}
error_reporting((int) env("ERROR_REPORT"));
$tailwind = env("TAILWIND");
$alpineJs = env("ALPINE_JS");
$reminderThreshold = env("REMINDER_TIME");

date_default_timezone_set("Asia/Karachi");

// default
$userName = '';
$userEmail = '';
$userRole = '';
$userPhone = '';
$userDOB = '';
$userAddr = '';
$userPwd = '';
$userDiseases = '';
$userStatus = '';
$yearsOfExperience = '';
$phar_id = '';

$db = mysqli_connect(env("HOST"), env("USER"), env("PWD"), env("DB"));

if (isset($_SESSION['user'])):
      $userid = $_SESSION['user'];
      $userData = $db->query("SELECT * FROM `users` WHERE `id`='$userid'");
      if (mysqli_num_rows($userData) > 0):
            $GetUserData = mysqli_fetch_object($userData);
            $userName = $GetUserData->username;
            $userEmail = $GetUserData->email;
            $userPhone = $GetUserData->phone;
            $userDOB = $GetUserData->dob;
            $userAddr = $GetUserData->address;
            $userPwd = $GetUserData->password;
            $userDiseases = $GetUserData->diseases;
            $yearsOfExperience = $GetUserData->experience;
            $phar_id = $GetUserData->phar_id;
            $userRole = $GetUserData->role;
            $userStatus = $GetUserData->status;

            $Q_get_phar_name = $db->query("SELECT `pharmacy_name` FROM `pharmacy` WHERE `id`='$phar_id'");
            $getPhar = mysqli_fetch_object($Q_get_phar_name);
      endif;
endif;

require_once 'functions.php';
