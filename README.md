# BugMe: A Simple & Effective Issue Tracker

Hey there! 👋 Looking for a straightforward way to manage bugs and tasks in your projects? BugMe is a lightweight, easy-to-use issue tracker built with PHP and MySQL.

## What's BugMe All About?

BugMe is designed to be a simple and efficient solution for tracking issues in small to medium-sized projects. It provides a clean interface for creating, assigning, and managing tasks, helping teams stay organized and on top of their workflow.

Here's what makes BugMe stand out:

*   **Easy Setup:** Get up and running quickly with a simple database import and minimal configuration.
*   **User Management:** Add and manage users with different roles and permissions.
*   **Issue Tracking:** Create, assign, and track issues with clear status indicators (Open, Closed, etc.).
*   **Filtering & Sorting:** Easily filter and sort issues to focus on what's important.
*   **AJAX-Powered Interface:** Enjoy a smooth and responsive user experience with AJAX-driven filtering.

## Key Features

*   **User-Friendly Dashboard:** A clean and intuitive dashboard provides an overview of project status.
*   **Issue Creation & Management:** Easily create new issues, assign them to users, and track their progress.
*   **Status Filtering:** Quickly filter issues by status (All, Open, My Tickets) to focus on relevant tasks.
*   **Database Driven:** Stores issue and user data in a MySQL database for persistence and scalability.

## Tech Stack

BugMe is built using:

*   **PHP:** The backend logic and application framework.
*   **MySQL:** The database for storing issue and user information.
*   **HTML/CSS/JavaScript:** The frontend for a user-friendly interface.
*   **AJAX:** For dynamic filtering and a responsive user experience.
*   **XAMPP:** A convenient environment for local development and deployment.

## Setting Up BugMe (For Developers)

Want to run BugMe locally or contribute to the project? Here's how:

1.  **Get XAMPP:** Download and install XAMPP, which provides Apache and MySQL.
2.  **Place the Project:** Copy the `bugme-issue-tracker` folder into your XAMPP's `htdocs` directory (usually `C:\xampp\htdocs\`).
3.  **Create the Database:**
    *   Start Apache and MySQL in XAMPP.
    *   Open phpMyAdmin (usually at `http://localhost/phpmyadmin/`).
    *   Create a new database named `bugme`.
4.  **Import the Schema:** Import the `schema.sql` file (located in the project root) into the `bugme` database to create the necessary tables.
5.  **Configure the Database Connection:**
    *   Open the `db.php` file.
    *   Verify the database connection settings:
        ```php
        $host = 'localhost';
        $db = 'bugme';
        $user = 'root';
        $password = ''; // Change this if you have a MySQL password
        ```
    *   If you have a different MySQL password, update the `$password` variable in `db.php`.

## Using BugMe

1.  **Access the Application:** Open your web browser and go to `http://localhost/bugme-issue-tracker/index.php`.
2.  **Log In:** Use the default administrator credentials:
    *   **Email:** `admin@project2.com`
    *   **Password:** `password123`
3.  **Explore the Dashboard:** After logging in, you'll see the main dashboard (`home.php`).
4.  **Manage Users and Issues:** Use the sidebar links to add new users and create new issues.
5.  **Filter Issues:** Use the "ALL," "OPEN," and "MY TICKETS" buttons to filter the displayed issues. The filtering happens dynamically using AJAX, so the page won't reload.

## Contributing

Contributions to BugMe are welcome! Feel free to fork the repository, make changes, and submit pull requests.



Enjoy using BugMe!
