<?php

namespace App\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\Answer;
use App\Models\UserAnswer;
use App\Models\UserQuizResult;
use App\View\View;
use App\Helper\PathHelper;

class QuizController {
    public function showAllQuizzes($page = 1) {
            $quizModel = new Quiz();
            $quizzesPerPage = 9;
            $offset = ($page - 1) * $quizzesPerPage;
            $quizzes = $quizModel->getAllQuizzesPaginated($quizzesPerPage, $offset);
            $totalQuizzes = $quizModel->getQuizCount();
            $totalPages = ceil($totalQuizzes / $quizzesPerPage);

        $view = new View(
            PathHelper::view('quizzes.php'),
            PathHelper::layout('app.php')
        );

        $view->with([
            'title' => 'List of Quizzes',
            'quizzes' => $quizzes,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ])->render();
    }

    public function showQuiz($id) {        
        $quizModel = new Quiz();
        $questionModel = new Question();
        $answerModel = new Answer();
        
        $quiz = $quizModel->getQuizById($id);
        $questions = $questionModel->getQuestionsByQuizId($id);
    
        if (!is_array($quiz) || !is_array($questions)) {
            throw new \Exception('Error: Invalid data format.');
        }
    
        if (isset($questions[0]) && !is_array($questions[0])) {
            throw new \Exception('Expected $questions to be an array of arrays.');
        }
    
        foreach ($questions as &$question) {
            if (isset($question['id'])) {
                $question['answers'] = $answerModel->getAnswersByQuestionId($question['id']);
            } else {
                throw new \Exception('Expected question to have an id.');
            }
        }
    
        $view = new View(
            PathHelper::view('quiz.php'),
            PathHelper::layout('app.php')
        );
        $view->with([
            'title' => $quiz['title'],
            'quiz' => $quiz,
            'questions' => $questions
        ])->render();
    }

    public function showQuizResult($id) {
        $user_id = $_SESSION['user_id'];
    
        $userQuizResult = new UserQuizResult();
        $result = $userQuizResult->getResult($user_id, $id);
    
        $view = new View(
            PathHelper::view('quiz_result.php'),
            PathHelper::layout('app.php')
        );
    
        $view->with([
            'title' => 'Quiz Result',
            'result' => $result
        ])->render();
    }


    public function submitQuiz() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['message'] = 'Aby wysłać quiz musisz się zalogować';
            header("Location: /login-form");
            exit();
        }
    
        $user_id = $_SESSION['user_id'];
        $quiz_id = $_POST['quiz_id'];
        $user_answers = $_POST['answers'] ?? [];
    
        $questionsModel = new Question();
        $questions = $questionsModel->getQuestionsByQuizId($quiz_id);
        $multipleChoiceQuestions = array_filter($questions, function($question) {
            return $question['question_type'] === 'multiple choice';
        });
    
        foreach ($multipleChoiceQuestions as $question) {
            $question_id = $question['id'];
            if (empty($user_answers[$question_id])) {
                $_SESSION['message'] = "Musisz wybrać przynajmniej jedną odpowiedź dla pytania: " . htmlspecialchars($question['question_text']);
                header("Location: /quiz/$quiz_id");
                exit();
            }
        }
    
        $totalQuestions = 0;
        $correctAnswers = 0;
    
        $answerModel = new Answer();
    
        foreach ($user_answers as $question_id => $answer_ids) {
            $totalQuestions++;
            $isCorrect = true;
            if (!is_array($answer_ids)) {
                $answer_ids = [$answer_ids];
            }
            foreach ($answer_ids as $answer_id) {
                $userAnswer = new UserAnswer();
                $userAnswer->user_id = $user_id;
                $userAnswer->question_id = $question_id;
                $userAnswer->answer_id = $answer_id;
                $userAnswer->save();
    
                $answer = $answerModel->find($answer_id);
                if (!$answer['is_correct']) {
                    $isCorrect = false;
                }
            }
            if ($isCorrect) {
                $correctAnswers++;
            }
        }
    
        $score = ($correctAnswers / $totalQuestions) * 100;
    
        $userQuizResult = new UserQuizResult();
        $userQuizResult->user_id = $user_id;
        $userQuizResult->quiz_id = $quiz_id;
        $userQuizResult->score = $score;
        $userQuizResult->createResult($user_id, $quiz_id, $score);
    
        header("Location: /quiz-result/$quiz_id");
        exit();
    }

    public function addQuizForm() {
        $view = new View(
            PathHelper::view('admin/add_quiz.php'),
            PathHelper::layout('admin/admin.php')
        );

        $view->with([
            'title' => 'Add Quiz'
        ])->render();
    }

    public function addQuiz() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $quizModel = new Quiz();
            $quizModel->create($title, $description);
        }

        header('Location: /admin/quizzes');
    }
    
    public function updateQuizForm($id) {
        $quizModel = new Quiz();
        $questionModel = new Question();
        $answerModel = new Answer();

        $quiz = $quizModel->getQuizById($id);
        $questions = $questionModel->getQuestionsByQuizId($id);

        foreach ($questions as $index => $question) {
            $questions[$index]['answers'] = $answerModel->getAnswersByQuestionId($question['id']);
        }

        $view = new View(
            PathHelper::view('admin/update_quiz_with_questions.php'),
            PathHelper::layout('admin/admin.php')
        );

        $view->with([
            'title' => 'Edit Quiz',
            'quiz' => $quiz,
            'questions' => $questions
        ])->render();
    }

    public function deleteQuiz() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];

            $quizModel = new Quiz();
            if ($quizModel->delete($id)) {
                echo "Successfully deleted quiz ID: " . htmlspecialchars($id);
                header("Location: /admin/quizzes");
                exit();
            } else {
                echo "Error deleting quiz.";
            }
        }
    }
}
