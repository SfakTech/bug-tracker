<?php

require_once __DIR__ . '/../Core/DB.php';

class Comment
{
    public static function allByTicket(int $ticketId): array
    {
        $db = DB::connect();
        $stmt = $db->prepare("
            SELECT c.*, u.name as user_name, u.email as user_email, u.role as user_role
            FROM comments c
            JOIN users u ON c.user_id = u.id
            WHERE c.ticket_id = ?
            ORDER BY c.created_at ASC
        ");
        $stmt->execute([$ticketId]);
        return $stmt->fetchAll();
    }

    public static function create(int $ticketId, int $userId, string $body): bool
    {
        $db = DB::connect();
        $stmt = $db->prepare("INSERT INTO comments (ticket_id, user_id, body) VALUES (?, ?, ?)");
        return $stmt->execute([$ticketId, $userId, $body]);
    }
}
