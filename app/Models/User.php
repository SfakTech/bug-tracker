<?php

require_once __DIR__ . '/../Core/DB.php';

class User
{
    public static function findByEmail(string $email)
    {
        $db = DB::connect();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public static function create(array $data)
    {
        $db = DB::connect();
        $stmt = $db->prepare("
            INSERT INTO users (name, email, password, role)
            VALUES (?, ?, ?, ?)
        ");

        return $stmt->execute([
            $data['name'],
            $data['email'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['role'] ?? 'user'
        ]);
    }
}
