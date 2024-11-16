<h1>Edit Question</h1>
<div class="form-wrapper">
    <form class="form" action="/admin/update-question" method="post">
        <input type="hidden" id="id" name="id" value="<?php echo htmlspecialchars($question['id']); ?>">

        <label for="quiz_id">Select Quiz:</label>
        <select name="quiz_id" class="form-input" required>
            <?php foreach ($quizzes as $quiz): ?>
                <option value="<?php echo $quiz['id']; ?>" <?php echo ($quiz['id'] == $question['quiz_id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($quiz['title']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="question_text">Question:</label>
        <input type="text" id="question_text" name="question_text" class="form-input" value="<?php echo htmlspecialchars($question['question_text']); ?>" required>

        <label for="question_type">Select Question Type:</label>
        <select id="question_type" name="question_type" class="form-input" required>
            <option value="single choice" <?php echo ($question['question_type'] == 'single choice') ? 'selected' : ''; ?>>Single Choice</option>
            <option value="multiple choice" <?php echo ($question['question_type'] == 'multiple choice') ? 'selected' : ''; ?>>Multiple Choice</option>
        </select>

        <button type="submit" class="form-btn">Update Question</button>
    </form>
</div>
