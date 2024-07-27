<div class="container">
        <main class="main-content">
            <h1>Quizzes</h1>
            <a href="/admin/add-quiz-form" class="add-btn">Add New Quiz</a>
            <table class="quizzes-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($quizzes as $quiz): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($quiz['id']); ?></td>
                        <td><?php echo htmlspecialchars($quiz['title']); ?></td>
                        <td><?php echo htmlspecialchars($quiz['description']); ?></td>
                        <td><?php echo htmlspecialchars(date('Y-m-d H:i:s', strtotime($quiz['created_at']))); ?></td>
                        <td>
                        <a href="/admin/update-quiz-form/<?php echo htmlspecialchars($quiz['id']); ?>">Edit</a>
                        <form action="/admin/delete-quiz" method="post" onsubmit="return confirm('Are you sure you want to delete this quiz?');">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($quiz['id']); ?>">
                            <input type="submit" value="Delete">
                        </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>