<?php

namespace App\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\Answer;
use App\Models\UserAnswer;
use App\Models\UserQuizResult;
use App\Helper\PathHelper;
use App\View\View;

class QuizController {
    public function showAllQuizzes() {
        $quizModel = new Quiz();
        $quizzes = $quizModel->getAllQuizzes();

        $view = new View(
            PathHelper::view('quizzes.php'),
            PathHelper::layout('app.php')
        );

        $view->with([
            'title' => 'Quizzes',
            'quizzes' => $quizzes
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
    
    public function showQuizResult($quiz_id) {
        $user_id = $_SESSION['user_id'];
    
        $userQuizResult = new UserQuizResult();
        $result = $userQuizResult->getResult($user_id, $quiz_id);
    
        $view = new View(
            PathHelper::view('quiz_result.php'),
            PathHelper::layout('app.php')
        );
    
        $view->with([
            'title' => 'Quiz Result',
            'result' => $result
        ])->render();
    }
}
