<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "gestion_stock3");

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM utilisateurs WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: users.php");
exit();
?>
