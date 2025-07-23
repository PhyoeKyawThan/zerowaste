<?php
session_start();
error_reporting(0);
include("connection/connect.php");

if (isset($_POST['submit'])) {
   if (
      empty($_POST['firstname']) ||
      empty($_POST['lastname']) ||
      empty($_POST['email']) ||
      empty($_POST['phone']) ||
      empty($_POST['password']) ||
      empty($_POST['cpassword'])
   ) {
      $message = "All fields must be Required!";
   } else {
      $check_username = mysqli_query($db, "SELECT username FROM users where username = '" . $_POST['username'] . "' ");
      $check_email = mysqli_query($db, "SELECT email FROM users where email = '" . $_POST['email'] . "' ");

      if ($_POST['password'] != $_POST['cpassword']) {
         $message = "Password not match";
      } elseif (strlen($_POST['password']) < 6) {
         $message = "Password Must be at least 6 characters";
      } elseif (strlen($_POST['phone']) < 10) {
         $message = "Invalid phone number!";
      } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
         $message = "Invalid email address please type a valid email!";
      } elseif (mysqli_num_rows($check_username) > 0) {
         $message = "Username Already exists!";
      } elseif (mysqli_num_rows($check_email) > 0) {
         $message = "Email Already exists!";
      } else {
         $mql = "INSERT INTO users(username,f_name,l_name,email,phone,password,address,role) VALUES('" . $_POST['username'] . "','" . $_POST['firstname'] . "','" . $_POST['lastname'] . "','" . $_POST['email'] . "','" . $_POST['phone'] . "','" . md5($_POST['password']) . "','" . $_POST['address'] . "','" . $_POST['role'] . "')";
         mysqli_query($db, $mql);
         header("refresh:0.1;url=login.php");
      }
   }
}
$title = "Registeration";
include 'parts/start.php';
?>
<style>
   body {
      background-image: url('images/img/pimg.jpg');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
   }

   .headrom {
      /* padding-top: 15px; */
      padding-bottom: 15px;
   }

   .registration-wrapper {
      flex: 1;
      display: flex;
      align-items: center;
      padding: 40px 0;
   }

   .registration-container {
      background-color: rgba(255, 255, 255, 0.95);
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      padding: 40px;
      width: 100%;
      max-width: 800px;
      margin: 50px auto;
   }

   .form-control {
      height: 45px;
      border-radius: 5px;
      border: 1px solid #ddd;
      padding-left: 15px;
      margin-bottom: 15px;
   }

   .form-control:focus {
      border-color: #f30;
      box-shadow: 0 0 0 0.2rem rgba(243, 0, 0, 0.25);
   }

   .btn-theme {
      background-color: #f30;
      color: white;
      border: none;
      padding: 12px 30px;
      font-weight: 600;
      transition: all 0.3s;
      border-radius: 5px;
      font-size: 16px;
      width: 100%;
      max-width: 200px;
   }

   .btn-theme:hover {
      background-color: #d20;
      transform: translateY(-2px);
   }

   .error-message {
      color: #f30;
      margin-bottom: 20px;
      text-align: center;
      font-weight: 500;
      padding: 10px;
      background-color: rgba(243, 0, 0, 0.1);
      border-radius: 5px;
   }

   .page-title {
      text-align: center;
      margin-bottom: 30px;
      color: #333;
      font-weight: 700;
      font-size: 28px;
   }

   label {
      font-weight: 500;
      margin-bottom: 5px;
      color: #555;
      display: block;
   }

   textarea.form-control {
      min-height: 100px;
   }

   .login-link {
      text-align: center;
      margin-top: 20px;
      color: #666;
   }

   .login-link a {
      color: #f30;
      font-weight: 500;
   }

   @media (max-width: 768px) {
      .registration-container {
         padding: 30px 20px;
      }

      .page-title {
         font-size: 24px;
      }
   }
</style>
<div class="registration-wrapper">
   <div class="container">
      <div class="row justify-content-center">
         <div class="col-12">
            <div class="registration-container">
               <h2 class="page-title">Create Your Account</h2>

               <?php if (isset($message)) { ?>
                  <div class="error-message"><?php echo $message; ?></div>
               <?php } ?>

               <form action="" method="post">
                  <div class="row">
                     <div class="form-group col-md-12">
                        <label for="username">Username</label>
                        <input class="form-control" type="text" name="username" id="username"
                           placeholder="Enter your username" required>
                     </div>
                     <div class="form-group col-md-6">
                        <label for="role">Register As</label>
                        <select name="role" class="form-control" required>
                           <option value="user">Regular User</option>
                           <option value="shop">Restaurant Owner</option>
                        </select>
                     </div>
                     <div class="form-group col-md-6">
                        <label for="firstname">First Name</label>
                        <input class="form-control" type="text" name="firstname" id="firstname"
                           placeholder="Enter your first name" required>
                     </div>
                     <div class="form-group col-md-6">
                        <label for="lastname">Last Name</label>
                        <input class="form-control" type="text" name="lastname" id="lastname"
                           placeholder="Enter your last name" required>
                     </div>
                     <div class="form-group col-md-6">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email"
                           required>
                     </div>
                     <div class="form-group col-md-6">
                        <label for="phone">Phone Number</label>
                        <input class="form-control" type="tel" name="phone" id="phone"
                           placeholder="Enter your phone number" required>
                     </div>
                     <div class="form-group col-md-6">
                        <label for="password">Password (min 6 characters)</label>
                        <input type="password" class="form-control" name="password" id="password"
                           placeholder="Create a password" required>
                     </div>
                     <div class="form-group col-md-6">
                        <label for="cpassword">Confirm Password</label>
                        <input type="password" class="form-control" name="cpassword" id="cpassword"
                           placeholder="Confirm your password" required>
                     </div>
                     <div class="form-group col-md-12">
                        <label for="address">Delivery Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3"
                           placeholder="Enter your full address" required></textarea>
                     </div>
                  </div>
                  <div class="row mt-3">
                     <div class="col-md-12 text-center">
                        <button type="submit" name="submit" class="btn btn-theme">
                           <i class="fa fa-user-plus"></i> Register Now
                        </button>
                     </div>
                     <div class="col-md-12">
                        <p class="login-link">Already have an account? <a href="login.php">Login here</a></p>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>

<?php
include 'parts/end.php';
?>