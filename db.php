<?php
$host     = 'localhost';
$db       = 'bugme';  // Ensure this is the correct DB name
$user     = 'root';   // Or your DB user
$password = '';       // Or your DB password

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    exit("Connection failed: " . $e->getMessage());
}
?>
