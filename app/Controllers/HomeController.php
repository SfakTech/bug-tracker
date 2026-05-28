<?php

require_once __DIR__ . '/../Core/Controller.php';

class HomeController extends Controller
{
    public function index()
    {
        if (!isset($_SESSION['user'])) {
            $this->redirect('/login');
        }

        if ($_SESSION['user']['role'] === 'admin') {
            $this->view('home/admin');
        } else {
            $this->view('home/user');
        }
    }
}
