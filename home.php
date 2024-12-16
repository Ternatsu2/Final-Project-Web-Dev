<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>BugMe Tracker | Home</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <!-- Black Header -->
    <header class="black-header">
        <div class="header-title">
            BugMe Issue Tracker
        </div>
    </header>

    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <nav>
                <ul>
                    <li><a href="#" id="nav-home">Home</a></li>
                    <li><a href="#" id="nav-add-user">Add User</a></li>
                    <li><a href="#" id="nav-new-issue">New Issue</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content" id="main-content">
            <h1>Issues</h1>
            <button id="createNewIssueBtn" class="green">Create New Issue</button>

            <div class="filters">
                <button id="filter-all" class="blue">ALL</button>
                <button id="filter-open" class="gray">OPEN</button>
                <button id="filter-mytickets" class="yellow">MY TICKETS</button>
            </div>

            <div id="issues-table"></div>
        </div>
    </div>
    <script src="assets/js/main.js"></script>
</body>
</html>
