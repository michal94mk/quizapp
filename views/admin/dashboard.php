<div class="dashboard-container">
    <div class="dashboard-box">
        <h5>Total Users</h5>
        <p><?php echo htmlspecialchars($totalUsers); ?></p>
    </div>

    <div class="dashboard-box">
        <h5>Total Quizzes</h5>
        <p><?php echo htmlspecialchars($totalQuizzes); ?></p>
    </div>

    <div class="dashboard-box">
        <h5>Total Questions</h5>
        <p><?php echo htmlspecialchars($totalQuestions); ?></p>
    </div>
</div>

<div class="dashboard-box-rq recent-quizzes">
    <h3>Recent Quizzes</h3>
    <ul>
        <?php if (!empty($recentQuizzes)): ?>
            <?php foreach ($recentQuizzes as $quiz): ?>
                <li>
                    <strong><?php echo htmlspecialchars($quiz['title']); ?></strong>
                    <p>Created on: <?php echo htmlspecialchars(date('Y-m-d', strtotime($quiz['created_at']))); ?></p>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No recent quizzes found.</p>
        <?php endif; ?>
    </ul>
</div>
