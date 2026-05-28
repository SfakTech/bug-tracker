<?php

require_once __DIR__ . '/../Core/DB.php';

class Ticket
{
    public static function all(): array
    {
        $db = DB::connect();
        return $db->query("SELECT * FROM tickets ORDER BY created_at DESC")->fetchAll();
    }

    public static function allByUser(int $userId): array
    {
        $db = DB::connect();
        $stmt = $db->prepare("SELECT * FROM tickets WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public static function find(int $id): array|false
    {
        $db = DB::connect();
        $stmt = $db->prepare("SELECT * FROM tickets WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function create(array $data): bool
    {
        $db = DB::connect();
        $stmt = $db->prepare("
            INSERT INTO tickets (user_id, title, description, status)
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['user_id'],
            $data['title'],
            $data['description'],
            $data['status']
        ]);
    }

    public static function update(int $id, array $data): bool
    {
        $db = DB::connect();
        $stmt = $db->prepare("
            UPDATE tickets SET title = ?, description = ?, status = ?
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['title'],
            $data['description'],
            $data['status'],
            $id
        ]);
    }

    public static function delete(int $id): bool
    {
        $db = DB::connect();
        $stmt = $db->prepare("DELETE FROM tickets WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
