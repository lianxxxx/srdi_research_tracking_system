<?php
session_start();
require_once "../../controller/Main.php";

// Only allow admins
if (!isset($_SESSION['user_id']) || strtolower($_SESSION['role']) !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$db = new db();

$message = "";
$messageType = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name']);
    $middle_name = trim($_POST['middle_name']);
    $last_name = trim($_POST['last_name']);
    $permanent_address = trim($_POST['permanent_address']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($role) || empty($permanent_address)) {
        $message = "All required fields must be filled.";
        $messageType = "danger";
    } elseif ($db->isEmailExists($email)) {
        $message = "Email already exists.";
        $messageType = "warning";
    } else {
        $success = $db->registerUser($first_name, $middle_name, $last_name, $email, $password, $role, $permanent_address);

        if ($success) {
            $message = "User created successfully!";
            $messageType = "success";
        } else {
            $message = "Error creating user. Please try again.";
            $messageType = "danger";
        }
    }
}
?>

<?php include('../../assets/partials/partial/header.php'); ?>
<?php include('../../assets/partials/partial/navbar.php'); ?>
<?php include('../../assets/partials/partial/sidebar.php'); ?>

<div class="main-content" style="margin-left:250px; min-height:100vh; padding-bottom:80px;">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Create New User</h5>
                    </div>
                    <div class="card-body">

                        <?php if (!empty($message)): ?>
                            <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                                <?php echo htmlspecialchars($message); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">First Name *</label>
                                <input type="text" name="first_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Middle Name</label>
                                <input type="text" name="middle_name" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Last Name *</label>
                                <input type="text" name="last_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Permanent Address *</label>
                                <input type="text" name="permanent_address" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email *</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password *</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Role *</label>
                                <select name="role" class="form-select" required>
                                    <option value="">Select Role</option>
                                    <option value="researcher">Researcher</option>
                                    <option value="researcher_division_head">Researcher Division Head</option>
                                    <option value="section_head">Section Head</option>
                                    <option value="srdi_record_staff">SRDI Record Staff</option>
                                    <option value="executive_director">Executive Director</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Create User</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../../assets/partials/partial/footer.php'); ?>