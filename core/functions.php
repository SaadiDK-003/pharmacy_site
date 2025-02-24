<?php
function isLoggedIn()
{
      return isset($_SESSION['user']) ? true : false;
}


function login($POST)
{
      global $db;
      $msg = '';
      $email = $POST['email'];
      $pwd = md5($POST['password']);

      $checkUser = $db->query("SELECT * FROM `users` WHERE `email`='$email' AND `password`='$pwd'");

      if (mysqli_num_rows($checkUser) > 0) {
            $user = mysqli_fetch_object($checkUser);
            $_SESSION['user'] = $user->id;
            echo '<h5 class="text-center alert alert-success">Success, Redirecting...</h5> <script>setTimeout(function(){window.location.href = "index.php"},1800)</script>';
      } else {
            echo '<h5 class="text-center alert alert-danger">Please check your credentials.</h5>';
      }

      return $msg;
}


function register($POST)
{
      global $db;
      $username = $POST['username'];
      $email = $POST['email'];
      $pwd = $POST['password'];
      $role = $POST['role'];
      $phone = $POST['phone'];
      $dob = $POST['dob'];
      $addr = $POST['address'];
      $have_disease = $POST['have_disease'];
      $diseases = '';
      $experience = $POST['experience'];
      if ($have_disease == 'yes') {
            $diseases = $POST['diseases'];
      }
      if ($experience != '') {
            $experience = $POST['experience'];
      }

      $msg = '';
      if (checkEmailExists($email)) {
            $msg = '<h5 class="text-center alert alert-danger">Email already exists.</h5>';
      } else if (strlen($pwd) < 6) {
            $msg = '<h5 class="text-center alert alert-danger">Password must be greater than 6 characters.</h5>';
      } else {
            $pwd = md5($pwd);
            $db->query("INSERT INTO `users` (username,email,password,role,phone,dob,address,diseases,experience) VALUES('$username','$email','$pwd','$role','$phone','$dob','$addr','$diseases','$experience')");
            $msg = '<h5 class="text-center alert alert-success">Successfully Registered.</h5>
            <script>
                  setTimeout(function(){
                    window.location.href = "./login.php";
                  },1800);
            </script>
            ';
      }

      echo $msg;
}


function checkEmailExists($email)
{
      global $db;
      $checkEmailExist = $db->query("SELECT * FROM `users` WHERE `email`='$email'");
      if (mysqli_num_rows($checkEmailExist) > 0) {
            return true;
      } else {
            return false;
      }
}


function Update_Profile($POST)
{
      global $db;
      $id = $POST['usr_id'];
      $name = $POST['username'];
      $email = $POST['email'];
      $phone = $POST['phone'];
      $dob = $POST['dob'];
      $pwd = $POST['password'];
      $old_pwd = $POST['old_pwd'];
      $new_pwd = '';
      $diseases = $POST['diseases'];
      $addr = $POST['address'];

      if ($pwd != '') {
            $new_pwd = md5($pwd);
      } else {
            $new_pwd = $old_pwd;
      }

      $upd_user = $db->query("UPDATE `users` SET `username`='$name', `email`='$email', `phone`='$phone', `dob`='$dob', `password`='$new_pwd', `diseases`='$diseases', `address`='$addr' WHERE `id`='$id'");
      if ($upd_user) {
            echo '<h4 class="text-center alert alert-success">Updated Successfully.</h4>
            <script>
            setTimeout(function(){
                  window.location.href = "./edit_profile.php";
            },1800);
            </script>
            ';
      }
}
