<div class="quiz-wrapper">
    <h2 class="quiz-title"><?php echo htmlspecialchars($quiz['title']); ?></h2>
    <p class="quiz-description"><?php echo htmlspecialchars($quiz['description']); ?></p>

    <?php if (!empty($questions)): ?>
        <form action="/submit-quiz" method="POST">
            <input type="hidden" name="quiz_id" value="<?php echo htmlspecialchars($quiz['id']); ?>">

            <?php foreach ($questions as $index => $question): ?>
                <div class="question">
                    <label><?php echo htmlspecialchars($question['question_text']); ?></label>

                    <?php if ($question['question_type'] === 'single choice'): ?>
                        <?php foreach ($question['answers'] as $answer): ?>
                            <div class="answers">
                                <input type="radio" name="answers[<?php echo htmlspecialchars($question['id']); ?>]" value="<?php echo htmlspecialchars($answer['id']); ?>" required>
                                <?php echo htmlspecialchars($answer['answer_text']); ?>
                            </div>
                        <?php endforeach; ?>

                    <?php elseif ($question['question_type'] === 'multiple choice'): ?>
                        <div class="answers multiple-choice">
                            <?php foreach ($question['answers'] as $answer): ?>
                                <div>
                                    <input type="checkbox" name="answers[<?php echo htmlspecialchars($question['id']); ?>][]" value="<?php echo htmlspecialchars($answer['id']); ?>">
                                    <?php echo htmlspecialchars($answer['answer_text']); ?>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <?php if (isset($_SESSION['message']) && strpos($_SESSION['message'], 'Musisz wybrać przynajmniej jedną odpowiedź') !== false): ?>
                            <p class="error-message"><?php echo htmlspecialchars($_SESSION['message']); ?></p>
                            <?php unset($_SESSION['message']); ?>
                        <?php endif; ?>

                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

            <button type="submit" class="button-send">Send</button>
        </form>
    <?php else: ?>
        <p>Brak dostępnych pytań do tego quizu.</p>
    <?php endif; ?>
</div>
