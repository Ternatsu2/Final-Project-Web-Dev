<?php
session_start();
require '../db.php';
if (!isset($_SESSION['user_id'])) {
    exit("Unauthorized");
}

// Retrieve users for 'Assigned To' dropdown
$usersStmt = $conn->query("SELECT id, firstname, lastname FROM Users");
$users = $usersStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Create Issue</h1>
<form id="newIssueForm">
    <label for="title">Title</label><br>
    <input type="text" id="title" name="title" required><br>

    <label for="description">Description</label><br>
    <textarea id="description" name="description" required></textarea><br>

    <label for="assigned_to">Assigned To</label><br>
    <select id="assigned_to" name="assigned_to">
        <?php foreach ($users as $user): ?>
            <option value="<?= htmlspecialchars($user['id']) ?>">
                <?= htmlspecialchars($user['firstname'] . ' ' . $user['lastname']) ?>
            </option>
        <?php endforeach; ?>
    </select><br>

    <label for="type">Type</label><br>
    <select id="type" name="type">
        <option value="Bug">Bug</option>
        <option value="Proposal">Proposal</option>
        <option value="Task">Task</option>
    </select><br>

    <label for="priority">Priority</label><br>
    <select id="priority" name="priority">
        <option value="Minor">Minor</option>
        <option value="Major">Major</option>
        <option value="Critical">Critical</option>
    </select><br>

    <button type="submit">Submit</button>
</form>
