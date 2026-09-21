<?php

class User
{
    public static function findByEmail(string $email): ?array
    {
        $stmt = Database::pdo()->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        return $user ?: null;
    }

    public static function findById(int $id): ?array
    {
        $stmt = Database::pdo()->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();

        return $user ?: null;
    }

    public static function dashboardCounts(): array
    {
        $stmt = Database::pdo()->query('SELECT role, COUNT(*) as total FROM users GROUP BY role');
        $counts = ['super_admin' => 0, 'pg_owner' => 0, 'student' => 0];

        foreach ($stmt->fetchAll() as $row) {
            $counts[$row['role']] = (int) $row['total'];
        }

        return $counts;
    }

    public static function allStudents(): array
    {
        $stmt = Database::pdo()->query('SELECT * FROM users WHERE role = "student" ORDER BY created_at DESC');
        return $stmt->fetchAll();
    }

    public static function updateProfile(int $id, string $name, string $email): bool
    {
        $stmt = Database::pdo()->prepare('UPDATE users SET full_name = :full_name, email = :email WHERE id = :id');
        return $stmt->execute(['full_name' => $name, 'email' => $email, 'id' => $id]);
    }

    public static function createStudent(string $name, string $email, string $password): int
    {
        $stmt = Database::pdo()->prepare('INSERT INTO users (full_name, email, password_hash, role, is_active) VALUES (:name, :email, :password_hash, "student", 1)');
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
        ]);
        return (int) Database::pdo()->lastInsertId();
    }

    public static function toggleActive(int $id): bool
    {
        $stmt = Database::pdo()->prepare('UPDATE users SET is_active = CASE WHEN is_active = 1 THEN 0 ELSE 1 END WHERE id = :id AND role = "student"');
        return $stmt->execute(['id' => $id]);
    }
}
