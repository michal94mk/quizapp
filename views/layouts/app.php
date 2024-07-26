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
                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') { ?>
                    <li><a href="/admin">Admin Panel</a></li>
                <?php }; ?>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="/logout">Logout [ <?php echo htmlspecialchars($_SESSION['user_name']) ?> ]</a></li>
                <?php else: ?>
                    <li><a href="/login-form">Login</a></li>
                    <li><a href="/register-form">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <!-- Display messages -->
    <?php if (isset($_SESSION['register_success'])): ?>
        <div class="message success">
            <?php echo htmlspecialchars($_SESSION['register_success']); ?>
            <?php unset($_SESSION['register_success']); ?>
        </div>
    <?php elseif (isset($_SESSION['register_error'])): ?>
        <div class="message error">
            <?php echo htmlspecialchars($_SESSION['register_error']); ?>
            <?php unset($_SESSION['register_error']); ?>
        </div>
    <?php elseif (isset($_SESSION['message'])): ?>
        <div class="message error">
            <?php echo htmlspecialchars($_SESSION['message']); ?>
            <?php unset($_SESSION['message']); ?>
        </div>
    <?php elseif (isset($_SESSION['login_message'])): ?>
        <div class="message success">
            <?php echo htmlspecialchars($_SESSION['login_message']); ?>
            <?php unset($_SESSION['login_message']); ?>
        </div>
    <?php elseif (isset($_SESSION['login_error'])): ?>
        <div class="message error">
            <?php echo htmlspecialchars($_SESSION['login_error']); ?>
            <?php unset($_SESSION['login_error']); ?>
        </div>
    <?php endif; ?>
    <!-- Additional messages using GET parameters -->
    <?php if (isset($_GET['message']) && $_GET['message'] === 'loggedout'): ?>
        <div class="message success">
            Logged out successfully.
            <script>window.history.replaceState({}, document.title, window.location.pathname);</script>
        </div>
    <?php elseif (isset($_GET['message']) && $_GET['message'] === 'accessdenied'): ?>
        <div class="message error">
            Access denied.
            <script>window.history.replaceState({}, document.title, window.location.pathname);</script>
        </div>
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
