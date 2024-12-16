<?php
session_start();
require '../db.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Unauthorized (session not set)']);
    exit;
}

$debug = [];
$debug[] = "DEBUG: Adding a new user...";

$firstname = filter_var($_POST['firstname'] ?? '', FILTER_SANITIZE_STRING);
$lastname  = filter_var($_POST['lastname']  ?? '', FILTER_SANITIZE_STRING);
$email     = filter_var($_POST['email']     ?? '', FILTER_SANITIZE_EMAIL);
$password  = $_POST['password'] ?? '';

$debug[] = "POST data: " . print_r($_POST, true);
$debug[] = "Variables: firstname=$firstname, lastname=$lastname, email=$email";

// Validate
$pattern = '/^(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/';
if (!preg_match($pattern, $password)) {
    $debug[] = "Password invalid format";
    echo json_encode(['error' => 'Password must be at least 8 characters, contain 1 uppercase letter, 1 digit.', 'debug' => $debug]);
    exit;
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$debug[] = "hashedPassword=$hashedPassword";

try {
    $stmt = $conn->prepare("
        INSERT INTO Users (firstname, lastname, password, email, created_at)
        VALUES (:fn, :ln, :pwd, :em, NOW())
    ");

    if (!$stmt) {
        $debug[] = "SQL Prepare error: " . implode(", ", $conn->errorInfo());
        echo json_encode(['error' => 'Prepare failed', 'debug' => $debug]);
        exit;
    }

    $stmt->bindParam(':fn',  $firstname);
    $stmt->bindParam(':ln',  $lastname);
    $stmt->bindParam(':pwd', $hashedPassword);
    $stmt->bindParam(':em',  $email);

    $result = $stmt->execute();
    $debug[] = "SQL Execute result: " . ($result ? "TRUE" : "FALSE");

    if (!$result) {
        $debug[] = "SQL Execute error: " . implode(", ", $stmt->errorInfo());
        echo json_encode(['error' => 'Execute failed', 'debug' => $debug]);
    } else {
        echo json_encode(['success' => true, 'message' => 'User added successfully', 'debug' => $debug]);
    }
} catch (PDOException $e) {
    $debug[] = "Exception: " . $e->getMessage();
    echo json_encode(['error' => 'Error adding user: ' . $e->getMessage(), 'debug' => $debug]);
}
?>
