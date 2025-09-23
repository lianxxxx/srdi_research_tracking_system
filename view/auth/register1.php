<?php
session_start();
require_once "../../controller/Main.php";

$db = new db();
$message = [];

$first_name = $middle_name = $last_name = $email = $role = $password = $confirm_password = $permanent_address = "";

if (isset($_POST['submit'])) {
    $first_name = trim($_POST['first_name']);
    $middle_name = trim($_POST['middle_name']);
    $last_name = trim($_POST['last_name']);
    $permanent_address = trim($_POST['permanent_address']);
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
        $registered = $db->registerUser($first_name, $middle_name, $last_name, $email, $password, $role, $permanent_address);
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

<?php include('../../assets/partials/partial/header.php'); ?>

<main class="d-flex flex-column align-items-center justify-content-center min-vh-100">
    <div class="card shadow-lg p-4" style="width: 100%; max-width: 600px;">
        <div class="text-center mb-4">
            <img src="../../assets/images/dmmmsu-logo.png" alt="Logo" class="img-fluid" style="max-height: 120px;">
            <h5 class="mt-2 text-primary">Don Mariano Marcos Memorial State University</h5>
            <h6 class="text-secondary">North La Union Campus</h6>
            <h6 class="text-secondary">Don Mariano Marcos Memorial State University-North La Union Sericulture Research
                and Development Institute - Document Tracking</h6>
        </div>

        <?php if (!empty($message)): ?>
            <div class="alert alert-danger text-center">
                <?php foreach ($message as $msg): ?>
                    <p><?php echo htmlspecialchars($msg); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="mb-3">
                <label class="form-label">First Name</label>
                <input type="text" name="first_name" required class="form-control"
                    value="<?php echo htmlspecialchars($first_name); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Middle Name</label>
                <input type="text" name="middle_name" class="form-control"
                    value="<?php echo htmlspecialchars($middle_name); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Last Name</label>
                <input type="text" name="last_name" required class="form-control"
                    value="<?php echo htmlspecialchars($last_name); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Permanent Address</label>
                <input type="text" name="permanent_address" required class="form-control"
                    value="<?php echo htmlspecialchars($permanent_address); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" required class="form-control"
                    value="<?php echo htmlspecialchars($email); ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" required class="form-control">
                    <button type="button" class="input-group-text" onclick="togglePassword('password', 'eye-icon')">
                        <i id="eye-icon" class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <div class="input-group">
                    <input type="password" name="confirm_password" id="confirm_password" required class="form-control">
                    <button type="button" class="input-group-text"
                        onclick="togglePassword('confirm_password', 'eye-icon-confirm')">
                        <i id="eye-icon-confirm" class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-select" required>
                    <option value="">-- Select Role --</option>
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
            <button type="submit" name="submit" class="btn btn-primary w-100">Register</button>
        </form>

        <div class="text-center mt-3">
            <a href="login.php" class="small">Already have an account? Login here</a>
        </div>
    </div>
</main>

<script>
    function togglePassword(passwordId, iconId) {
        const passwordField = document.getElementById(passwordId);
        const icon = document.getElementById(iconId);
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>

<?php include('../../assets/partials/partial/footer.php'); ?>