<?php
session_start();
error_reporting(0);
include("connection/connect.php");

$errors = [];

if (isset($_POST['submit'])) {
   if (
      empty($_POST['username']) ||
      empty($_POST['firstname']) ||
      empty($_POST['lastname']) ||
      empty($_POST['email']) ||
      empty($_POST['phone']) ||
      empty($_POST['password']) ||
      empty($_POST['cpassword']) ||
      empty($_POST['address'])
   ) {
      $errors[] = "All fields are required.";
   } else {
      $username = mysqli_real_escape_string($db, $_POST['username']);
      $email = mysqli_real_escape_string($db, $_POST['email']);
      $password = $_POST['password'];
      $cpassword = $_POST['cpassword'];
      $phone = $_POST['phone'];
      $role = $_POST['role'];

      $check_username = mysqli_query($db, "SELECT username FROM users where username = '" . $username . "' ");
      $check_email = mysqli_query($db, "SELECT email FROM users where email = '" . $email . "' ");

      if ($password != $cpassword) {
         $errors[] = "Passwords do not match.";
      }
      if (empty($errors)) {
         $mql = "INSERT INTO users(username,f_name,l_name,email,phone,password,address,role) VALUES(
            '" . $username . "',
            '" . mysqli_real_escape_string($db, $_POST['firstname']) . "',
            '" . mysqli_real_escape_string($db, $_POST['lastname']) . "',
            '" . $email . "',
            '" . $phone . "',
            '" . md5($password) . "',
            '" . mysqli_real_escape_string($db, $_POST['address']) . "',
            '" . $role . "'
         )";
         $msg = urlencode('<div class="alert alert-success text-center">Account Created successfully! Please Wait for the admin approval.</div>');
         mysqli_query($db, $mql);
         header("Location: login.php?msg={$msg}");
         exit();
      }
   }
}

$title = "Registration";
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

   .text-danger {
      color: #dc3545 !important;
      font-size: 0.875em;
      margin-top: -10px;
      margin-bottom: 15px;
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
               <?php if (!empty($errors)) { ?>
                  <div class="error-message">
                     <?php foreach ($errors as $error) { ?>
                        <p><?php echo $error; ?></p>
                     <?php } ?>
                  </div>
               <?php } ?>
               <form action="" method="post" id="registrationForm">
                  <div class="row">
                     <div class="form-group col-md-12">
                        <label for="username">Username</label>
                        <input class="form-control" type="text" name="username" id="username"
                           placeholder="Enter your username">
                        <div id="username-error" class="text-danger"></div>
                     </div>
                     <div class="form-group col-md-6">
                        <label for="role">Register As</label>
                        <select name="role" class="form-control" id="role">
                           <option value="user">Regular User</option>
                           <option value="shop">Restaurant Owner</option>
                        </select>
                     </div>
                     <div class="form-group col-md-6">
                        <label for="firstname">First Name</label>
                        <input class="form-control" type="text" name="firstname" id="firstname"
                           placeholder="Enter your first name">
                        <div id="firstname-error" class="text-danger"></div>
                     </div>
                     <div class="form-group col-md-6">
                        <label for="lastname">Last Name</label>
                        <input class="form-control" type="text" name="lastname" id="lastname"
                           placeholder="Enter your last name">
                        <div id="lastname-error" class="text-danger"></div>
                     </div>
                     <div class="form-group col-md-6">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email">
                        <div id="email-error" class="text-danger"></div>
                     </div>
                     <div class="form-group col-md-6">
                        <label for="phone">Phone Number</label>
                        <input class="form-control" type="tel" name="phone" id="phone"
                           placeholder="Enter your phone number">
                        <div id="phone-error" class="text-danger"></div>
                     </div>
                     <div class="form-group col-md-6">
                        <label for="password">Password (min 6 characters)</label>
                        <input type="password" class="form-control" name="password" id="password"
                           placeholder="Create a password">
                        <div id="password-error" class="text-danger"></div>
                     </div>
                     <div class="form-group col-md-6">
                        <label for="cpassword">Confirm Password</label>
                        <input type="password" class="form-control" name="cpassword" id="cpassword"
                           placeholder="Confirm your password">
                        <div id="cpassword-error" class="text-danger"></div>
                     </div>
                     <div class="form-group col-md-12">
                        <label for="address">Delivery Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3"
                           placeholder="Enter your full address"></textarea>
                        <div id="address-error" class="text-danger"></div>
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

<script>
   document.addEventListener('DOMContentLoaded', function () {
      const form = document.getElementById('registrationForm');
      form.addEventListener('submit', function (event) {
         let isValid = true;
         document.querySelectorAll('.text-danger').forEach(el => el.textContent = '');

         function showError(id, message) {
            const errorElement = document.getElementById(id);
            if (errorElement) {
               errorElement.textContent = message;
            }
         }

         const username = document.getElementById('username').value.trim();
         if (username === '') {
            showError('username-error', 'Username is required.');
            isValid = false;
         }

         const firstname = document.getElementById('firstname').value.trim();
         if (firstname === '') {
            showError('firstname-error', 'First name is required.');
            isValid = false;
         }

         const lastname = document.getElementById('lastname').value.trim();
         if (lastname === '') {
            showError('lastname-error', 'Last name is required.');
            isValid = false;
         }

         const email = document.getElementById('email').value.trim();
         const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
         if (email === '') {
            showError('email-error', 'Email is required.');
            isValid = false;
         } else if (!emailRegex.test(email)) {
            showError('email-error', 'Please enter a valid email address.');
            isValid = false;
         }

         const phone = document.getElementById('phone').value.trim();
         const phoneRegex = /^[0-9]{11}$/;
         if (phone === '') {
            showError('phone-error', 'Phone number is required.');
            isValid = false;
         } else if (!phoneRegex.test(phone)) {
            showError('phone-error', 'Phone number must be exactly 10 digits.');
            isValid = false;
         }

         // Check Password
         const password = document.getElementById('password').value;
         // Regex for strong password: at least 8 characters, one uppercase, one lowercase, one number, and one special character
         const strongPasswordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*]).{8,}$/;
         if (password === '') {
            showError('password-error', 'Password is required.');
            isValid = false;
         } else if (!strongPasswordRegex.test(password)) {
            showError('password-error', 'Password must be at least 8 characters and contain at least one uppercase letter, one lowercase letter, one number, and one special character (!@#$%^&*).');
            isValid = false;
         }

         const cpassword = document.getElementById('cpassword').value;
         if (cpassword === '') {
            showError('cpassword-error', 'Please confirm your password.');
            isValid = false;
         } else if (cpassword !== password) {
            showError('cpassword-error', 'Passwords do not match.');
            isValid = false;
         }
         const address = document.getElementById('address').value.trim();
         if (address === '') {
            showError('address-error', 'Address is required.');
            isValid = false;
         }

         if (!isValid) {
            event.preventDefault();
         }
      });
   });
</script>

<?php
include 'parts/end.php';
?>