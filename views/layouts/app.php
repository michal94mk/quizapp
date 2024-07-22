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
            </ul>
        </nav>
    </header>
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
