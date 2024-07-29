<div class="container">
        <main class="main-content">
            <h1>Questions</h1>
            <a href="/admin/add-question-form" class="add-btn">Add New Question</a>
            <table class="questions-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Quiz ID</th>
                        <th>Question Text</th>
                        <th>Question Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($questions as $question): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($question['id']); ?></td>
                        <td><?php echo htmlspecialchars($question['quiz_id']); ?></td>
                        <td><?php echo htmlspecialchars($question['question_text']); ?></td>
                        <td><?php echo htmlspecialchars($question['question_type']); ?></td>
                        <td>
                        <a href="/admin/update-quiz-form/<?php echo htmlspecialchars($question['id']); ?>">Edit</a>
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