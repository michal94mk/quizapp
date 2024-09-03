<?php

namespace App\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use App\View\View;
use App\Helper\PathHelper;

class QuestionController {
    public function showAllQuestions($page = 1) {
        $questionModel = new Question();
        $quizModel = new Quiz();
        $quizzes = $quizModel->getAllQuizzesTitles();
        $questionsPerPage = 12;
        $offset = ($page - 1) * $questionsPerPage;
        $questions = $questionModel->getAllQuestions($questionsPerPage, $offset);
        $totalQuestions = $questionModel->getQuestionCount();
        $totalPages = ceil($totalQuestions / $questionsPerPage);

        $view = new View(
            PathHelper::view('admin/questions.php'),
            PathHelper::layout('admin/admin.php')
        );

        $view->with([
            'title' => 'List of Questions',
            'questions' => $questions,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'quizzes' => $quizzes
        ])->render();
    }

    public function addQuestionForm() {
        $quizModel = new Quiz();
        $quizzes = $quizModel->getAllQuizzesTitles();
        $view = new View(
            PathHelper::view('admin/add_question.php'),
            PathHelper::layout('admin/admin.php')
        );

        $view->with([
            'title' => 'Add Question',
            'quizzes' => $quizzes
        ])->render();
    }

    public function addQuestion() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $quizId = $_POST['quiz_id'];
            $questionText = $_POST['question_text'];
            $questionType = $_POST['question_type'];
            $questionModel = new Question();
            $questionModel->create($quizId, $questionText, $questionType);
        }

        header('Location: /admin/questions');
    }

    public function updateQuestion() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $quizId = $_POST['quiz_id'];
            $questionText = $_POST['question_text'];
            $questionType = $_POST['question_type'];
            $questionModel = new Question();
            $questionModel->update($id, $quizId, $questionText, $questionType);
        }

        header('Location: /admin/questions');
    }

    public function updateQuestionForm($id) {
        $questionModel = new Question();

        $question = $questionModel->getQuestionById($id);
        $questions = $questionModel->getQuestionsByQuizId($id);

        $quizModel = new Quiz();
        $quizzes = $quizModel->getAllQuizzesTitles();

        $view = new View(
            PathHelper::view('admin/update_question.php'),
            PathHelper::layout('admin/admin.php')
        );

        $view->with([
            'title' => 'Edit Question',
            'question' => $question,
            'questions' => $questions,
            'quizzes' => $quizzes
        ])->render();
    }

    public function deleteQuestion() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];

            $questionModel = new Question();
            if ($questionModel->delete($id)) {
                echo "Successfully deleted question ID: " . htmlspecialchars($id);
                header("Location: /admin/questions");
                exit();
            } else {
                echo "Error deleting question.";
            }
        }
    }
}