<h1>Add Question</h1>
<form action="/admin/add-question" method="post">
    <label for="quiz_id">Select Quiz:</label>
    <select id="quiz_id" name="quiz_id">
        <?php foreach ($quizzes as $quiz): ?>
            <option value="<?php echo htmlspecialchars($quiz['id']); ?>">
                <?php echo htmlspecialchars($quiz['title']); ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>
    
    <label for="question_text">Question Text:</label>
    <input type="text" id="question_text" name="question_text"><br><br>
    
    <label for="question_type">Question Type:</label>
    <select id="question_type" name="question_type">
        <option value="multiple choice">Multiple Choice</option>
        <option value="single choice">Single Choice</option>
    </select><br><br>
    <button type="submit">Add Question</button>
</form>
