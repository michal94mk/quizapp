    <h1>Edit Question</h1>
    <form action="/admin/update-question" method="post">
        <input type="hidden" id="id" name="id" value="<?php echo htmlspecialchars($question['id']); ?>">
        <label for="quiz_id">Wybierz Quiz:</label>
        <select name="quiz_id" required>
            <?php foreach ($quizzes as $quiz): ?>
                <option value="<?php echo $quiz['id']; ?>"><?php echo htmlspecialchars($quiz['title']); ?></option>
            <?php endforeach; ?>
        </select><br>
        <label for="question_text">Question:</label>
        <input type="text" id="question_text" name="question_text" value="<?php echo htmlspecialchars($question['question_text']); ?>"><br><br>

        <label for="question_type">Wybierz typ pytania:</label>
            <select id="question_type" name="question_type" required>
                <option value="single choice">Single Choice</option>
                <option value="multiple choice">Multiple Choice</option>
            </select>
        <br><br>
        <button type="submit">Update Question</button>
    </form>