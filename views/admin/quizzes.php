<div class="container">
        <main class="main-content">
            <h1>Quizzes</h1>
            <a href="add_quiz.php" class="add-btn">Add New Quiz</a>
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
                            <a href="edit_quiz.php?id=<?php echo htmlspecialchars($quiz['id']); ?>">Edit</a> |
                            <a href="delete_quiz.php?id=<?php echo htmlspecialchars($quiz['id']); ?>" onclick="return confirm('Are you sure you want to delete this quiz?');">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>