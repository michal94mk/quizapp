<h1>Top 10 Results</h1>
<div class="quiz-select">
    <form method="GET" action="/best-results/quiz/">
        <label for="quiz" class="quiz-label">Select a quiz:</label>
        <select name="quiz_id" id="quiz" class="quiz-select-input" required>
            <option value="">-- Select a quiz --</option>
            <?php foreach ($quizzes as $quiz): ?>
                <option value="<?= $quiz['id'] ?>" <?= $quiz['id'] == $selectedQuizId ? 'selected' : '' ?>>
                    <?= htmlspecialchars($quiz['title'], ENT_QUOTES, 'UTF-8') ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="quiz-button">Show Results</button>
    </form>
</div>

<div class="quizzes-table-container">
    <table class="quizzes-table">
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
                        <td><?= htmlspecialchars($result['username']) ?></td>
                        <td><?= htmlspecialchars($result['score']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No results found for the selected quiz.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
