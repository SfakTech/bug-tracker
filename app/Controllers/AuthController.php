<?php

require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Models/User.php';

class AuthController extends Controller
{
    public function showLogin()
    {
        $activeTab = $_GET['tab'] ?? 'login';
        $this->view('auth/login', compact('activeTab'));
    }

    public function login()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = User::findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            $_SESSION['error'] = 'Invalid credentials';
            $this->redirect('/login');
        }

        session_regenerate_id(true);

        $_SESSION['user'] = [
            'id' => $user['id'],
            'email' => $user['email'],
            'role' => $user['role']
        ];

        $this->redirect('/');
    }

    public function register()
    {
        $name     = $_POST['name'] ?? '';
        $email    = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (User::findByEmail($email)) {
            $_SESSION['error'] = 'Email already registered';
            $this->redirect('/login?tab=register');
        }

        User::create([
            'name'     => $name,
            'email'    => $email,
            'password' => $password,
            'role'     => 'user'
        ]);

        $_SESSION['success'] = 'Account created! You can now log in.';
        $this->redirect('/login');
    }

    public function logout()
    {
        session_destroy();
        $this->redirect('/login');
    }
}
