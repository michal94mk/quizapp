<h1>Questions</h1>
<a href="/admin/add-question-form">
    <button class="btn add-btn" role="button">ADD</button>
</a>
<div class="questions-table-container">
    <table class="questions-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Quiz title</th>
                <th>Question text</th>
                <th>Question type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($questions as $question): ?>
                <tr>
                    <td><?php echo htmlspecialchars($question['id']); ?></td>
                    <td><?php echo htmlspecialchars($question['quiz_title']); ?></td>
                    <td><?php echo htmlspecialchars($question['question_text']); ?></td>
                    <td><?php echo htmlspecialchars($question['question_type']); ?></td>
                    <td class="actions-column">
                        <a href="/admin/update-question-form/<?php echo htmlspecialchars($question['id']); ?>">
                            <button class="btn edit-btn" role="button">Edit</button>
                        </a>
                        <a href="/admin/answers/<?php echo htmlspecialchars($question['id']); ?>">
                            <button class="btn edit-btn" role="button">Answers</button>
                        </a>
                        <form 
                            action="/admin/delete-question" 
                            class="button-form" 
                            method="post" 
                            onsubmit="return confirm('Are you sure you want to delete this question?');" 
                            style="display:inline;"
                        >
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($question['id']); ?>">
                            <button type="submit" class="btn delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="pagination-wrapper">
    <br>
    <div class="page-input-container">
        <form action="/admin/questions" method="GET" class="page-input-form">
            <input 
                type="number" 
                id="page" 
                name="page" 
                min="1" 
                max="<?php echo $totalPages; ?>" 
                placeholder="Enter page" 
                required
            >
            <button class="go-button" type="submit">Go</button>
        </form>
    </div>
    
    <div class="pagination">
        <!-- Poprzednia strona -->
        <?php if ($currentPage > 1): ?>
            <a href="/admin/questions?page=<?php echo $currentPage - 1; ?>" class="prev-btn">&laquo; Previous</a>
        <?php endif; ?>

        <!-- Pierwsza strona zawsze widoczna -->
        <a 
            href="/admin/questions?page=1"
            <?php if ($currentPage == 1) echo ' class="active"'; ?>
        >1</a>

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
            <a 
                href="/admin/questions?page=<?php echo $i; ?>"
                <?php if ($i == $currentPage) echo ' class="active"'; ?>
            ><?php echo $i; ?></a>
        <?php endfor; ?>

        <!-- Kropki, jeśli jesteśmy przed końcowymi stronami -->
        <?php if ($currentPage < $totalPages - 3): ?>
            <span class="pagination-dots">...</span>
        <?php endif; ?>

        <!-- Ostatnia strona zawsze widoczna -->
        <?php if ($totalPages > 1): ?>
            <a 
                href="/admin/questions?page=<?php echo $totalPages; ?>"
                <?php if ($currentPage == $totalPages) echo ' class="active"'; ?>
            ><?php echo $totalPages; ?></a>
        <?php endif; ?>

        <!-- Następna strona -->
        <?php if ($currentPage < $totalPages): ?>
            <a href="/admin/questions?page=<?php echo $currentPage + 1; ?>" class="next-btn">Next &raquo;</a>
        <?php endif; ?>
    </div>
</div>
<br>
