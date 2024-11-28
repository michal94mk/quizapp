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
            <?php if (!empty($results)): ?>
                <?php foreach ($results as $result): ?>
                    <tr>
                        <td><?= htmlspecialchars($result['username']) ?></td>
                        <td><?= htmlspecialchars($result['score']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2">No results found for this quiz.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
