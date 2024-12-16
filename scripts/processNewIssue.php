<?php
session_start();
require '../db.php';
header('Content-Type: application/json'); // Return JSON

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Unauthorized (session not set)']);
    exit;
}

// Debug array to accumulate logs
$debug = [];

$debug[] = "DEBUG: Creating a new Issue...";

// Gather form data
$title       = filter_var($_POST['title'] ?? '', FILTER_SANITIZE_STRING);
$description = filter_var($_POST['description'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
$assigned_to = (int)($_POST['assigned_to'] ?? 0);
$type        = filter_var($_POST['type'] ?? '', FILTER_SANITIZE_STRING);
$priority    = filter_var($_POST['priority'] ?? '', FILTER_SANITIZE_STRING);
$created_by  = $_SESSION['user_id'];

$debug[] = "POST data: " . print_r($_POST, true);
$debug[] = "Variables: title=$title, description=$description, assigned_to=$assigned_to, type=$type, priority=$priority, created_by=$created_by";

// Insert into database
try {
    $stmt = $conn->prepare("
        INSERT INTO Issues (title, description, type, priority, status, assigned_to, created_by, created_at, updated_at)
        VALUES (:title, :description, :type, :priority, 'Open', :assigned_to, :created_by, NOW(), NOW())
    ");

    if (!$stmt) {
        $debug[] = "SQL Prepare error: " . implode(", ", $conn->errorInfo());
        echo json_encode(['error' => 'Prepare failed', 'debug' => $debug]);
        exit;
    }

    $stmt->bindParam(':title',       $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':type',        $type);
    $stmt->bindParam(':priority',    $priority);
    $stmt->bindParam(':assigned_to', $assigned_to);
    $stmt->bindParam(':created_by',  $created_by);

    $result = $stmt->execute();
    $debug[] = "SQL Execute result: " . ($result ? "TRUE" : "FALSE");

    if (!$result) {
        $debug[] = "SQL Execute error: " . implode(", ", $stmt->errorInfo());
        echo json_encode(['error' => 'Execute failed', 'debug' => $debug]);
    } else {
        echo json_encode(['success' => true, 'message' => 'Issue created successfully', 'debug' => $debug]);
    }
} catch (PDOException $e) {
    $debug[] = "Exception: " . $e->getMessage();
    echo json_encode(['error' => 'Error creating issue: ' . $e->getMessage(), 'debug' => $debug]);
}
?>
