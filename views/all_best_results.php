<h1>Best results</h1>
<div class="quiz-select">
<form method="GET" action="/best-results/quiz/">
    <label for="quiz">Select a quiz:</label>
    <select name="quiz_id" id="quiz">
        <option value="">-- Select a quiz --</option>
        <?php foreach ($quizzes as $quiz): ?>
            <option value="<?= $quiz['id'] ?>" <?= $quiz['id'] == $selectedQuizId ? 'selected' : '' ?>>
                <?= $quiz['title'] ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Show Results</button>
</form>
</div>
<div class="questions-table-container">
<table class="questions-table">
    <thead>
        <tr>
            <th>Quiz Title</th>
            <th>User Name</th>
            <th>Highest Score</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($results)): ?>
            <?php foreach ($results as $result): ?>
                <tr>
                    <td><?= htmlspecialchars($result['quiz_title']) ?></td>
                    <td><?= htmlspecialchars($result['user_name']) ?></td>
                    <td><?= htmlspecialchars($result['highest_score']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">No results found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
</div>


