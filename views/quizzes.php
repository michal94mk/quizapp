<div class="quizzes-wrapper">
<h2 class="quizzes-title">Quizzes</h2>
<?php if (!empty($quizzes)): ?>
    <div class="quizzes-container">
        <?php foreach ($quizzes as $quiz): ?>
            <div class="quiz-card">
                <h3><?php echo htmlspecialchars($quiz['quiz_title']); ?></h3>
                <p><?php echo htmlspecialchars($quiz['quiz_description']); ?></p>
                <a href="/quiz/<?php echo $quiz['quiz_id']; ?>"><button class="take-quiz-btn" role="button">Take Quiz</button></a>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>No quizzes available.</p>
<?php endif; ?>
</div>