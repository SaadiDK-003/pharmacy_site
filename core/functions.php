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


function Update_Profile(array $POST, string $role)
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


function addMedicine($POST, $FILE, $id)
{
      $targetDir = './img/medicine/';

      global $db;
      $name = $POST['medicine_name'];
      $qty = $POST['medicine_qty'];
      $exp = $POST['medicine_exp'];
      $price = $POST['medicine_price'];
      $msg = '';
      try {

            if (!empty($FILE["medicine_img"]["name"])) {

                  $fileName = basename($FILE["medicine_img"]["name"]);
                  $targetFilePath = $targetDir . $fileName;
                  $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

                  //allow certain file formats
                  $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'webp');
                  if (in_array($fileType, $allowTypes)) {
                        //upload file to server
                        if (move_uploaded_file($FILE["medicine_img"]["tmp_name"], $targetFilePath)) {

                              $add_med = $db->query("INSERT INTO `medicines` (medicine_name,quantity,exp_date,price,img,user_id) VALUES('$name','$qty','$exp','$price','$targetFilePath','$id')");
                              if ($add_med) {
                                    $msg = '<h4 class="alert alert-success text-center">Medicine has been added.</h4>
                                    <script>
                                          setTimeout(function(){
                                                window.location.href = "./pharmacistDashboard.php";
                                          },1800);
                                    </script>
                                    ';
                              }
                        } else {
                              $msg = "Sorry, there was an error uploading your file.";
                        }
                  } else {
                        $msg = '<h6 class="alert alert-danger w-75 text-center mx-auto">Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload.</h6>';
                  }
            } else {

                  $msg = '<h6 class="alert alert-success w-50 text-center mx-auto">Please select a file to upload.</h6>';
            }
      } catch (\Throwable $th) {
            $msg = '<h4 class="alert alert-danger">' . $th->getMessage() . '</h4>';
      }
      echo $msg;
}


function update_medicine($POST, $FILE)
{

      if (!empty($FILE['e_medicine_img']['name'])) {
            echo 'has file';
      } else {
            echo 'no file';
      }
}
