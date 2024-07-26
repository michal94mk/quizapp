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
            <li><a href="/">Home</a></li>
            <li><a href="/admin">Dashboard</a></li>
            <li><a href="/admin/quizzes">Quizzes</a></li>
            <li><a href="users.php">Users</a></li>
            <li><a href="statistics.php">Stats</a></li>
            <?php if (isset($_SESSION['user_id'])) { ?>
                <li><a href="/logout">Logout [ <?php echo htmlspecialchars($_SESSION['user_name']); ?> ]</a></li>
            <?php }; ?>
        </ul>
    </nav>
    <aside class="sidebar" id="sidebar">
        <nav>
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/admin">Dashboard</a></li>
                <li><a href="/admin/quizzes">Quizzes</a></li>
                <li><a href="users.php">Users</a></li>
                <li><a href="statistics.php">Stats</a></li>
                <?php if (isset($_SESSION['user_id'])) { ?>
                    <li><a href="/logout">Logout [ <?php echo htmlspecialchars($_SESSION['user_id']); ?> ]</a></li>
                <?php }; ?>
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
