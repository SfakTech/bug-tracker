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

    public static function findWithUser(int $id): array|false
    {
        $db = DB::connect();
        $stmt = $db->prepare("
            SELECT t.*,
                   u.name  as user_name,  u.email  as user_email,
                   au.name as assigned_user_name, au.email as assigned_user_email
            FROM tickets t
            JOIN  users u  ON t.user_id     = u.id
            LEFT JOIN users au ON t.assigned_to = au.id
            WHERE t.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function assign(int $id, int $userId): bool
    {
        $db = DB::connect();
        $stmt = $db->prepare("UPDATE tickets SET assigned_to = ?, assigned_at = NOW() WHERE id = ?");
        return $stmt->execute([$userId, $id]);
    }

    public static function updateStatus(int $id, string $status): bool
    {
        $db = DB::connect();
        $stmt = $db->prepare("UPDATE tickets SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
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
            UPDATE tickets SET title = ?, description = ?, status = ?, priority = ?
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['title'],
            $data['description'],
            $data['status'],
            $data['priority'],
            $id
        ]);
    }

    public static function countByStatus(string $status, ?int $userId = null): int
    {
        $db = DB::connect();
        if ($userId) {
            $stmt = $db->prepare("SELECT COUNT(*) FROM tickets WHERE status = ? AND user_id = ?");
            $stmt->execute([$status, $userId]);
        } else {
            $stmt = $db->prepare("SELECT COUNT(*) FROM tickets WHERE status = ?");
            $stmt->execute([$status]);
        }
        return (int) $stmt->fetchColumn();
    }

    public static function recent(int $limit = 8): array
    {
        $db = DB::connect();
        return $db->query("
            SELECT t.*, u.name as user_name
            FROM tickets t JOIN users u ON t.user_id = u.id
            ORDER BY t.created_at DESC LIMIT $limit
        ")->fetchAll();
    }

    public static function recentByUser(int $userId, int $limit = 8): array
    {
        $db = DB::connect();
        $stmt = $db->prepare("
            SELECT t.*, u.name as user_name
            FROM tickets t JOIN users u ON t.user_id = u.id
            WHERE t.user_id = ? ORDER BY t.created_at DESC LIMIT $limit
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public static function stats(?int $userId = null): array
    {
        $db = DB::connect();
        $where = $userId ? "WHERE user_id = $userId" : "";
        $rows = $db->query("SELECT status, COUNT(*) as count FROM tickets $where GROUP BY status")->fetchAll();
        $stats = ['open' => 0, 'in progress' => 0, 'closed' => 0];
        foreach ($rows as $row) {
            $stats[$row['status']] = (int) $row['count'];
        }
        return $stats;
    }

    public static function count(?int $userId = null): int
    {
        $db = DB::connect();
        if ($userId) {
            $stmt = $db->prepare("SELECT COUNT(*) FROM tickets WHERE user_id = ?");
            $stmt->execute([$userId]);
        } else {
            $stmt = $db->prepare("SELECT COUNT(*) FROM tickets");
            $stmt->execute();
        }
        return (int) $stmt->fetchColumn();
    }

    public static function paginate(int $page, int $perPage = 10, ?int $userId = null): array
    {
        $offset = ($page - 1) * $perPage;
        $db = DB::connect();
        if ($userId) {
            $stmt = $db->prepare("SELECT * FROM tickets WHERE user_id = ? ORDER BY created_at DESC LIMIT ? OFFSET ?");
            $stmt->bindValue(1, $userId, PDO::PARAM_INT);
            $stmt->bindValue(2, $perPage, PDO::PARAM_INT);
            $stmt->bindValue(3, $offset, PDO::PARAM_INT);
        } else {
            $stmt = $db->prepare("SELECT * FROM tickets ORDER BY created_at DESC LIMIT ? OFFSET ?");
            $stmt->bindValue(1, $perPage, PDO::PARAM_INT);
            $stmt->bindValue(2, $offset, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function delete(int $id): bool
    {
        $db = DB::connect();
        $stmt = $db->prepare("DELETE FROM tickets WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
