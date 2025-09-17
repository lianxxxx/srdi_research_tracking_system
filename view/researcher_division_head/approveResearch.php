<?php
session_start();
require_once "../../controller/Main.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

if (!isset($_GET['id'])) {
    $_SESSION['message'] = "Invalid research paper.";
    $_SESSION['message_type'] = "danger";
    header("Location: approvedResearch.php");
    exit;
}

$db = new db();
$researchId = (int) $_GET['id'];
$userId = (int) $_SESSION['user_id'];

// ✅ Update research status
$success = $db->updateResearchStatus($researchId, 'Approved', $userId);

if ($success) {
    $_SESSION['message'] = "Research paper approval updated successfully!";
    $_SESSION['message_type'] = "success";
} else {
    $_SESSION['message'] = "Failed to update research approval.";
    $_SESSION['message_type'] = "danger";
}

header("Location: researchApproved.php");
exit;
