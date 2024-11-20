<br><h2>Statystyki użytkowników</h2>
<?php if (!empty($userStats)): ?>
    <div class="users-table-container">
        <table class="users-table">
            <thead>
                <tr>
                    <th>Rola</th>
                    <th>Liczba użytkowników</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($userStats as $stat): ?>
                    <tr>
                        <td><?= htmlspecialchars($stat['role']) ?></td>
                        <td><?= htmlspecialchars($stat['user_count']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <p>Brak danych o użytkownikach.</p>
<?php endif; ?>

<div class="quiz-stats-container">
    <h2>Statystyki quizów</h2>
    <div class="quiz-stats">
        <p><strong>Liczba quizów:</strong> <?= htmlspecialchars($quizStats['quiz_count']) ?></p>
        <p><strong>Najdłuższy tytuł quizu:</strong> 
            "<?= htmlspecialchars($quizStats['longest_title']) ?>" (<?= htmlspecialchars($quizStats['longest_title_length']) ?> znaków)</p>
        <p><strong>Liczba quizów utworzonych w ostatnim miesiącu:</strong> <?= htmlspecialchars($quizStats['recent_quiz_count']) ?></p>
        <p><strong>Średnia liczba pytań na quiz:</strong> <?= htmlspecialchars(round($quizStats['avg_questions_per_quiz'], 2)) ?></p>
    </div>
</div>

<br><h3>Najpopularniejsze quizy</h3>
<?php if (!empty($topQuizzes)): ?>
    <div class="quizzes-table-container">
        <table class="quizzes-table">
            <thead>
                <tr>
                    <th>Tytuł quizu</th>
                    <th>Liczba zakończeń</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($topQuizzes as $quiz): ?>
                    <tr>
                        <td><?= htmlspecialchars($quiz['title']) ?></td>
                        <td><?= htmlspecialchars($quiz['completions']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <p>Brak danych o quizach.</p>
<?php endif; ?>

<br><h3>Ostatnie wyniki quizów</h3>
<?php if (!empty($recentResults)): ?>
    <div class="quizzes-table-container">
        <table class="quizzes-table">
            <thead>
                <tr>
                    <th>Użytkownik</th>
                    <th>Quiz</th>
                    <th>Wynik</th>
                    <th>Data zakończenia</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentResults as $result): ?>
                    <tr>
                        <td><?= htmlspecialchars($result['username']) ?></td>
                        <td><?= htmlspecialchars($result['quiz_title']) ?></td>
                        <td><?= htmlspecialchars($result['score']) ?></td>
                        <td><?= htmlspecialchars($result['completed_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <p>Brak wyników quizów.</p>
<?php endif; ?>

<br><h3>Wykres ukończeń quizów w czasie</h3>
<div class="chart-container">
    <canvas id="dailyCompletionsChart"></canvas>
</div>

<h3>Wykres wyników quizów</h3>
<div class="chart-container">
    <canvas id="quizPerformanceChart"></canvas>
</div>

<div class="clear"></div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const dailyCompletionsData = <?= json_encode($dailyCompletions) ?>;
    const quizPerformanceData = <?= json_encode($quizPerformance) ?>;

    const dailyCompletionsChart = new Chart(document.getElementById('dailyCompletionsChart'), {
        type: 'line',
        data: {
            labels: dailyCompletionsData.map(item => item.date),
            datasets: [{
                label: 'Ukończenia quizów',
                data: dailyCompletionsData.map(item => item.completions),
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                fill: false
            }]
        }
    });

    const quizPerformanceChart = new Chart(document.getElementById('quizPerformanceChart'), {
        type: 'bar',
        data: {
            labels: quizPerformanceData.map(item => item.title),
            datasets: [{
                label: 'Średni wynik',
                data: quizPerformanceData.map(item => item.avg_score),
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        }
    });
</script>
