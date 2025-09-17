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

if ($_SESSION['role'] !== 'researcher_division_head') {
    header("Location: ../auth/login.php");
    exit;
}
?>
<?php include('../../assets/partials/researchheadpartial/header.php'); ?>
<?php include('../../assets/partials/researchheadpartial/navbar.php'); ?>
<?php include('../../assets/partials/researchheadpartial/sidebar.php'); ?>

<main class="p-4">
  <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_fullname']); ?>!</h2>
  <p>You are logged in as <strong>Researcher Division Head</strong>.</p>
</main>

<?php include('../../assets/partials/researchheadpartial/footer.php'); ?>
