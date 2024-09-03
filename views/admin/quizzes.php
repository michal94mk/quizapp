<h1>Quizzes</h1>
<a href="/admin/add-quiz-form"><button class="btn add-btn" role="button">ADD</button></a>
<div class="quizzes-table-container">
    <table class="quizzes-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Number of questions</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($quizzes as $quiz): ?>
                <tr>
                    <td><?php echo htmlspecialchars($quiz['quiz_id']); ?></td>
                    <td><?php echo htmlspecialchars($quiz['quiz_title']); ?></td>
                    <td><?php echo htmlspecialchars($quiz['quiz_description']); ?></td>
                    <td><?php echo htmlspecialchars($quiz['question_count']); ?></td>
                    <td>
                        <a href="/admin/update-quiz-form/<?php echo htmlspecialchars($quiz['quiz_id']); ?>">
                            <button class="btn edit-btn" role="button">Edit</button>
                        </a>
                        <form action="/admin/delete-quiz" class="button-form" method="post" onsubmit="return confirm('Are you sure you want to delete this quiz?');" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($quiz['quiz_id']); ?>">
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
            <a href="/admin/quizzes?page=<?php echo $currentPage - 1; ?>">&laquo; Previous</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="/admin/quizzes?page=<?php echo $i; ?>"<?php if ($i == $currentPage) echo ' class="active"'; ?>><?php echo $i; ?></a>
        <?php endfor; ?>

        <?php if ($currentPage < $totalPages): ?>
            <a href="/admin/quizzes?page=<?php echo $currentPage + 1; ?>">Next &raquo;</a>
        <?php endif; ?>
    </div>
<?php endif; ?>
