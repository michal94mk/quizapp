    <h1>Quizzes</h1>
    <a href="/admin/add-quiz-form"><button class="btn add-btn" role="button">ADD</button></a>
<div class="quizzes-table-container">
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
                    <a href="/admin/update-quiz-form/<?php echo htmlspecialchars($quiz['id']); ?>"><button class="btn edit-btn" role="button">Edit</button></a>
                        <form action="/admin/delete-quiz" class="button-form" method="post" onsubmit="return confirm('Are you sure you want to delete this quiz?');" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($quiz['id']); ?>">
                            <button type="submit" class="btn delete-btn">Delete</button>
                        </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>