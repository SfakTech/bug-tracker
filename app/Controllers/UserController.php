<?php

require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Middleware/AdminMiddleware.php';

class UserController extends Controller
{
    public function index()
    {
        AdminMiddleware::handle();
        $users = User::all();
        $this->view('admin/users', compact('users'));
    }

    public function destroy(string $id)
    {
        AdminMiddleware::handle();

        if ((int) $id === (int) $_SESSION['user']['id']) {
            $_SESSION['error'] = 'You cannot delete your own account';
            $this->redirect('/admin/users');
        }

        User::delete((int) $id);
        $_SESSION['success'] = 'User deleted successfully';
        $this->redirect('/admin/users');
    }
}
