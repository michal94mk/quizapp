<h1>Add Question</h1>
<div class="form-wrapper">
    <form class="form" action="/admin/add-question" method="post">
        <label for="quiz_id">Select Quiz:</label>
        <select name="quiz_id" class="form-input" required>
            <?php foreach ($quizzes as $quiz): ?>
                <option value="<?php echo $quiz['id']; ?>"><?php echo htmlspecialchars($quiz['title']); ?></option>
            <?php endforeach; ?>
        </select>

        <label for="question_text">Question:</label>
        <input type="text" id="question_text" name="question_text" class="form-input" required>

        <label for="question_type">Select Question Type:</label>
        <select id="question_type" name="question_type" class="form-input" required>
            <option value="single choice">Single Choice</option>
            <option value="multiple choice">Multiple Choice</option>
        </select>

        <button type="submit" class="form-btn">Add Question</button>
    </form>
</div>
