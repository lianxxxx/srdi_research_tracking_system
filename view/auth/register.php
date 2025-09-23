
<?php
session_start();
require_once "../../controller/connection.db.php";

//$db = new db();
$message = [];

$first_name = $middle_name = $last_name = $email = $role = $password = $confirm_password = $permanent_address = "";

if (isset($_POST['submit'])) {
    $first_name = trim($_POST['first_name']);
    $middle_name = trim($_POST['middle_name']);
    $last_name = trim($_POST['last_name']);
   $region = trim($_POST['region']);
    $province = trim($_POST['province']);
    $municipality = trim($_POST['municipality']);
    $barangay = trim($_POST['barangay']);

    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    if (!$first_name || !$last_name || !$email || !$password || !$confirm_password || !$role || !$permanent_address) {
        $message[] = "Please fill in all required fields.";
    } elseif ($password !== $confirm_password) {
        $message[] = "Passwords do not match.";
    } elseif ($db->isEmailExists($email)) {
        $message[] = "Email is already registered.";
    } else {
       // $registered = $db->registerUser($first_name, $middle_name, $last_name, $email, $password, $role, $permanent_address);
       $registered = $db->registerUser($first_name, $middle_name, $last_name, $email, $password, $role, $region, $province, $municipality, $barangay);

       if ($registered) {
            $_SESSION['message'] = 'Registration successful! You may now log in.';
            $_SESSION['message_type'] = 'success';
            header("Location: login.php");
            exit;
        } else {
            $message[] = "Registration failed. Please try again.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Register </title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../users/template/vendors/feather/feather.css">
  <link rel="stylesheet" href="../../users/template/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../users/template/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../../users/template/vendors/typicons/typicons.css">
  <link rel="stylesheet" href="../../users/template/vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="../../users/template/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../users/template/css/vertical-layout-light/style.css">
  <!-- endinject -->
   <link href="../../landing_assets/img/SRDI-Logo.jpg" rel="icon">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

   <!-- jQuery CDN -->
  <script>
  $(document).ready(function() {
    // Load Provinces based on Region for Permanent Address
    $('#region').change(function() {
        var regCode = $(this).val();
        $.ajax({
            url: 'getProvince.php',
            type: 'POST',
            data: { regCode: regCode },
            success: function(data) {
                $('#province').html(data);
                $('#municipality').html('<option value="">Select Municipality</option>');
                $('#barangay').html('<option value="">Select Barangay</option>');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Error:', textStatus, errorThrown);
            }
        });
    });
});
 


$(document).ready(function() {
    $('#province').change(function() {
        var provCode = $(this).val();
        console.log("Province changed:", provCode); // DEBUG

        $.ajax({
            url: 'getMunicipality.php',
            type: 'POST',
            data: { provCode: provCode },
            success: function(data) {
                console.log("AJAX Success:", data); // DEBUG
                $('#municipality').html(data);
                $('#barangay').html('<option value="">Select Barangay</option>');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('AJAX Error:', textStatus, errorThrown);
            }
        });
    });
});

// Load Barangays based on Municipality
$(document).ready(function() {
    $('#municipality').change(function() {
        var citymunCode = $(this).val();
        console.log("Selected Municipality:", citymunCode);

        $.ajax({
            url: 'getBarangay.php',
            type: 'POST',
            data: { citymunCode: citymunCode },
            success: function(data) {
                console.log("Response from getBarangay.php:", data);
                $('#barangay').html(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Error:', textStatus, errorThrown);
            }
        });
    });
});

  

  </script>


</head>

<body>
<div class="container-scroller l">
  <div class="container-fluid page-body-wrapper full-page-wrapper">
    <div class="content-wrapper d-flex align-items-center auth px-0">
      <div class="row w-100 mx-0">
        <div class="col-lg-8 mx-auto"> <!-- made wider container -->
          <div class="auth-form-light text-left py-5 px-4 px-sm-5 rounded-3 shadow-lg">

            <!-- Logo -->
            <div class="brand-logo d-flex justify-content-center mb-4">
              <img src="../..//users/template/images/auth/SRDI-Logo.jpg" alt="logo">
            </div>

            <!-- Header -->
            <h3 class="fw-bold login-header text-primary  text-center">
SRDI Research Tracking System
            </h3>
            <h6 class="fw-light text-center"> Start your research journey - Create your account!🚀</h6>


                  <?php if (!empty($message)): ?>
            <div class="alert alert-danger text-center">
                <?php foreach ($message as $msg): ?>
                    <p><?php echo htmlspecialchars($msg); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>


            <!-- Form -->
            <form class="pt-3">
              
              <!-- Name Row -->
                  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
   <div class="row">
  <div class="col-md-4 mb-3">
    <label class="text-dark mb-0 ">First Name</label>
<div class="input-group">
  <span class="input-group-text bg-secondary text-primary">
    <i class="mdi mdi-account"></i>
  </span>
  <input type="text" class="form-control" name="first_name"  placeholder="Enter first name" value="<?php echo htmlspecialchars($first_name); ?>">
</div>

  </div>
  <div class="col-md-4 mb-3 ">
    <label class="text-dark mb-0 ">Middle Name</label>

  <input type="text" class="form-control " placeholder="Enter middle name"  name="middle_name"  value="<?php echo htmlspecialchars($middle_name); ?>">

  </div>
  <div class="col-md-4 mb-3">
    <label class="text-dark mb-0 ">Last Name</label>

  <input type="text" class="form-control" placeholder="Enter last name" name="last_name"  value="<?php echo htmlspecialchars($last_name); ?>">

  </div>
</div>


              <!-- Address Row -->
              <div class="row">
                <div class="col-md-3 mb-3">
                  <label class="text-dark mb-0 ">Region</label>
                <div class="input-group">
  <span class="input-group-text bg-secondary text-primary">
    <i class="mdi mdi-map-marker"></i>
  </span>
<select id="region" name="region" required class="form-control" placeholder="Region">
    <option value="" disabled selected>Select Region</option>
    <?php
    include '../../controller/connection.db.php';
    $result = mysqli_query($conn, "SELECT * FROM refregion ORDER BY regDesc ASC");
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='".$row['regCode']."'>".$row['regDesc']."</option>";
        }
    } else {
        echo "<option disabled>Error loading regions</option>";
    }
    ?>
</select>


</div>

                </div>
                <div class="col-md-3 mb-3">
                  <label class="text-dark mb-0 ">Province</label>
                      <select id="province" name="province" required class="form-control form-control rounded-3" placeholder="Province" >
            <option value="" disabled selected>Select Province</option>
        </select>
                </div>

                <div class="col-md-3 mb-3">
                  <label class="text-dark mb-0 ">Municipality</label>
                      <select id="municipality" name="municipality" class="form-control form-control rounded-3" placeholder="Municipality" >
            <option value="" disabled selected>Select Municipality</option>
        </select>
                </div>

                <div class="col-md-3 mb-3">
                  <label class="text-dark mb-0 ">Barangay</label>
                <select id="barangay" name="barangay"  class="form-control form-control rounded-3" placeholder="Barangay">
            <option value="" disabled selected>Select Barangay</option>
        </select>
                  </div>
              </div>

              <!-- Email -->
              <div class="form-group mb-3">
                <label class="text-dark mb-0 ">Email Address</label>
               <div class="input-group">
  <span class="input-group-text bg-secondary text-primary">
    <i class="mdi mdi-email"></i>
  </span>
  <input type="email" class="form-control" placeholder="Enter your email" name="email" value="<?php echo htmlspecialchars($email); ?>">
</div>

              </div>

            <!-- Password Row -->

<div class="row">
  <!-- Password -->
  <div class="col-md-6 mb-3 position-relative">
    <label class="text-dark mb-0 ">Password</label>
    
<div class="input-group position-relative">
  <span class="input-group-text bg-secondary text-primary">
    <i class="mdi mdi-lock"></i>
  </span>
  <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">


</div>


  </div>

  <!-- Confirm Password -->
  <div class="col-md-6 mb-3 position-relative">
    <label class="text-dark mb-0 ">Confirm Password</label>
    <input type="text" class="form-control rounded-3" id="confirmPassword" placeholder="Confirm password" name="confirm_password">
    <span class="toggle-password" toggle="#confirmPassword">
      <i class="mdi mdi-eye"></i>
    </span>
  </div>
</div>



              <!-- Role Dropdown -->
              <div class="form-group mb-3">
                <label class="text-dark mb-0 ">Role</label>
                <div class="input-group">
  <span class="input-group-text bg-secondary text-primary">
    <i class="mdi mdi-account-box"></i>
  </span>
  <select class="form-control" name="role" >
    <option selected disabled>Select your role</option>
  <?php
                    $roles = [
                        'researcher',
                        'researcher_division_head',
                        'section_head',
                        'srdi_record_staff',
                        'executive_director'
                    ];
                    foreach ($roles as $r) {
                        echo '<option value="' . $r . '"' . ($role === $r ? ' selected' : '') . '>' . ucwords(str_replace('_', ' ', $r)) . '</option>';
                    }
                    ?>
  </select>
</div>

              </div>

              <!-- Submit Button -->
              <div class="mt-3">
                <button  type="submit" name="submit" class="btn btn-lg w-100 font-weight-medium auth-form-btn" >REGISTER</button>
              </div>

                    </form>
              <!-- Back to login -->
              <div class="text-center mt-4 fw-light">
                Already have an account? 
                <a href="../../view/auth/login.php" class="text-decoration-none reg-text">Log in</a>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="../../users/template/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="../../users/template/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="../../users/template/js/off-canvas.js"></script>
  <script src="../../users/template/js/hoverable-collapse.js"></script>
  <script src="../../users/template/js/template.js"></script>
  <script src="../../users/template/js/settings.js"></script>
  <script src="../..//users/template/js/todolist.js"></script>
  
  <!-- endinject -->

<script>
  document.querySelectorAll('.toggle-password').forEach(item => {
    item.addEventListener('click', function() {
      let input = document.querySelector(this.getAttribute('toggle'));
      let icon = this.querySelector('i');
      if (input.getAttribute('type') === 'password') {
        input.setAttribute('type', 'text');
        icon.classList.remove('mdi-eye-off');
        icon.classList.add('mdi-eye');
      } else {
        input.setAttribute('type', 'password');
        icon.classList.remove('mdi-eye');
        icon.classList.add('mdi-eye-off');
      }
    });
  });
</script> 


</body>

</html>
