<?php

namespace App\Controllers;

use App\Models\User;
use App\View\View;
use App\Helper\PathHelper;


class UserController {
    public function showAllUsers($page = 1) {
        $userModel = new User();
        $limit = 12;
        $offset = ($page - 1) * $limit;
        $users = $userModel->getAllUsersPaginated($limit, $offset);
        $totalUsers = $userModel->getUserCount();
        $totalPages = ceil($totalUsers / $limit);

        $view = new View(
            PathHelper::view('admin/users/users.php'),
            PathHelper::layout('admin/admin.php')
        );

        $view->with([
            'title' => 'List of Users',
            'users' => $users,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ])->render();
    }

    public function addUserForm() {
        $view = new View(
            PathHelper::view('admin/users/add_user.php'),
            PathHelper::layout('admin/admin.php')
        );

        $view->with([
            'title' => 'Add Question'
        ])->render();
    }

    public function addUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            $role = $_POST['role'];
            $userModel = new User();
            $userModel->create($username, $password, $email, $role);
        }
        header('Location: /admin/users');
    }

    public function updateUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            $role = $_POST['role'];
            $userModel = new User();
            $userModel->update($id, $username, $password, $email, $role);
        }

        header('Location: /admin/users');
    }

    public function updateUserForm($id) {
        $userModel = new User();
        $user = $userModel->getUserById($id);

        $view = new View(
            PathHelper::view('admin/users/update_user.php'),
            PathHelper::layout('admin/admin.php')
        );

        $view->with([
            'title' => 'Edit User',
            'user' => $user
        ])->render();
    }

    public function deleteUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];

            $userModel = new User();
            if ($userModel->delete($id)) {
                echo "Successfully deleted user ID: " . htmlspecialchars($id);
                header("Location: /admin/users");
                exit();
            } else {
                echo "Error deleting user.";
            }
        }
    }
}