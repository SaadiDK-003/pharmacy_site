<?php
session_start();
function env($value)
{
      $env = dirname(__DIR__, 1) . '/.env';
      $core = parse_ini_file($env);
      return $core[$value];
}
$db = mysqli_connect(env("HOST"), env("USER"), env("PWD"), env("DB"));
$tailwind = env("TAILWIND");
$alpineJs = env("ALPINE_JS");

require_once 'functions.php';


