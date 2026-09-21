<?php

class Notification
{
    public static function forUser(int $userId): array
    {
        $stmt = Database::pdo()->prepare('SELECT * FROM notifications WHERE user_id = :user_id ORDER BY created_at DESC LIMIT 5');
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public static function allForUser(int $userId): array
    {
        $stmt = Database::pdo()->prepare('SELECT * FROM notifications WHERE user_id = :user_id ORDER BY created_at DESC');
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }
}
