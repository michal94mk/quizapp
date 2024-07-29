<h1>Add Quiz</h1>
    <form action="/admin/add-quiz" method="post">
        <label for="title">Quiz Title:</label>
        <input type="text" id="title" name="title"><br><br>

        <label for="description">Quiz Description:</label>
        <textarea id="description" name="description"></textarea><br><br>

        <h2>Questions</h2>
        <div id="questions-container">
            <div class="question-block">
                <label for="question_text_0">Question Text:</label>
                <input type="text" id="question_text_0" name="questions[0][question_text]"><br><br>

                <label for="question_type_0">Question Type:</label>
                <select id="question_type_0" name="questions[0][question_type]">
                    <option value="multiple choice">Multiple Choice</option>
                    <option value="single choice">Single Choice</option>
                </select><br><br>

                <h3>Answers</h3>
                <div class="answers-container">
                    <div class="answer-block">
                        <label for="answer_text_0_0">Answer Text:</label>
                        <input type="text" id="answer_text_0_0" name="questions[0][answers][0][answer_text]"><br><br>

                        <label for="is_correct_0_0">Correct:</label>
                        <input type="checkbox" id="is_correct_0_0" name="questions[0][answers][0][is_correct]"><br><br>
                    </div>
                </div>
                <button type="button" onclick="addAnswer(0)">Add Answer</button>
            </div>
        </div>
        <button type="button" onclick="addQuestion()">Add Question</button><br><br>

        <button type="submit">Add Quiz</button>
    </form>

    <script>
        let questionIndex = 1;
        let answerIndex = 1;

        function addQuestion() {
            const questionsContainer = document.getElementById('questions-container');
            const questionBlock = document.createElement('div');
            questionBlock.className = 'question-block';
            questionBlock.innerHTML = `
                <label for="question_text_${questionIndex}">Question Text:</label>
                <input type="text" id="question_text_${questionIndex}" name="questions[${questionIndex}][question_text]"><br><br>

                <label for="question_type_${questionIndex}">Question Type:</label>
                <select id="question_type_${questionIndex}" name="questions[${questionIndex}][question_type]">
                    <option value="multiple choice">Multiple Choice</option>
                    <option value="single choice">Single Choice</option>
                </select><br><br>

                <h3>Answers</h3>
                <div class="answers-container">
                    <div class="answer-block">
                        <label for="answer_text_${questionIndex}_0">Answer Text:</label>
                        <input type="text" id="answer_text_${questionIndex}_0" name="questions[${questionIndex}][answers][0][answer_text]"><br><br>

                        <label for="is_correct_${questionIndex}_0">Correct:</label>
                        <input type="checkbox" id="is_correct_${questionIndex}_0" name="questions[${questionIndex}][answers][0][is_correct]"><br><br>
                    </div>
                </div>
                <button type="button" onclick="addAnswer(${questionIndex})">Add Answer</button>
            `;
            questionsContainer.appendChild(questionBlock);
            questionIndex++;
        }

        function addAnswer(questionIndex) {
            const answersContainer = document.querySelector(`.question-block:nth-child(${questionIndex + 1}) .answers-container`);
            const answerBlock = document.createElement('div');
            answerBlock.className = 'answer-block';
            answerBlock.innerHTML = `
                <label for="answer_text_${questionIndex}_${answerIndex}">Answer Text:</label>
                <input type="text" id="answer_text_${questionIndex}_${answerIndex}" name="questions[${questionIndex}][answers][${answerIndex}][answer_text]"><br><br>

                <label for="is_correct_${questionIndex}_${answerIndex}">Correct:</label>
                <input type="checkbox" id="is_correct_${questionIndex}_${answerIndex}" name="questions[${questionIndex}][answers][${answerIndex}][is_correct]"><br><br>
            `;
            answersContainer.appendChild(answerBlock);
            answerIndex++;
        }
    </script>