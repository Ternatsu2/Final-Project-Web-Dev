<?php
session_start();
require '../db.php';
if (!isset($_SESSION['user_id'])) {
    exit("Unauthorized");
}

$issueId = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT I.*, 
                        U1.firstname as creator_fname, U1.lastname as creator_lname,
                        U2.firstname as assignee_fname, U2.lastname as assignee_lname
                        FROM Issues I
                        JOIN Users U1 ON I.created_by = U1.id
                        JOIN Users U2 ON I.assigned_to = U2.id
                        WHERE I.id = :id");
$stmt->bindParam(':id', $issueId, PDO::PARAM_INT);
$stmt->execute();
$issue = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$issue) {
    exit("Issue not found");
}

$createdDate = date("F j, Y, g:i A", strtotime($issue['created_at']));
$updatedDate = date("F j, Y, g:i A", strtotime($issue['updated_at']));
?>
<h1><?= htmlspecialchars($issue['title']) ?></h1>
<p><?= nl2br(htmlspecialchars($issue['description'])) ?></p>
<ul>
    <li>Issue #<?= $issue['id'] ?></li>
    <li>Type: <?= htmlspecialchars($issue['type']) ?></li>
    <li>Priority: <?= htmlspecialchars($issue['priority']) ?></li>
    <li>Status: <span id="issue-status"><?= htmlspecialchars($issue['status']) ?></span></li>
    <li>Assigned To: <?= htmlspecialchars($issue['assignee_fname'].' '.$issue['assignee_lname']) ?></li>
    <li>Created By: <?= htmlspecialchars($issue['creator_fname'].' '.$issue['creator_lname']) ?></li>
    <li>Created on: <?= $createdDate ?></li>
    <li>Last Updated: <span id="issue-updated"><?= $updatedDate ?></span></li>
</ul>

<button id="markClosedBtn">Mark as Closed</button>
<button id="markProgressBtn">Mark In Progress</button>

<script>
document.getElementById('markClosedBtn').addEventListener('click', function(){
    updateIssueStatus(<?= $issue['id'] ?>, 'Closed');
});
document.getElementById('markProgressBtn').addEventListener('click', function(){
    updateIssueStatus(<?= $issue['id'] ?>, 'In Progress');
});

function updateIssueStatus(issueId, newStatus){
    fetch('scripts/updateIssueStatus.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'id=' + issueId + '&status=' + newStatus
    })
    .then(res => res.text())
    .then(data => {
        console.log(data);
        // Update detail page UI
        document.getElementById('issue-status').innerText = newStatus;
        document.getElementById('issue-updated').innerText = new Date().toLocaleString();
        
        // Then automatically reload the issues table:
        console.log('Reloading issues table'); // Debug
        loadIssues('all');
    })
    .catch(err => console.error(err));
}
