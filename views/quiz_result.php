<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Result</title>
</head>
<body>
    <h1>Quiz Result</h1>
    <p>Score: <?php echo htmlspecialchars($result['score']); ?></p>
    <p>Quiz ID: <?php echo htmlspecialchars($result['quiz_id']); ?></p>
</body>
</html>
