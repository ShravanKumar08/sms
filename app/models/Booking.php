<?php

class Booking
{
    public static function request(int $studentId, int $pgId, float $amount): int
    {
        $stmt = Database::pdo()->prepare('INSERT INTO bookings (student_id, pg_id, monthly_amount, status) VALUES (:student_id, :pg_id, :amount, "pending")');
        $stmt->execute(['student_id' => $studentId, 'pg_id' => $pgId, 'amount' => $amount]);
        return (int) Database::pdo()->lastInsertId();
    }

    public static function forStudent(int $studentId): array
    {
        $stmt = Database::pdo()->prepare('SELECT bookings.*, pgs.name AS pg_name FROM bookings JOIN pgs ON pgs.id = bookings.pg_id WHERE bookings.student_id = :student_id ORDER BY bookings.created_at DESC');
        $stmt->execute(['student_id' => $studentId]);
        return $stmt->fetchAll();
    }

    public static function dashboardSummary(): array
    {
        $stats = [
            'active_bookings' => 0,
            'pending_approvals' => 0,
            'monthly_revenue' => 0,
        ];

        $stmt = Database::pdo()->query('SELECT status, COUNT(*) as total FROM bookings GROUP BY status');
        foreach ($stmt->fetchAll() as $row) {
            $status = $row['status'];
            if ($status === 'active') {
                $stats['active_bookings'] = (int) $row['total'];
            }
        }

        $pending = Database::pdo()->query('SELECT COUNT(*) as total FROM pgs WHERE is_approved = 0')->fetch();
        $stats['pending_approvals'] = (int) ($pending['total'] ?? 0);

        $revenue = Database::pdo()->query('SELECT COALESCE(SUM(amount), 0) as total FROM payments WHERE status = "paid"')->fetch();
        $stats['monthly_revenue'] = (float) ($revenue['total'] ?? 0);

        return $stats;
    }
}
