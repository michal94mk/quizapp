<h2>Quizzes</h2>
<?php if (!empty($quizzes)): ?>
    <ul>
        <?php foreach ($quizzes as $quiz): ?>
            <li><?php echo htmlspecialchars($quiz['title']); ?></li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No quizzes available.</p>
<?php endif; ?>
