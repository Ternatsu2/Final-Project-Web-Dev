<?php
session_start();
require 'db.php';

//If already logged in, then we redirect to home
if (isset($_SESSION['user_id'])) {
    header("Location: home.php");
    exit;
}

//Handling login submission
if (isset($_POST['loginBtn'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, firstname, lastname, password FROM Users WHERE email = :email");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
            

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['firstname'] = $user['firstname'];
        $_SESSION['lastname'] = $user['lastname'];
        header("Location: home.php");
        exit;
    } else {
        $error = "Invalid credentials.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>BugMe Tracker | Login</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (!empty($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="email">Email</label><br>
            <input type="email" name="email" required><br>

            <label for="password">Password</label><br>
            <input type="password" name="password" required><br>

            <button type="submit" name="loginBtn">Login</button>
        </form>
    </div>
</body>
</html>
