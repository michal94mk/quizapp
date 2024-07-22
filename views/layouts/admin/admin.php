<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title ?? 'Default Title'); ?></title>
    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body>
    <header>
        <div class="navbar">
            <div class="logo">Admin Panel</div>
            <div class="user-info">
                <span>Welcome, Admin</span>
                <a href="logout.php">Logout</a>
            </div>
            <button class="toggle-btn" id="toggle-btn">
                <div class="hamburger-icon">
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                </div>
            </button>
        </div>
    </header>
    <nav class="horizontal-nav">
        <ul>
            <li><a href="/admin">Dashboard</a></li>
            <li><a href="quizzes.php">Quizzes</a></li>
            <li><a href="users.php">Users</a></li>
            <li><a href="statistics.php">Stats</a></li>
        </ul>
    </nav>
    <aside class="sidebar" id="sidebar">
        <nav>
            <ul>
                <li><a href="/admin">Dashboard</a></li>
                <li><a href="quizzes.php">Quizzes</a></li>
                <li><a href="users.php">Users</a></li>
                <li><a href="statistics.php">Stats</a></li>
            </ul>
        </nav>
    </aside>
    <div class="container">
        <main class="main-content">
            <h1>Dashboard</h1>
            <div class="stats-container">
                <div class="card">
                    <h2>Users</h2>
                    <p>Total number: 1200</p>
                    <p>New users (last 7 days): 30</p>
                    <p>Active users: 150</p>
                </div>
                <div class="card">
                    <h2>Quizzes</h2>
                    <p>Total number: 45</p>
                    <p>Newest quizzes: Quiz A, Quiz B, Quiz C</p>
                    <p>Most frequently taken: Quiz X, Quiz Y</p>
                </div>
                <div class="card">
                    <h2>Quiz Statistics</h2>
                    <p>Average score: 75%</p>
                    <p>Highest score: 100%</p>
                    <p>Lowest score: 50%</p>
                    <p>Average time: 15 min</p>
                </div>
            </div>
            <div class="recent-activity">
                <h2>Recent Activities</h2>
                <ul>
                    <li>User Janek completed Quiz X - score 80%</li>
                    <li>User Anna completed Quiz Y - score 90%</li>
                    <li>Admin added new Quiz Z</li>
                </ul>
            </div>
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#toggle-btn').on('click', function() {
            $('#sidebar').toggleClass('active');
        });
    });
    </script>
</body>
</html>
