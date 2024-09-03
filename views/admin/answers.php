<h1>Answers</h1>
<div class="questions-table-container">
<div class="add-answer-container">
    <a href="/admin/add-answer-form/<?php echo htmlspecialchars($currentQuestionId); ?>">
        <button class="btn add-btn" role="button">Add Answer</button>
    </a>
</div>
    <table class="questions-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Question ID</th>
                <th>Answer text</th>
                <th>Is correct</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($answers as $answer): ?>
                <tr>
                    <td><?php echo htmlspecialchars($answer['id']); ?></td>
                    <td><?php echo htmlspecialchars($answer['question_id']); ?></td>
                    <td><?php echo htmlspecialchars($answer['answer_text']); ?></td>
                    <td><?php echo htmlspecialchars($answer['is_correct']); ?></td>
                    <td>
                        <a href="/admin/update-answer-form/<?php echo htmlspecialchars($answer['id']); ?>">
                            <button class="btn edit-btn" role="button">Edit</button>
                        </a>
                        <form action="/admin/delete-answer" class="button-form" method="post" onsubmit="return confirm('Are you sure you want to delete this answer?');" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($answer['id']); ?>">
                            <input type="hidden" name="question_id" value="<?php echo htmlspecialchars($answer['question_id']); ?>">
                            <button type="submit" class="btn delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
