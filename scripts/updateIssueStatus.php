<?php
session_start();
require '../db.php';
if (!isset($_SESSION['user_id'])) {
    exit("Unauthorized");
}

$issueId = $_POST['id'];
$newStatus = $_POST['status'];

$stmt = $conn->prepare("UPDATE Issues
                        SET status = :status, updated_at = NOW()
                        WHERE id = :id");
$stmt->bindParam(':status', $newStatus, PDO::PARAM_STR);
$stmt->bindParam(':id', $issueId, PDO::PARAM_INT);
$stmt->execute();

echo "Status updated";
?>
