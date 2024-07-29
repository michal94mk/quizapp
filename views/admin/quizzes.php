<div>
    <div><h1>Quizzes</h1></div>
    <div><a href="/admin/add-quiz-form"><button class="add-btn" role="button">ADD</button></a></div>
</div>
<div>
    <table class="quizzes-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($quizzes as $quiz): ?>
            <tr>
                <td><?php echo htmlspecialchars($quiz['id']); ?></td>
                <td><?php echo htmlspecialchars($quiz['title']); ?></td>
                <td><?php echo htmlspecialchars($quiz['description']); ?></td>
                <td>
                    <a href="/admin/update-quiz-form/<?php echo htmlspecialchars($quiz['id']); ?>">Edit</a>
                    <form action="/admin/delete-quiz" method="post" onsubmit="return confirm('Are you sure you want to delete this quiz?');" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($quiz['id']); ?>">
                        <input type="submit" value="Delete">
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
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