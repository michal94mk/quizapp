<div class="quizzes-wrapper">
    <h2 class="quizzes-title">Quizzes</h2>
    
    <?php if (!empty($quizzes)): ?>
        <div class="quizzes-container">
            <?php foreach ($quizzes as $quiz): ?>
                <div class="quiz-card">
                    <h3><?php echo htmlspecialchars($quiz['quiz_title']); ?></h3>
                    <p><?php echo htmlspecialchars($quiz['quiz_description']); ?></p>
                    <a href="/quiz/<?php echo $quiz['quiz_id']; ?>">
                        <button class="take-quiz-btn" role="button">Take Quiz</button>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="pagination-wrapper">
            <div class="page-input-container">
                <form action="/" method="GET" class="page-input-form">
                    <input type="number" id="page" name="page" min="1" max="<?php echo $totalPages; ?>" placeholder="Enter page" required>
                    <button class="go-button" type="submit">Go</button>
                </form>
            </div>
            
            <div class="pagination">
                <!-- Poprzednia strona -->
                <?php if ($currentPage > 1): ?>
                    <a href="/?page=<?php echo $currentPage - 1; ?>" class="prev-btn">&laquo; Previous</a>
                <?php endif; ?>

                <!-- Pierwsza strona zawsze widoczna -->
                <a href="/?page=1"<?php if ($currentPage == 1) echo ' class="active"'; ?>>1</a>

                <!-- Kropki, jeśli jesteśmy na dalszych stronach niż 4 -->
                <?php if ($currentPage > 4): ?>
                    <span class="pagination-dots">...</span>
                <?php endif; ?>

                <!-- Strony sąsiadujące z bieżącą stroną -->
                <?php
                    $start = max(2, $currentPage - 1);
                    $end = min($totalPages - 1, $currentPage + 1);
                    for ($i = $start; $i <= $end; $i++): 
                ?>
                    <a href="/?page=<?php echo $i; ?>"<?php if ($i == $currentPage) echo ' class="active"'; ?>><?php echo $i; ?></a>
                <?php endfor; ?>

                <!-- Kropki, jeśli jesteśmy przed końcowymi stronami -->
                <?php if ($currentPage < $totalPages - 3): ?>
                    <span class="pagination-dots">...</span>
                <?php endif; ?>

                <!-- Ostatnia strona zawsze widoczna -->
                <?php if ($totalPages > 1): ?>
                    <a href="/?page=<?php echo $totalPages; ?>"<?php if ($currentPage == $totalPages) echo ' class="active"'; ?>><?php echo $totalPages; ?></a>
                <?php endif; ?>

                <!-- Następna strona -->
                <?php if ($currentPage < $totalPages): ?>
                    <a href="/?page=<?php echo $currentPage + 1; ?>" class="next-btn">Next &raquo;</a>
                <?php endif; ?>

            </div>
        </div>
    
    <?php else: ?>
        <p>No quizzes available.</p>
    <?php endif; ?>
</div>
