<?php

require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Models/Ticket.php';
require_once __DIR__ . '/../Middleware/AuthMiddleware.php';

class TicketController extends Controller
{
    public function index()
    {
        AuthMiddleware::handle();

        $isAdmin = $_SESSION['user']['role'] === 'admin';
        $tickets = $isAdmin
            ? Ticket::all()
            : Ticket::allByUser($_SESSION['user']['id']);

        $this->view('tickets/index', compact('tickets', 'isAdmin'));
    }

    public function create()
    {
        AuthMiddleware::handle();
        $this->view('tickets/create');
    }

    public function store()
    {
        AuthMiddleware::handle();

        Ticket::create([
            'user_id'     => $_SESSION['user']['id'],
            'title'       => $_POST['title'],
            'description' => $_POST['description'],
            'status'      => $_POST['status']
        ]);

        $this->redirect('/tickets');
    }

    public function edit(string $id)
    {
        AuthMiddleware::handle();

        $ticket = Ticket::find((int) $id);
        if (!$ticket) {
            http_response_code(404);
            echo "Ticket not found";
            return;
        }

        $this->view('tickets/edit', compact('ticket'));
    }

    public function update(string $id)
    {
        AuthMiddleware::handle();

        Ticket::update((int) $id, [
            'title'       => $_POST['title'],
            'description' => $_POST['description'],
            'status'      => $_POST['status']
        ]);

        $this->redirect('/tickets');
    }

    public function destroy(string $id)
    {
        AuthMiddleware::handle();

        Ticket::delete((int) $id);
        $this->redirect('/tickets');
    }
}
