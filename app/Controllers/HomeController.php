<?php

require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Models/Ticket.php';

class HomeController extends Controller
{
    public function index()
    {
        if (!isset($_SESSION['user'])) {
            $this->redirect('/login');
        }

        $isAdmin       = $_SESSION['user']['role'] === 'admin';
        $userId        = $isAdmin ? null : (int) $_SESSION['user']['id'];
        $stats         = Ticket::stats($userId);
        $recentTickets = $isAdmin ? Ticket::recent() : Ticket::recentByUser($userId);

        if ($isAdmin) {
            $this->view('home/admin', compact('stats', 'recentTickets'));
        } else {
            $this->view('home/user', compact('stats', 'recentTickets'));
        }
    }
}
