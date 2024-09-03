<?php

namespace App\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\View\View;
use App\Helper\PathHelper;

class AnswerController {
    public function getAnswersForQuestion($id) {
        $answerModel = new Answer();
        $answers = $answerModel->getAnswersByQuestionId($id);

        $view = new View(
            PathHelper::view('admin/answers.php'),
            PathHelper::layout('admin/admin.php')
        );

        $view->with([
            'title' => 'Answers',
            'answers' => $answers,
            'currentQuestionId' => $id
        ])->render();
    }

    public function addAnswer() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $questionId = $_POST['question_id'];
            $answerText = $_POST['answer_text'];
            $isCorrect = isset($_POST['is_correct']) ? 1 : 0;
            $answerModel = new Answer();
            $answerModel->create($questionId, $answerText, $isCorrect);
        }

        header('Location: /admin/questions');
    }

    public function addAnswerForm($id) {
        $view = new View(
            PathHelper::view('admin/add_answer.php'),
            PathHelper::layout('admin/admin.php')
        );

        $view->with([
            'title' => 'Add Answer',
            'currentQuestionId' => $id
        ])->render();
    }

    public function updateAnswer() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $answerText = $_POST['answer_text'] ?? null;
            $isCorrect = isset($_POST['is_correct']) ? true : false;
            $question_id = $_POST['question_id'] ?? null;
    
            $answerModel = new Answer();
            if ($answerModel->update($id, $answerText, $isCorrect)) { 
                header("Location: /admin/answers/" . htmlspecialchars($question_id));
            } else {
                echo "Error updating answer.";
            }
        } else {
            echo "Invalid request method.";
        }
    }
    


    public function updateAnswerForm($id) {
        $answerModel = new Answer();
    
        $answer = $answerModel->getAnswerById($id);
    
        $view = new View(
            PathHelper::view('admin/update_answer.php'),
            PathHelper::layout('admin/admin.php')
        );
    
        $view->with([
            'title' => 'Edit Answer',
            'answer' => $answer
        ])->render();
    }

    public function deleteAnswer() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $question_id = $_POST['question_id'];

            $answerModel = new Answer();
            if ($answerModel->delete($id)) {
                echo "Successfully deleted answer ID: " . htmlspecialchars($id);
                header("Location: /admin/answers/" . htmlspecialchars($question_id));
                exit();
            } else {
                echo "Error deleting answer.";
            }
        }
    }
}