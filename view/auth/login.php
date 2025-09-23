<?php
session_start();
require_once "../../controller/Main.php";

$db = new db();

// Read any flash message (set after redirect) and then remove it
$flash_message = $_SESSION['flash_message'] ?? '';
$flash_type    = $_SESSION['flash_type'] ?? '';
unset($_SESSION['flash_message'], $_SESSION['flash_type']);

// Preserve old email across redirect (if set) and then remove it
$old_email = $_SESSION['old_email'] ?? '';
unset($_SESSION['old_email']);

// Handle login submission (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $user = $db->checkUsers($email, $password);

    if (is_array($user)) {
        // Successful login - set session and redirect to role dashboard
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['email']    = $user['email'];
        $_SESSION['fullname'] = $user['first_name'] . ' ' . $user['last_name'];
        $_SESSION['role']     = strtolower($user['role']);

        $redirects = [
            'researcher'               => '../researcher/dashboard.php',
            'researcher_division_head' => '../researcher_division_head/dashboard.php',
            'admin'                    => '../admin/dashboard.php',
            'executive_director'       => '../executive_director/dashboard.php',
            'section_head'             => '../section_head/dashboard.php',
            'srdi_record_staff'        => '../srdi_record_staff/dashboard.php',
        ];

        if (array_key_exists($_SESSION['role'], $redirects)) {
            $_SESSION['message'] = "Welcome, you have successfully logged in.";
            $_SESSION['message_type'] = "success";
            header("Location: " . $redirects[$_SESSION['role']]);
            exit;
        } else {
            $_SESSION['flash_message'] = 'Unknown role. Please contact administrator.';
            $_SESSION['flash_type'] = 'danger';
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
    } else {
        // Wrong credentials -> set a flash message and redirect
        $_SESSION['flash_message'] = 'Incorrect email or password.';
        $_SESSION['flash_type'] = 'danger';
        $_SESSION['old_email'] = $email;
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login </title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../users/template/vendors/feather/feather.css">
  <link rel="stylesheet" href="../../users/template/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../users/template/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../../users/template/vendors/typicons/typicons.css">
  <link rel="stylesheet" href="../../users/template/vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="../../users/template/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <link rel="stylesheet" href="../../users/template/css/vertical-layout-light/style.css">
  <link rel="shortcut icon" href="../../landing_assets/img/SRDI-Logo.jpg" />
  <style>
    .is-invalid {
      border: 1px solid #dc3545 !important; /* Red border */
    }
  </style>
</head>

<body>
  <div class="container-scroller l">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0 ">
        <div class="row w-100 mx-0 ">
          <div class="col-lg-4 mx-auto ">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5 rounded-3 shadow-lg">

              <div class="brand-logo d-flex justify-content-center mb-4">
                <img src="../../landing_assets/img/SRDI-Logo.jpg" alt="logo">
              </div>

              <h4 class="fw-bold login-header text-primary ">
                SRDI Research Tracking System
              </h4>

              <h6 class="fw-light text">Log in to your account!</h6>

              <form action="" method="post" class="pt-3">
                <div class="form-group">
                  <label class=" text-dark mb-0">EMAIL</label>
                  <input type="email"  
                         name="email" 
                         class="form-control form-control-lg rounded-3 <?= !empty($flash_message) ? 'is-invalid' : '' ?>" 
                         placeholder="Enter your email"
                         value="<?= htmlspecialchars($old_email) ?>">
                </div>

                <div class="form-group">
                  <label class="text-dark mb-0">PASSWORD</label>
                  <input type="password" 
                         name="password" 
                         class="form-control form-control-lg rounded-3 <?= !empty($flash_message) ? 'is-invalid' : '' ?>" 
                         placeholder="Enter your password">

                  <?php if (!empty($flash_message)): ?>
                    <small class="text-danger text-end d-block mt-2"><?= htmlspecialchars($flash_message) ?></small>
                  <?php endif; ?>
                </div>

                <div class="mt-3">
                  <button class="btn btn-lg w-100 font-weight-medium auth-form-btn" type="submit" name="submit">LOG IN</button>
                </div>

                <div class="my-2 d-flex justify-content-end">
                  <a href="#" class="auth-link text-black fpass">Forgot password?</a>
                </div>

                <div class="text-center mt-4 fw-light">
                  Don't have an account? <a href="register.html" class="text-decoration-none reg-text">Register now</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>

  <!-- plugins:js -->
  <script src="../../users/template/vendors/js/vendor.bundle.base.js"></script>
  <script src="../../users/template/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <script src="../../users/template/js/off-canvas.js"></script>
  <script src="../../users/template/js/hoverable-collapse.js"></script>
  <script src="../../users/template/js/template.js"></script>
  <script src="../../users/template/js/settings.js"></script>
  <script src="../../users/template/js/todolist.js"></script>

  <!-- Clear red border when focusing input -->
  <script>
    document.querySelectorAll('input').forEach(function(el){
      el.addEventListener('focus', function(){
        el.classList.remove('is-invalid');
      });
    });
  </script>
</body>
</html>
