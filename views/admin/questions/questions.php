<h1>Questions</h1>
<a href="/admin/add-question-form"><button class="btn add-btn" role="button">ADD</button></a>
<div class="questions-table-container">
    <table class="questions-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Quiz title</th>
                <th>Question text</th>
                <th>Question type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($questions as $question): ?>
                <tr>
                    <td><?php echo htmlspecialchars($question['id']); ?></td>
                    <td><?php echo htmlspecialchars($question['quiz_title']); ?></td>
                    <td><?php echo htmlspecialchars($question['question_text']); ?></td>
                    <td><?php echo htmlspecialchars($question['question_type']); ?></td>
                    <td>
                        <a href="/admin/update-question-form/<?php echo htmlspecialchars($question['id']); ?>">
                            <button class="btn edit-btn" role="button">Edit</button>
                        </a>
                        <a href="/admin/answers/<?php echo htmlspecialchars($question['id']); ?>">
                            <button class="btn edit-btn" role="button">Answers</button>
                        </a>
                        <form action="/admin/delete-question" class="button-form" method="post" onsubmit="return confirm('Are you sure you want to delete this question?');" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($question['id']); ?>">
                            <button type="submit" class="btn delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php if (isset($currentPage)): ?>
    <div class="pagination">
        <?php if ($currentPage > 1): ?>
            <a href="/admin/questions?page=<?php echo $currentPage - 1; ?>">&laquo; Previous</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="/admin/questions?page=<?php echo $i; ?>"<?php if ($i == $currentPage) echo ' class="active"'; ?>><?php echo $i; ?></a>
        <?php endfor; ?>

        <?php if ($currentPage < $totalPages): ?>
            <a href="/admin/questions?page=<?php echo $currentPage + 1; ?>">Next &raquo;</a>
        <?php endif; ?>
    </div>
<?php endif; ?>
