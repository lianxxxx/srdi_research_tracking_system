<?php
session_start();
require_once "../../controller/Main.php"; 

$db = new db();
$message = "";
$step = "email"; 

$email = $new_password = $confirm_password = "";


if (isset($_POST['check_email'])) {
    $email = trim($_POST['email']);

    if (empty($email)) {
        $message = "Please enter your email address.";
    } elseif (!$db->isEmailExists($email)) {
        $message = "Email not found in our records.";
    } else {
        $step = "reset"; 
    }
}

if (isset($_POST['reset_password'])) {
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($new_password) || empty($confirm_password)) {
        $message = "Please enter and confirm your new password.";
        $step = "reset";
    } elseif ($new_password !== $confirm_password) {
        $message = "Passwords do not match.";
        $step = "reset";
    } else {
        $updated = $db->updatePassword($email, $new_password); 
        if ($updated) {
            $_SESSION['message'] = "Password updated successfully. You may now log in.";
            $_SESSION['message_type'] = "success";
            header("Location: login.php");
            exit;
        } else {
            $message = "Failed to update password. Please try again.";
            $step = "reset";
        }
    }
}
?>

<?php include('../../assets/partials/partial/header.php'); ?>

<main class="d-flex flex-column align-items-center justify-content-center min-vh-100">
    <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px;">
        <div class="text-center mb-4">
            
            <img src="../../assets/images/dmmmsu-logo.png" alt="Logo" class="img-fluid" style="max-height: 120px;">
            <h6 class="text-secondary">Don Mariano Marcos Memorial State University-North La Union Sericulture Research and Development Institute - Document Tracking</h6>
            <h5 class="mt-2 text-primary">Reset Password</h5>
            <p class="text-secondary">
                <?php echo $step === "email" ? "Enter your email to find your account." : "Enter your new password."; ?>
            </p>
        </div>

        <?php if ($message): ?>
            <div class="alert alert-danger text-center"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>


        <?php if ($step === "email"): ?>
            <form action="" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" name="email" id="email" required class="form-control"
                        value="<?php echo htmlspecialchars($email); ?>">
                </div>
                <button type="submit" name="check_email" class="btn btn-primary w-100">Proceed</button>
            </form>

        <?php elseif ($step === "reset"): ?>
            <form action="" method="post">
                <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">

                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <div class="input-group">
                        <input type="password" name="new_password" id="new_password" class="form-control" required>
                        <span class="input-group-text" onclick="togglePassword('new_password', 'newEye')">
                            <i id="newEye" class="fa fa-eye"></i>
                        </span>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirm New Password</label>
                    <div class="input-group">
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                        <span class="input-group-text" onclick="togglePassword('confirm_password', 'confirmEye')">
                            <i id="confirmEye" class="fa fa-eye"></i>
                        </span>
                    </div>
                </div>

                <button type="submit" name="reset_password" class="btn btn-success w-100">Update Password</button>
            </form>
        <?php endif; ?>

        <div class="text-center mt-3">
            <a href="login.php" class="small">Back to Login</a>
        </div>
    </div>
</main>

<script>
    function togglePassword(fieldId, iconId) {
        const input = document.getElementById(fieldId);
        const icon = document.getElementById(iconId);
        const isPassword = input.type === "password";
        input.type = isPassword ? "text" : "password";
        icon.classList.toggle("fa-eye");
        icon.classList.toggle("fa-eye-slash");
    }
</script>

<?php include('../../assets/partials/partial/footer.php'); ?>
