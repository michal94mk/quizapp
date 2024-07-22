<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title ?? 'Default Title'); ?></title>
</head>
<body>
    <header>
        <h1><?php echo htmlspecialchars($header ?? 'Default Header'); ?></h1>
    </header>
    <main>
        <?php echo $content; ?>
    </main>
    <footer>
        <p>Footer content here</p>
    </footer>
</body>
</html>
