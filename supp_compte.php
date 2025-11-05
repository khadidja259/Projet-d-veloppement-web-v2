<?php
session_start();
include("config.php");

if (!isset($_SESSION['username'], $_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    session_unset();
    session_destroy();
    header("Location: register.php");
    exit;
} else {
    echo "Erreur lors de la suppression du compte : " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
