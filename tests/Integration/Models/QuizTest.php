<?php

use PHPUnit\Framework\TestCase;
use App\Models\Quiz;
use App\Database\Database;

class QuizTest extends TestCase
{
    private $quiz;

    protected function setUp(): void
    {
        $database = new Database();
        $pdo = $database->getPdo();

        $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
        $pdo->exec("DROP TABLE IF EXISTS questions;");
        $pdo->exec("DROP TABLE IF EXISTS quizzes;");
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");

        $pdo->exec("
            CREATE TABLE quizzes (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                description TEXT,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
        ");
        $pdo->exec("
            CREATE TABLE questions (
                id INT AUTO_INCREMENT PRIMARY KEY,
                quiz_id INT NOT NULL,
                question_text TEXT NOT NULL,
                question_type VARCHAR(50) NOT NULL,
                FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE
            );
        ");

        $pdo->exec("INSERT INTO quizzes (id, title, description) VALUES (1, 'Sample Quiz', 'Description');");

        $this->quiz = new Quiz();
    }

    public function testCreateQuiz()
    {
        $title = 'New Quiz';
        $description = 'This is a new quiz.';
        $quizId = $this->quiz->create($title, $description);

        $this->assertIsInt($quizId);
        $createdQuiz = $this->quiz->getQuizById($quizId);
        $this->assertSame($title, $createdQuiz['title']);
        $this->assertSame($description, $createdQuiz['description']);
    }

    public function testUpdateQuiz()
    {
        $newTitle = 'Updated Quiz';
        $newDescription = 'Updated description.';

        $result = $this->quiz->update(1, $newTitle, $newDescription);
        $this->assertTrue($result);

        $updatedQuiz = $this->quiz->getQuizById(1);
        $this->assertSame($newTitle, $updatedQuiz['title']);
        $this->assertSame($newDescription, $updatedQuiz['description']);
    }

    public function testUpdateNonExistentQuizThrowsException()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('No quiz found with id 999 to update.');

        $this->quiz->update(999, 'Non-existent Quiz', 'Description');
    }

    public function testDeleteQuiz()
    {
        $result = $this->quiz->delete(1);
        $this->assertTrue($result);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('No quiz found with id 1.');
        $this->quiz->getQuizById(1);
    }

    public function testDeleteNonExistentQuizThrowsException()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('No quiz found with id 999 to delete.');

        $this->quiz->delete(999);
    }

    public function testGetQuizById()
    {
        $quiz = $this->quiz->getQuizById(1);

        $this->assertIsArray($quiz);
        $this->assertSame('Sample Quiz', $quiz['title']);
        $this->assertSame('Description', $quiz['description']);
    }

    public function testGetQuizByIdThrowsExceptionForNonExistentQuiz()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('No quiz found with id 999.');

        $this->quiz->getQuizById(999);
    }

    public function testGetAllQuizzesPaginated()
    {
        $quizzes = $this->quiz->getAllQuizzesPaginated(10, 0);

        $this->assertIsArray($quizzes);
        $this->assertCount(1, $quizzes);
        $this->assertSame('Sample Quiz', $quizzes[0]['quiz_title']);
    }

    public function testGetAllQuizzes()
    {
        $quizzes = $this->quiz->getAllQuizzes();

        $this->assertIsArray($quizzes);
        $this->assertCount(1, $quizzes);
        $this->assertSame('Sample Quiz', $quizzes[0]['title']);
    }
    

    public function testGetQuizCount()
    {
        $count = $this->quiz->getQuizCount();

        $this->assertSame(1, $count);
    }
}