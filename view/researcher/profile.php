
<?php
session_start();
require_once '../../controller/Main.php';

$db = new db();

// Check if user is logged in
if (!isset($_SESSION['user_id']) || strtolower($_SESSION['role']) !== 'researcher') {
    header("Location: ../auth/login.php");
    exit;
}

// Get the creator full name from session or DB
if (!isset($_SESSION['user_fullname'])) {
    $user = $db->getUserById($_SESSION['user_id']);
    $_SESSION['user_fullname'] = $user['first_name'] . ' ' . $user['last_name'];
}
$creatorName = $_SESSION['user_fullname'];

// Get research papers by creator
$researchPapers = $db->getResearchPapersByCreator($creatorName);
?>







<?php include('../../assets/partials/researcherpartial/navbar.php'); ?>
<?php include('../../assets/partials/researcherpartial/header.php'); ?>
<?php include('../../assets/partials/researcherpartial/sidebar.php'); ?>
<?php include('../../assets/partials/researcherpartial/footer.php'); ?>