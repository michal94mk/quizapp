<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        header {
            background: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }
        .content {
            padding: 20px;
            background: #fff;
            margin-top: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <header>
        <h1><?php echo htmlspecialchars($title); ?></h1>
    </header>
    <div class="container">
        <div class="content">
            <p><?php echo htmlspecialchars($content); ?></p>
        </div>
    </div>
</body>
</html>
