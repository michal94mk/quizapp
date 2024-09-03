<h1>Add Answer</h1>
<form action="/admin/add-answer" method="post">
    <input type="hidden" name="question_id" value="<?php echo htmlspecialchars($currentQuestionId); ?>">
    <label for="answer_text">Answer Text:</label>
    <input type="text" id="answer_text" name="answer_text" required>
    <br><br>
    <label for="is_correct">Is Correct:</label>
    <input type="checkbox" id="is_correct" name="is_correct" value="1">
    <br><br>
    <button type="submit">Add Answer</button>
</form>
