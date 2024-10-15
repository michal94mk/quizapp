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
<?php if (isset($currentPage)): ?>
    <div class="pagination">
        <?php if ($currentPage > 1): ?>
            <a href="/?page=<?php echo $currentPage - 1; ?>">&laquo; Previous</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="/?page=<?php echo $i; ?>"<?php if ($i == $currentPage) echo ' class="active"'; ?>><?php echo $i; ?></a>
        <?php endfor; ?>

        <?php if ($currentPage < $totalPages): ?>
            <a href="/?page=<?php echo $currentPage + 1; ?>">Next &raquo;</a>
        <?php endif; ?>
    </div>
<?php endif; ?>