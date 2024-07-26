<h2>Quizzes</h2>
<?php if (!empty($quizzes)): ?>
    <div class="quiz-list">
        <?php foreach ($quizzes as $quiz): ?>
            <div class="quiz-item">
                <h3><?php echo htmlspecialchars($quiz['title']); ?></h3>
                <p><?php echo htmlspecialchars($quiz['description']); ?></p>
                <a href="/quiz/<?php echo $quiz['id']; ?>">Take Quiz</a>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>No quizzes available.</p>
<?php endif; ?>
