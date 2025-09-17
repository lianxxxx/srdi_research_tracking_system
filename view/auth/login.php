<?php
session_start();
require_once "../../controller/Main.php";

$db = new db();
$message = [];

// Handle login submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $user = $db->checkUsers($email, $password);

    if (is_array($user)) {
        // ✅ Store consistent session variables
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['email']    = $user['email'];
        $_SESSION['fullname'] = $user['first_name'] . ' ' . $user['last_name'];
        $_SESSION['role']     = strtolower($user['role']);

        // ✅ Map roles to dashboards
        $redirects = [
            'researcher'              => '../researcher/dashboard.php',
            'researcher_division_head'=> '../researcher_division_head/dashboard.php',
            'admin'                   => '../admin/dashboard.php',
            'executive_director'      => '../executive_director/dashboard.php',
            'section_head'            => '../section_head/dashboard.php',
            'srdi_record_staff'       => '../srdi_record_staff/dashboard.php',
        ];

        if (array_key_exists($_SESSION['role'], $redirects)) {
            $_SESSION['message'] = "Welcome, you have successfully logged in.";
            $_SESSION['message_type'] = "success";
            header("Location: " . $redirects[$_SESSION['role']]);
            exit;
        } else {
            $message[] = 'Unknown role. Please contact administrator.';
            session_destroy();
        }
    } else {
        // $user contains error string from checkUsers
        $message[] = $user;
    }
}
?>

<?php include('../../assets/partials/partial/header.php'); ?>

<main class="d-flex flex-column align-items-center justify-content-center min-vh-100">
    <div class="card shadow-lg p-4" style="width: 100%; max-width: 500px;">
        <div class="text-center mb-4">
            <img src="../../assets/images/dmmmsu-logo.png" alt="Logo" class="img-fluid" style="max-height: 120px;">
            <h5 class="mt-2 text-primary">Don Mariano Marcos Memorial State University</h5>
            <h6 class="text-secondary">North La Union Campus</h6>
            <h6 class="text-secondary">Sericulture Research and Development Institute - Document Tracking</h6>
        </div>

        <!-- Flash message -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['message_type'] ?? 'info'; ?> alert-dismissible fade show text-center" role="alert">
                <?php echo $_SESSION['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
            ?>
        <?php endif; ?>

        <!-- Validation errors -->
        <?php if (!empty($message)): ?>
            <div class="alert alert-danger text-center">
                <?php foreach ($message as $msg): ?>
                    <p><?php echo htmlspecialchars($msg); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <h5 class="text-center">Login</h5>
        <p class="text-center small">Enter your credentials.</p>

        <form action="" method="post">
            <div class="mb-3">
                <label class="form-label">Email address</label>
                <input type="email" name="email" required placeholder="Enter your email" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" id="password" name="password" required placeholder="Enter your password" class="form-control">
                    <button type="button" id="eye-password" class="input-group-text"
                        onclick="togglePassword('password', 'eye-password-icon')">
                        <i id="eye-password-icon" class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            <button class="btn btn-success w-100" type="submit" name="submit">Log in</button>
        </form>

        <div class="text-center mt-3">
            <a href="register.php" class="small">Register</a> |
            <a href="forgotPassword.php" class="small">Forgot Password?</a>
        </div>
    </div>
</main>

<script>
    function togglePassword(passwordId, iconId) {
        const passwordField = document.getElementById(passwordId);
        const toggleIcon = document.getElementById(iconId);

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }
</script>

<?php include('../../assets/partials/partial/footer.php'); ?>
