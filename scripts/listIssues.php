<?php
session_start();
require '../db.php';
if (!isset($_SESSION['user_id'])) {
    exit("Unauthorized");
}

$filter = $_GET['filter'] ?? 'all';
$userId = $_SESSION['user_id'];

// Base query
$sql = "SELECT I.id, I.title, I.type, I.status, I.created_at, U.firstname, U.lastname
        FROM Issues I
        JOIN Users U ON I.assigned_to = U.id";

// Apply filters
if ($filter === 'open') {
    $sql .= " WHERE I.status = 'Open'";
} elseif ($filter === 'mytickets') {
    $sql .= " WHERE I.assigned_to = :userid";
}

$stmt = $conn->prepare($sql);
if ($filter === 'mytickets') {
    $stmt->bindParam(':userid', $userId, PDO::PARAM_INT);
}
$stmt->execute();
$issues = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Build the HTML table
$html = "<table>";
$html .= "<tr><th>Title</th><th>Type</th><th>Status</th><th>Assigned To</th><th>Created</th></tr>";

foreach ($issues as $issue) {
    $issueId    = $issue['id'];
    $title      = htmlspecialchars($issue['title']);
    $type       = htmlspecialchars($issue['type']);
    $status     = htmlspecialchars($issue['status']);
    $assignedTo = htmlspecialchars($issue['firstname'] . ' ' . $issue['lastname']);
    $created_at = date("Y-m-d", strtotime($issue['created_at']));

    // Make the issue title clickable
    $html .= "<tr>
               <td>
                 <a href='#' onclick='viewIssueDetails($issueId); return false;'>
                   #$issueId $title
                 </a>
               </td>
               <td>$type</td>
               <td>$status</td>
               <td>$assignedTo</td>
               <td>$created_at</td>
              </tr>";
}

$html .= "</table>";

echo $html;
?>
