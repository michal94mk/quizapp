<h1>Best results for quiz: <?= htmlspecialchars($quizTitle) ?></h1>
<a href="/best-results/all" class="back-button">Back</a>
<div class="best-results-table-container">
    <table class="best-results-table">
        <thead>
            <tr>
                <th>User</th>
                <th>Highest score</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $result): ?>
            <tr>
                <td><?= htmlspecialchars($result['user_name']) ?></td>
                <td><?= htmlspecialchars($result['highest_score']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
