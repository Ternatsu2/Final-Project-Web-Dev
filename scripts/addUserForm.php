<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    exit("Unauthorized");
}
?>
<h1>New User</h1>
<form id="addUserForm">
    <label>First Name</label><br>
    <input type="text" name="firstname" required><br>

    <label>Last Name</label><br>
    <input type="text" name="lastname" required><br>

    <label>Password</label><br>
    <input type="password" name="password" required><br>

    <label>Email</label><br>
    <input type="email" name="email" required><br>

    <button type="submit">Submit</button>
</form>

<script>
console.log('[addUserForm.php] Inline script running: Setting up event listener for #addUserForm.');

document.getElementById('addUserForm').addEventListener('submit', function(e){
    e.preventDefault();

    let formData = new FormData(this);
    console.log('[addUserForm.php] Form data about to be sent:', Object.fromEntries(formData.entries()));

    // If addUserForm.php is physically inside the "scripts" folder, we omit 'scripts/' prefix
    console.log('[addUserForm.php] Initiating fetch to processAddUser.php...');
    fetch('processAddUser.php', {
        method: 'POST',
        body: formData
    })
    .then(res => {
        console.log('[addUserForm.php] fetch -> processAddUser.php status:', res.status);
        return res.text();
    })
    .then(data => {
        console.log('[addUserForm.php] Response from processAddUser.php:', data);
        alert(data);  // Show a quick alert
    })
    .catch(err => {
        console.error('[addUserForm.php] Error adding user:', err);
    });
});
</script>
