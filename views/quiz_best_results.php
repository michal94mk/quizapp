<h1>Best Results for Quiz: <?= $quizTitle ?></h1>
<a href="/best-results/all" class="back-button">Back</a>
<table class="questions-table">
    <thead>
        <tr>
            <th>User</th>
            <th>Highest Score</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $result): ?>
        <tr>
            <td><?= $result['user_name'] ?></td>
            <td><?= $result['highest_score'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
