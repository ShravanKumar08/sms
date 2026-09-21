<?php

class Dashboard
{
    public static function superAdminStats(): array
    {
        $pdo = Database::pdo();

        $students = (int) $pdo->query('SELECT COUNT(*) FROM users WHERE role = "student"')->fetchColumn();
        $owners = (int) $pdo->query('SELECT COUNT(*) FROM users WHERE role = "pg_owner"')->fetchColumn();
        $pgs = (int) $pdo->query('SELECT COUNT(*) FROM pgs')->fetchColumn();
        $availableBeds = (int) $pdo->query('SELECT COUNT(*) FROM beds WHERE status = "available"')->fetchColumn();
        $occupiedBeds = (int) $pdo->query('SELECT COUNT(*) FROM beds WHERE status = "occupied"')->fetchColumn();
        $activeBookings = (int) $pdo->query('SELECT COUNT(*) FROM bookings WHERE status = "active"')->fetchColumn();
        $pendingApprovals = (int) $pdo->query('SELECT COUNT(*) FROM pgs WHERE is_approved = 0')->fetchColumn();
        $monthlyRevenue = (float) $pdo->query('SELECT COALESCE(SUM(amount), 0) FROM payments WHERE status = "paid"')->fetchColumn();

        return [
            'students' => $students,
            'owners' => $owners,
            'pgs' => $pgs,
            'available_beds' => $availableBeds,
            'occupied_beds' => $occupiedBeds,
            'active_bookings' => $activeBookings,
            'pending_approvals' => $pendingApprovals,
            'monthly_revenue' => $monthlyRevenue,
        ];
    }

    public static function ownerStats(int $ownerId): array
    {
        $pdo = Database::pdo();
        $pgs = PG::byOwner($ownerId);
        $pgIds = array_map(fn($pg) => $pg['id'], $pgs);

        $totalRooms = 0;
        $totalBeds = 0;
        $availableBeds = 0;
        $occupiedBeds = 0;

        if ($pgIds) {
            $placeholders = implode(',', array_fill(0, count($pgIds), '?'));
            $roomStmt = $pdo->prepare('SELECT COUNT(*) as total, SUM(beds_total) as beds FROM rooms WHERE pg_id IN (' . $placeholders . ')');
            $roomStmt->execute($pgIds);
            $roomRow = $roomStmt->fetch();
            $totalRooms = (int) ($roomRow['total'] ?? 0);
            $totalBeds = (int) ($roomRow['beds'] ?? 0);

            $bedStmt = $pdo->prepare('SELECT status, COUNT(*) as total FROM beds WHERE room_id IN (SELECT id FROM rooms WHERE pg_id IN (' . $placeholders . ')) GROUP BY status');
            $bedStmt->execute($pgIds);

            foreach ($bedStmt->fetchAll() as $row) {
                if ($row['status'] === 'available') {
                    $availableBeds = (int) $row['total'];
                }
                if ($row['status'] === 'occupied') {
                    $occupiedBeds = (int) $row['total'];
                }
            }
        }

        return [
            'pgs' => count($pgs),
            'total_rooms' => $totalRooms,
            'total_beds' => $totalBeds,
            'available_beds' => $availableBeds,
            'occupied_beds' => $occupiedBeds,
            'active_students' => $occupiedBeds,
        ];
    }

    public static function recentActivity(): array
    {
        return [
            ['title' => 'New PG registered', 'detail' => 'Kumar Residency', 'time' => '5 minutes ago'],
            ['title' => 'New student registered', 'detail' => 'Arjun Kumar', 'time' => '18 minutes ago'],
            ['title' => 'Booking confirmed', 'detail' => 'Priya → Green Valley PG', 'time' => '32 minutes ago'],
            ['title' => 'Payment received', 'detail' => '₹8,500', 'time' => '1 hour ago'],
        ];
    }
}
