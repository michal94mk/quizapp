<h1>Add Answer</h1>
<div class="form-wrapper">
    <form class="form" action="/admin/add-answer" method="post">
        <input type="hidden" name="question_id" value="<?php echo htmlspecialchars($currentQuestionId); ?>">
        
        <label for="answer_text">Answer Text:</label>
        <input type="text" id="answer_text" name="answer_text" class="form-input" required>

        <label for="is_correct">Is Correct:</label>
        <input type="checkbox" id="is_correct" name="is_correct" value="1" class="form-checkbox">

        <button type="submit" class="form-btn">Add Answer</button>
    </form>
</div>
