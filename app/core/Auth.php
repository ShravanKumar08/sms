<?php

class Auth
{
    public static function login(string $email, string $password): bool
    {
        $user = User::findByEmail($email);

        if (!$user || !password_verify($password, $user['password_hash'])) {
            return false;
        }

        if ((int) ($user['is_active'] ?? 0) !== 1) {
            return false;
        }

        Session::set('user', [
            'id' => (int) $user['id'],
            'name' => $user['full_name'],
            'email' => $user['email'],
            'role' => $user['role'],
            'avatar' => $user['avatar'] ?? 'https://images.unsplash.com/photo-...' 
        ]);

        Session::regenerate();

        return true;
    }

    public static function logout(): void
    {
        Session::destroy();
    }

    public static function requireRole(array $roles): void
    {
        $currentRole = current_user_role();
        if (!$currentRole || !in_array($currentRole, $roles, true)) {
            redirect('/login');
        }
    }
}
