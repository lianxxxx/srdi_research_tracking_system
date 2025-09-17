<?php
session_start();
require_once "../../controller/Main.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$db = new db();

// Always refresh identity from DB to avoid stale/wrong session data
$me = $db->getUserById((int)$_SESSION['user_id']);
if (!$me) {
    // user id no longer valid
    session_unset();
    session_destroy();
    header("Location: ../auth/login.php");
    exit;
}

// Normalize/refresh session from DB (authoritative)
$_SESSION['role']          = strtolower($me['role']);
$_SESSION['user_fullname'] = trim($me['first_name'].' '.$me['last_name']);

if ($_SESSION['role'] !== 'executive_director') {
    header("Location: ../auth/login.php");
    exit;
}
?>

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

<?php include('../../assets/partials/executivepartial/header.php'); ?>
<?php include('../../assets/partials/executivepartial/navbar.php'); ?>
<?php include('../../assets/partials/executivepartial/sidebar.php'); ?>

<main class="p-4">
    
</main>

<?php include('../../assets/partials/executivepartial/footer.php'); ?>
