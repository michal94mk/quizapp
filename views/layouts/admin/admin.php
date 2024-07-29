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
            <li><a href="/admin/users">Users</a></li>
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
                <li><a href="/admin/users">Users</a></li>
                <li><a href="statistics.php">Stats</a></li>
                <?php if (isset($_SESSION['user_id'])) { ?>
                    <li><a href="/logout">Logout [ <?php echo htmlspecialchars($_SESSION['user_id']); ?> ]</a></li>
                <?php }; ?>
            </ul>
        </nav>
    </aside>
    <main>
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert">
            <?php echo $_SESSION['message']; ?>
            <?php unset($_SESSION['message']); ?>
        </div>
    <?php endif; ?>
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

        // Custom script for form handling (if needed)
        let questionIndex = 1;
        let answerIndex = 1;

        function addQuestion() {
            const questionsContainer = document.getElementById('questions-container');
            const questionBlock = document.createElement('div');
            questionBlock.className = 'question-block';
            questionBlock.innerHTML = `
                <label for="question_text_${questionIndex}">Question Text:</label>
                <input type="text" id="question_text_${questionIndex}" name="questions[${questionIndex}][question_text]">

                <label for="question_type_${questionIndex}">Question Type:</label>
                <select id="question_type_${questionIndex}" name="questions[${questionIndex}][question_type]">
                    <option value="multiple choice">Multiple Choice</option>
                    <option value="single choice">Single Choice</option>
                </select>

                <h3>Answers</h3>
                <div class="answers-container">
                    <div class="answer-block">
                        <label for="answer_text_${questionIndex}_0">Answer Text:</label>
                        <input type="text" id="answer_text_${questionIndex}_0" name="questions[${questionIndex}][answers][0][answer_text]">

                        <label for="is_correct_${questionIndex}_0">Correct:</label>
                        <input type="checkbox" id="is_correct_${questionIndex}_0" name="questions[${questionIndex}][answers][0][is_correct]">
                    </div>
                </div>
                <button type="button" onclick="addAnswer(${questionIndex})">Add Answer</button>
            `;
            questionsContainer.appendChild(questionBlock);
            questionIndex++;
        }

        function addAnswer(questionIndex) {
            const answersContainer = document.querySelector(`.question-block:nth-child(${questionIndex + 1}) .answers-container`);
            const answerBlock = document.createElement('div');
            answerBlock.className = 'answer-block';
            answerBlock.innerHTML = `
                <label for="answer_text_${questionIndex}_${answerIndex}">Answer Text:</label>
                <input type="text" id="answer_text_${questionIndex}_${answerIndex}" name="questions[${questionIndex}][answers][${answerIndex}][answer_text]">

                <label for="is_correct_${questionIndex}_${answerIndex}">Correct:</label>
                <input type="checkbox" id="is_correct_${questionIndex}_${answerIndex}" name="questions[${questionIndex}][answers][${answerIndex}][is_correct]">
            `;
            answersContainer.appendChild(answerBlock);
            answerIndex++;
        }
    });
    </script>
</body>
</html>
