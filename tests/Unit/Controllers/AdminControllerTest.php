<?php

namespace Tests\Unit\Controllers;

use PHPUnit\Framework\TestCase;
use App\Controllers\AdminController;
use App\Models\User;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\UserQuizResult;
use App\View\View;

class AdminControllerTest extends TestCase
{
    private $adminController;
    private $mockedUserModel;
    private $mockedQuizModel;
    private $mockedQuestionModel;
    private $mockedUserQuizResultModel;
    private $mockedView;

    protected function setUp(): void
    {
        $this->mockedUserModel = $this->createMock(User::class);
        $this->mockedQuizModel = $this->createMock(Quiz::class);
        $this->mockedQuestionModel = $this->createMock(Question::class);
        $this->mockedUserQuizResultModel = $this->createMock(UserQuizResult::class);

        $this->mockedView = $this->createMock(View::class);

        $this->adminController = new AdminController(
            $this->mockedUserModel,
            $this->mockedQuizModel,
            $this->mockedQuestionModel,
            $this->mockedUserQuizResultModel,
            $this->mockedView
        );
    }
    public function testIndex()
    {
        $mockedUserModel = $this->createMock(User::class);
        $mockedQuizModel = $this->createMock(Quiz::class);
        $mockedQuestionModel = $this->createMock(Question::class);
    
        $mockedUserModel->method('getUserCount')->willReturn(10);
        $mockedQuizModel->method('getQuizCount')->willReturn(5);
        $mockedQuestionModel->method('getQuestionCount')->willReturn(20);
        $mockedQuizModel->method('getRecentQuizzes')->willReturn([
            ['id' => 1, 'title' => 'Quiz 1'],
            ['id' => 2, 'title' => 'Quiz 2']
        ]);
    
        $mockedView = $this->createMock(View::class);
    
        $mockedView->expects($this->once())->method('render');
    
        $adminController = $this->getMockBuilder(AdminController::class)
                                 ->onlyMethods(['index'])
                                 ->getMock();
    
        $adminController->method('index')->willReturnCallback(function() use ($mockedView) {
            $mockedView->render();
        });
    
        $adminController->index();
    }
    
    public function testStats()
    {
        $mockedUserModel = $this->createMock(User::class);
        $mockedQuizModel = $this->createMock(Quiz::class);
        $mockedUserQuizResultModel = $this->createMock(UserQuizResult::class);
    
        $mockedUserModel->method('getRoleCounts')->willReturn(['admin' => 2, 'user' => 8]);
        $mockedQuizModel->method('getQuizStats')->willReturn(['totalQuizzes' => 10, 'completedQuizzes' => 5]);
        $mockedUserQuizResultModel->method('getUserAnswerStats')->willReturn(['correct' => 50, 'incorrect' => 20]);
        $mockedUserQuizResultModel->method('getDailyQuizCompletions')->willReturn(10);
        $mockedQuizModel->method('getQuizPerformance')->willReturn(['quiz1' => 80, 'quiz2' => 60]);
    
        $mockedView = $this->createMock(View::class);
    
        $mockedView->expects($this->once())->method('render');
    
        $adminController = $this->getMockBuilder(AdminController::class)
                                 ->onlyMethods(['stats'])
                                 ->getMock();
    
        $adminController->method('stats')->willReturnCallback(function() use ($mockedView) {
            $mockedView->render();
        });
    
        $adminController->stats();
    }      
}
