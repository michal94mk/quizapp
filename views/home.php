<h2>Quizzes</h2>
<?php if (!empty($quizzes)): ?>
    <div class="quiz-container">
        <?php foreach ($quizzes as $quiz): ?>
            <div class="quiz-card">
                <div class="quiz-title"><?php echo htmlspecialchars($quiz['title']); ?></div>
                <div class="quiz-description"><?php echo htmlspecialchars($quiz['description']); ?></div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>No quizzes available.</p>
<?php endif; ?>