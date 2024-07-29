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