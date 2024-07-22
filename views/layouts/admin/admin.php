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
            <li><a href="/admin/quizzes">Quizzes</a></li>
            <li><a href="users.php">Users</a></li>
            <li><a href="statistics.php">Stats</a></li>
        </ul>
    </nav>
    <aside class="sidebar" id="sidebar">
        <nav>
            <ul>
                <li><a href="/admin">Dashboard</a></li>
                <li><a href="/admin/quizzes">Quizzes</a></li>
                <li><a href="users.php">Users</a></li>
                <li><a href="statistics.php">Stats</a></li>
            </ul>
        </nav>
    </aside>
    <main>
        <div class="container">
            <?php if (isset($content) && !empty($content)): ?>
                <?php echo $content; ?>
            <?php else: ?>
                <p>No content available.</p>
            <?php endif; ?>
        </div>
    </main>
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
