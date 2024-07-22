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
        <nav>
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/about">About</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="/logout">Logout [ <?php echo htmlspecialchars($_SESSION['user_id']); ?> ]</a></li>
                <?php else: ?>
                    <li><a href="/login-form">Login</a></li>
                    <li><a href="/register-form">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <?php if (isset($_GET['message'])): ?>
        <div class="message-container">
            <?php
            $message = $_GET['message'];
            if ($message === 'loggedin') {
                echo '<div class="message success">Zalogowano pomyślnie.</div>';
            } elseif ($message === 'loggedout') {
                echo '<div class="message success">Wylogowano pomyślnie.</div>';
            }
            ?>
        </div>
        <script>
            window.history.replaceState({}, document.title, window.location.pathname);
        </script>
    <?php endif; ?>

    <main>
        <div class="container">
            <?php if (isset($content) && !empty($content)): ?>
                <?php echo $content; ?>
            <?php else: ?>
                <p>No content available.</p>
            <?php endif; ?>
        </div>
    </main>
    <footer>
        <p>Footer content here</p>
    </footer>
</body>
</html>
