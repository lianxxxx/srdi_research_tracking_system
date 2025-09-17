<?php
session_start();
require_once "../../controller/Main.php";

// ✅ Allowed roles
$allowedRoles = ['section_head', 'researcher_division_head', 'executive_director', 'admin'];
if (!isset($_SESSION['user_id']) || !in_array(strtolower($_SESSION['role']), $allowedRoles)) {
    header("Location: ../auth/login.php");
    exit;
}

// ✅ Validate ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['message'] = "Invalid research paper.";
    $_SESSION['message_type'] = "danger";
    header("Location: researchApproved.php");
    exit;
}

$db = new db();
$researchId = (int) $_GET['id'];
$userId     = (int) $_SESSION['user_id'];
$userRole   = strtolower($_SESSION['role']);

// ✅ Executive Director auto-publishes
$status = ($userRole === 'executive_director') ? 'Publish' : 'Approved';

// ✅ Update research status (supports multiple approvers)
$success = $db->updateResearchStatus($researchId, $status, $userId);

if ($success) {
    $_SESSION['message'] = "Research paper status updated to <b>$status</b> successfully!";
    $_SESSION['message_type'] = "success";
} else {
    $_SESSION['message'] = "Failed to update research paper status.";
    $_SESSION['message_type'] = "danger";
}

header("Location: researchApproved.php");
exit;
