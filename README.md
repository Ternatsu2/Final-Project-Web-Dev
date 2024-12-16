# BugMe Issue Tracker

## Project Setup
1. Copy this project folder into `C:\xampp\htdocs\`.
2. Start Apache and MySQL in XAMPP.
3. Create the database `bugme` in phpMyAdmin.
4. Import `schema.sql` from the project root to load tables.
5. Default admin credentials:
   - **Email**: admin@project2.com
   - **Password**: password123

## Usage
- Go to http://localhost/bugme-issue-tracker/index.php to log in.
- On successful login, you'll see the dashboard (home.php).
- Use the sidebar links for "Add User" and "New Issue".
- The "ALL/OPEN/MY TICKETS" buttons filter the issues via AJAX.

## Additional Info
- DB connection: `db.php` uses `$host = 'localhost'; $db = 'bugme'; $user = 'root'; $password = '';`
- If you have a different MySQL password, update `$password` in `db.php`.

