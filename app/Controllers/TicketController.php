<?php

require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Models/Ticket.php';
require_once __DIR__ . '/../Models/Comment.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Middleware/AuthMiddleware.php';

class TicketController extends Controller
{
    public function index()
    {
        AuthMiddleware::handle();

        $isAdmin = $_SESSION['user']['role'] === 'admin';
        $userId  = $isAdmin ? null : (int) $_SESSION['user']['id'];
        $stats   = Ticket::stats($userId);

        $perPage    = 10;
        $total      = Ticket::count($userId);
        $totalPages = max(1, (int) ceil($total / $perPage));
        $page       = max(1, min((int) ($_GET['page'] ?? 1), $totalPages));
        $tickets    = Ticket::paginate($page, $perPage, $userId);

        $this->view('tickets/index', compact('tickets', 'isAdmin', 'stats', 'page', 'totalPages', 'total'));
    }

    public function show(string $id)
    {
        AuthMiddleware::handle();

        $ticket = Ticket::findWithUser((int) $id);
        if (!$ticket) {
            http_response_code(404);
            echo "Ticket not found";
            return;
        }

        $isAdmin = $_SESSION['user']['role'] === 'admin';
        $isOwner = (int) $ticket['user_id'] === (int) $_SESSION['user']['id'];
        $comments = Comment::allByTicket((int) $id);
        $users = $isAdmin ? User::all() : [];

        $this->view('tickets/view', compact('ticket', 'isAdmin', 'isOwner', 'comments', 'users'));
    }

    public function create()
    {
        AuthMiddleware::handle();
        $this->view('tickets/create');
    }

    public function store()
    {
        AuthMiddleware::handle();

        $title = trim($_POST['title'] ?? '');
        if (strlen($title) < 3) {
            $_SESSION['error'] = 'Title must be at least 3 characters';
            $this->redirect('/tickets/create');
        }

        Ticket::create([
            'user_id'     => $_SESSION['user']['id'],
            'title'       => $title,
            'description' => trim($_POST['description'] ?? ''),
            'status'      => $_POST['status'],
            'priority'    => $_POST['priority'] ?? 'medium',
        ]);

        $_SESSION['success'] = 'Ticket created successfully';
        $this->redirect('/tickets');
    }

    public function edit(string $id)
    {
        AuthMiddleware::handle();

        $ticket = Ticket::findWithUser((int) $id);
        if (!$ticket) {
            http_response_code(404);
            echo "Ticket not found";
            return;
        }

        $isAdmin = $_SESSION['user']['role'] === 'admin';
        if (!$isAdmin && (int) $ticket['user_id'] !== (int) $_SESSION['user']['id']) {
            $this->redirect('/tickets');
        }

        $this->view('tickets/edit', compact('ticket'));
    }

    public function update(string $id)
    {
        AuthMiddleware::handle();

        $ticket = Ticket::find((int) $id);
        if (!$ticket) {
            http_response_code(404);
            echo "Ticket not found";
            return;
        }

        $isAdmin = $_SESSION['user']['role'] === 'admin';
        if (!$isAdmin && (int) $ticket['user_id'] !== (int) $_SESSION['user']['id']) {
            $this->redirect('/tickets');
        }

        $title = trim($_POST['title'] ?? '');
        if (strlen($title) < 3) {
            $_SESSION['error'] = 'Title must be at least 3 characters';
            $this->redirect("/tickets/{$id}/edit");
        }

        Ticket::update((int) $id, [
            'title'       => $title,
            'description' => trim($_POST['description'] ?? ''),
            'status'      => $_POST['status'],
            'priority'    => $_POST['priority'] ?? 'medium',
        ]);

        $_SESSION['success'] = 'Ticket updated successfully';
        $this->redirect('/tickets');
    }

    public function updateStatus(string $id)
    {
        AuthMiddleware::handle();

        $status = $_POST['status'] ?? '';
        $allowed = ['open', 'in progress', 'closed'];
        if (!in_array($status, $allowed)) {
            $this->redirect("/tickets/$id");
        }

        Ticket::updateStatus((int) $id, $status);
        $redirect = $_POST['_redirect'] ?? "/tickets/$id";
        $this->redirect($redirect);
    }

    public function assign(string $id)
    {
        AuthMiddleware::handle();

        $ticket = Ticket::find((int) $id);
        if (!$ticket) $this->redirect('/tickets');

        $isAdmin  = $_SESSION['user']['role'] === 'admin';
        $assignTo = $isAdmin ? (int) ($_POST['user_id'] ?? $_SESSION['user']['id']) : (int) $_SESSION['user']['id'];

        Ticket::assign((int) $id, $assignTo);
        $_SESSION['success'] = 'Ticket assigned successfully';
        $this->redirect("/tickets/$id");
    }

    public function addComment(string $id)
    {
        AuthMiddleware::handle();

        $body = trim($_POST['body'] ?? '');
        if (!empty($body)) {
            Comment::create((int) $id, (int) $_SESSION['user']['id'], $body);
        }

        $this->redirect("/tickets/$id");
    }

    public function destroy(string $id)
    {
        AuthMiddleware::handle();

        $ticket = Ticket::find((int) $id);
        if (!$ticket) $this->redirect('/tickets');

        $isAdmin = $_SESSION['user']['role'] === 'admin';
        if (!$isAdmin && (int) $ticket['user_id'] !== (int) $_SESSION['user']['id']) {
            $this->redirect('/tickets');
        }

        Ticket::delete((int) $id);
        $_SESSION['success'] = 'Ticket deleted successfully';
        $this->redirect('/tickets');
    }
}
