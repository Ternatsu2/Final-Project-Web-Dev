document.addEventListener('DOMContentLoaded', function() {
    // Filter Buttons
    let filterAll       = document.getElementById('filter-all');
    let filterOpen      = document.getElementById('filter-open');
    let filterMyTickets = document.getElementById('filter-mytickets');

    if (filterAll) {
        filterAll.addEventListener('click', () => loadIssues('all'));
    }
    if (filterOpen) {
        filterOpen.addEventListener('click', () => loadIssues('open'));
    }
    if (filterMyTickets) {
        filterMyTickets.addEventListener('click', () => loadIssues('mytickets'));
    }

    // Load Issues table on page load
    if (document.getElementById('issues-table')) {
        loadIssues('all');
    }

    // Home link
    let navHome = document.getElementById('nav-home');
    if (navHome) {
        navHome.addEventListener('click', (e) => {
            e.preventDefault();
            window.location.href = 'home.php';
        });
    }

    // Add User
    let navAddUser = document.getElementById('nav-add-user');
    if (navAddUser) {
        navAddUser.addEventListener('click', () => {
            console.log('[main.js] Loading addUserForm...');
            fetch('scripts/addUserForm.php')
            .then(res => res.text())
            .then(html => {
                document.getElementById('main-content').innerHTML = html;
                setupAddUserForm(); // Attach event
            })
            .catch(err => console.error('[main.js] Error loading addUserForm:', err));
        });
    }

    // Create New Issue button
    let createNewIssueBtn = document.getElementById('createNewIssueBtn');
    if (createNewIssueBtn) {
        createNewIssueBtn.addEventListener('click', () => {
            console.log('[main.js] Loading newIssueForm...');
            fetch('scripts/newIssueForm.php')
                .then(res => res.text())
                .then(html => {
                    document.getElementById('main-content').innerHTML = html;
                    setupNewIssueForm(); // Attach submission logic for the form
                })
                .catch(err => console.error('[main.js] Error loading newIssueForm:', err));
        });
    }
        

    
    // New Issue link
    let navNewIssue = document.getElementById('nav-new-issue');
    if (navNewIssue) {
        navNewIssue.addEventListener('click', () => {
            console.log('[main.js] Loading newIssueForm...');
            fetch('scripts/newIssueForm.php')
            .then(res => res.text())
            .then(html => {
                document.getElementById('main-content').innerHTML = html;
                setupNewIssueForm(); // Attach event
            })
            .catch(err => console.error('[main.js] Error loading newIssueForm:', err));
        });
    }
});

// =============== Setup Add User Form ===============
function setupAddUserForm() {
    let addUserForm = document.getElementById('addUserForm');
    if (!addUserForm) return;

    console.log('[main.js] Setting up addUserForm submission...');
    addUserForm.addEventListener('submit', function(e){
        e.preventDefault();
        let formData = new FormData(addUserForm);

        console.log('[addUserForm] Submitting data:', Object.fromEntries(formData.entries()));
        fetch('scripts/processAddUser.php', {
            method: 'POST',
            body: formData
        })
        .then(res => {
            console.log('[addUserForm] fetch -> processAddUser.php status:', res.status);
            return res.json(); // Expect JSON
        })
        .then(data => {
            console.log('[addUserForm] JSON response:', data);
            if (data.success) {
                alert(data.message);
                addUserForm.reset();
            } else {
                alert(data.error || 'Error adding user');
            }
        })
        .catch(err => {
            console.error('[addUserForm] Error adding user:', err);
        });
    });
}

// =============== Setup New Issue Form ===============
function setupNewIssueForm() {
    let newIssueForm = document.getElementById('newIssueForm');
    if (!newIssueForm) return;

    console.log('[main.js] Setting up newIssueForm submission...');
    newIssueForm.addEventListener('submit', function(e){
        e.preventDefault();
        let formData = new FormData(newIssueForm);

        console.log('[newIssueForm] Submitting data:', Object.fromEntries(formData.entries()));
        fetch('scripts/processNewIssue.php', {
            method: 'POST',
            body: formData
        })
        .then(res => {
            console.log('[newIssueForm] fetch -> processNewIssue.php status:', res.status);
            return res.json(); // Expect JSON
        })
        .then(data => {
            console.log('[newIssueForm] JSON response:', data);
            if (data.success) {
                alert(data.message);
                newIssueForm.reset();
                loadIssues("all");
            } else {
                alert(data.error || 'Error creating issue');
            }
        })
        .catch(err => {
            console.error('[newIssueForm] Error creating new issue:', err);
        });
    });
}

// =============== Load Issues ===============
function loadIssues(filter) {
    console.log('[main.js] loadIssues called, filter=', filter);
    fetch(`scripts/listIssues.php?filter=${filter}`)
    .then(res => res.text())
    .then(html => {
        console.log('[main.js] Issues list loaded. Updating #issues-table');
        let issuesTable = document.getElementById('issues-table');
        if (issuesTable) {
            issuesTable.innerHTML = html;
        }
    })
    .catch(err => console.error('[main.js] Error loading issues:', err));
}

// If your code also has viewIssueDetails logic, keep that as is ...
// View Issue Details
function viewIssueDetails(issueId) {
    fetch(`scripts/issueDetails.php?id=${issueId}`)
    .then(res => res.text())
    .then(html => {
        document.getElementById('main-content').innerHTML = html;
        setupIssueDetailEvents(issueId);
    })
    .catch(err => console.error(err));
}