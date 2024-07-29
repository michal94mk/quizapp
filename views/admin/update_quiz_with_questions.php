<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Quiz</title>
</head>
<body>
    <h1>Edit Quiz</h1>
    <form action="/admin/update-quiz" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($quiz['id']); ?>">

        <label for="title">Quiz Title:</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($quiz['title']); ?>"><br><br>

        <label for="description">Quiz Description:</label>
        <textarea id="description" name="description"><?php echo htmlspecialchars($quiz['description']); ?></textarea><br><br>

        <h2>Questions</h2>

        <?php foreach ($questions as $questionIndex => $question): ?>
            <div class="question-block">
                <input type="hidden" name="questions[<?php echo $questionIndex; ?>][id]" value="<?php echo htmlspecialchars($question['id']); ?>">

                <label for="question_text_<?php echo $questionIndex; ?>">Question Text:</label>
                <input type="text" id="question_text_<?php echo $questionIndex; ?>" name="questions[<?php echo $questionIndex; ?>][question_text]" value="<?php echo htmlspecialchars($question['question_text']); ?>"><br><br>

                <label for="question_type_<?php echo $questionIndex; ?>">Question Type:</label>
                <select id="question_type_<?php echo $questionIndex; ?>" name="questions[<?php echo $questionIndex; ?>][question_type]">
                    <option value="multiple choice" <?php echo $question['question_type'] == 'multiple choice' ? 'selected' : ''; ?>>Multiple Choice</option>
                    <option value="single choice" <?php echo $question['question_type'] == 'single choice' ? 'selected' : ''; ?>>Single Choice</option>
                </select><br><br>

                <h3>Answers</h3>
                <?php foreach ($question['answers'] as $answerIndex => $answer): ?>
                    <div class="answer-block">
                        <input type="hidden" name="questions[<?php echo $questionIndex; ?>][answers][<?php echo $answerIndex; ?>][id]" value="<?php echo htmlspecialchars($answer['id']); ?>">

                        <label for="answer_text_<?php echo $questionIndex; ?>_<?php echo $answerIndex; ?>">Answer Text:</label>
                        <input type="text" id="answer_text_<?php echo $questionIndex; ?>_<?php echo $answerIndex; ?>" name="questions[<?php echo $questionIndex; ?>][answers][<?php echo $answerIndex; ?>][answer_text]" value="<?php echo htmlspecialchars($answer['answer_text']); ?>"><br><br>

                        <label for="is_correct_<?php echo $questionIndex; ?>_<?php echo $answerIndex; ?>">Correct:</label>
                        <input type="checkbox" id="is_correct_<?php echo $questionIndex; ?>_<?php echo $answerIndex; ?>" name="questions[<?php echo $questionIndex; ?>][answers][<?php echo $answerIndex; ?>][is_correct]" <?php echo $answer['is_correct'] ? 'checked' : ''; ?>><br><br>
                    </div>
                <?php endforeach; ?>
            </div>
            <hr>
        <?php endforeach; ?>

        <button type="submit">Update Quiz</button>
    </form>
</body>
</html>
