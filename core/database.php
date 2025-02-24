<?php
session_start();
function env($value)
{
      $env = dirname(__DIR__, 1) . '/.env';
      $core = parse_ini_file($env);
      return $core[$value];
}
$tailwind = env("TAILWIND");
$alpineJs = env("ALPINE_JS");

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

$db = mysqli_connect(env("HOST"), env("USER"), env("PWD"), env("DB"));

if (isset($_SESSION['user'])):
      $userid = $_SESSION['user'];
      $userData = $db->query("SELECT * FROM `users` WHERE `id`='$userid'");
      if (mysqli_num_rows($userData) >  0):
            $GetUserData = mysqli_fetch_object($userData);
            $userName = $GetUserData->username;
            $userEmail = $GetUserData->email;
            $userPhone = $GetUserData->phone;
            $userDOB = $GetUserData->dob;
            $userAddr = $GetUserData->address;
            $userPwd = $GetUserData->password;
            $userDiseases = $GetUserData->diseases;
            $userRole = $GetUserData->role;
            $userStatus = $GetUserData->status;
      endif;
endif;

require_once 'functions.php';
