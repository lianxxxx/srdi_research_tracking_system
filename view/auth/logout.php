<?php
session_start();
require_once "../../controller/Main.php";

$db = new db();

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $db->insertLog($userId, 'User logged out');
}

// Set message BEFORE session_unset()
$_SESSION['message'] = 'You have successfully logged out.';
$_SESSION['message_type'] = 'success';

session_unset();
session_destroy();

header("Location: login.php");
exit;
