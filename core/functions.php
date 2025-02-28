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
      $pharmacy_id = $POST['pharmacy'];
      $diseases = '';
      $experience = $POST['experience'];
      if ($have_disease == 'yes') {
            $diseases = $POST['diseases'];
      }
      if ($experience != '') {
            $experience = $POST['experience'];
      }
      if ($pharmacy_id != '') {
            $pharmacy_id = $POST['pharmacy'];
      }

      $msg = '';
      if (checkEmailExists($email)) {
            $msg = '<h5 class="text-center alert alert-danger">Email already exists.</h5>';
      } else if (strlen($pwd) < 6) {
            $msg = '<h5 class="text-center alert alert-danger">Password must be greater than 6 characters.</h5>';
      } else {
            $pwd = md5($pwd);
            $db->query("INSERT INTO `users` (username,email,password,role,phone,dob,address,diseases,experience,phar_id) VALUES('$username','$email','$pwd','$role','$phone','$dob','$addr','$diseases','$experience','$pharmacy_id')");
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


function Update_Profile($POST, $role)
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
      $experience = '';
      $diseases = '';
      $pharmacy_id = 999;
      $addr = $POST['address'];

      if ($pwd != '') {
            $new_pwd = md5($pwd);
      } else {
            $new_pwd = $old_pwd;
      }

      if ($role == 'pharmacist') {
            $experience = $POST['experience'];
            $pharmacy_id = $POST['pharmacy_id'];
      } else {
            $diseases = $POST['diseases'];
      }

      $upd_user = $db->query("UPDATE `users` SET `username`='$name', `email`='$email', `phone`='$phone', `dob`='$dob', `password`='$new_pwd', `diseases`='$diseases',`experience`='$experience', `phar_id`='$pharmacy_id', `address`='$addr' WHERE `id`='$id'");
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

function getAllPharmacies($db)
{
      $Q_phar = $db->query("CALL `get_all_pharmacy`()");
      if (mysqli_num_rows($Q_phar) > 0) {
            while ($phar = mysqli_fetch_object($Q_phar)):
                  echo '<option value="' . $phar->id . '">' . $phar->pharmacy_name . '</option>';
            endwhile;
      } else {
            echo '<option value="">No Record.</option>';
      }
}


function addMedicine($POST, $id)
{
      global $db;
      $name = $POST['medicine_name'];
      $qty = $POST['medicine_qty'];
      $exp = $POST['medicine_exp'];
      $msg = '';
      try {
            $add_med = $db->query("INSERT INTO `medicines` (medicine_name,quantity,exp_date,phar_id) VALUES('$name','$qty','$exp','$id')");
            if ($add_med) {
                  $msg = '<h4 class="alert alert-success text-center">Medicine has been added.</h4>
                  <script>
                        setTimeout(function(){
                              window.location.href = "./pharmacistDashboard.php";
                        },1800);
                  </script>
                  ';
            }
      } catch (\Throwable $th) {
            $msg = '<h4 class="alert alert-danger">' . $th->getMessage() . '</h4>';
      }
      echo $msg;
}
