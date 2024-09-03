    <h1>Edit Answer</h1>
    <form action="/admin/update-answer" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($answer['id']); ?>">

        <input type="hidden" name="question_id" value="<?php echo htmlspecialchars($answer['question_id']); ?>">

        <label for="answer_text">Answer Text:</label>
        <input type="text" id="answer_text" name="answer_text" value="<?php echo htmlspecialchars($answer['answer_text']); ?>" required><br><br>

        <label for="is_correct">Is Correct:</label>
        <input type="checkbox" id="is_correct" name="is_correct" value="1" <?php if ($answer['is_correct']) echo 'checked'; ?>><br><br>

        <button type="submit">Update Answer</button>
    </form>
