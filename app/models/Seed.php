<?php

class Seed
{
    public static function run(): void
    {
        $pdo = Database::pdo();

        $pdo->exec('CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            full_name TEXT NOT NULL,
            email TEXT NOT NULL UNIQUE,
            password_hash TEXT NOT NULL,
            role TEXT NOT NULL,
            avatar TEXT,
            is_active INTEGER DEFAULT 1,
            created_at TEXT DEFAULT CURRENT_TIMESTAMP
        );');

        $pdo->exec('CREATE TABLE IF NOT EXISTS pgs (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            owner_id INTEGER,
            name TEXT NOT NULL,
            city TEXT,
            area TEXT,
            address TEXT,
            price_from REAL DEFAULT 0,
            gender TEXT,
            room_type TEXT,
            is_approved INTEGER DEFAULT 0,
            is_active INTEGER DEFAULT 1,
            rating REAL DEFAULT 4.5,
            created_at TEXT DEFAULT CURRENT_TIMESTAMP
        );');

        $pdo->exec('CREATE TABLE IF NOT EXISTS rooms (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            pg_id INTEGER,
            room_number TEXT,
            room_type TEXT,
            rent REAL,
            beds_total INTEGER,
            status TEXT DEFAULT "active"
        );');

        $pdo->exec('CREATE TABLE IF NOT EXISTS beds (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            room_id INTEGER,
            bed_number TEXT,
            status TEXT DEFAULT "available",
            student_id INTEGER NULL,
            created_at TEXT DEFAULT CURRENT_TIMESTAMP
        );');

        $pdo->exec('CREATE TABLE IF NOT EXISTS bookings (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            student_id INTEGER,
            pg_id INTEGER,
            room_id INTEGER,
            bed_id INTEGER,
            monthly_amount REAL,
            status TEXT DEFAULT "pending",
            created_at TEXT DEFAULT CURRENT_TIMESTAMP
        );');

        $pdo->exec('CREATE TABLE IF NOT EXISTS payments (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            booking_id INTEGER,
            amount REAL,
            status TEXT DEFAULT "paid",
            due_date TEXT,
            created_at TEXT DEFAULT CURRENT_TIMESTAMP
        );');

        $pdo->exec('CREATE TABLE IF NOT EXISTS favorites (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER,
            pg_id INTEGER,
            created_at TEXT DEFAULT CURRENT_TIMESTAMP
        );');

        $pdo->exec('CREATE TABLE IF NOT EXISTS notifications (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER,
            title TEXT,
            message TEXT,
            is_read INTEGER DEFAULT 0,
            created_at TEXT DEFAULT CURRENT_TIMESTAMP
        );');

        $pdo->exec('CREATE TABLE IF NOT EXISTS enquiries (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER,
            pg_id INTEGER,
            message TEXT,
            status TEXT DEFAULT "open",
            created_at TEXT DEFAULT CURRENT_TIMESTAMP
        );');

        $pdo->exec('CREATE TABLE IF NOT EXISTS reviews (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            pg_id INTEGER,
            user_id INTEGER,
            rating INTEGER,
            review TEXT,
            created_at TEXT DEFAULT CURRENT_TIMESTAMP
        );');

        $existing = $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
        if ((int) $existing > 0) {
            return;
        }

        $adminHash = password_hash('Admin@123', PASSWORD_DEFAULT);
        $ownerHash = password_hash('Owner@123', PASSWORD_DEFAULT);
        $studentHash = password_hash('Student@123', PASSWORD_DEFAULT);

        $pdo->exec("INSERT INTO users (full_name, email, password_hash, role, avatar, is_active) VALUES
            ('System Admin', 'admin@example.com', '$adminHash', 'super_admin', 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=200&q=80', 1),
            ('Kumar Residency', 'owner@example.com', '$ownerHash', 'pg_owner', 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=200&q=80', 1),
            ('Arjun Kumar', 'student@example.com', '$studentHash', 'student', 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=200&q=80', 1)");

        $pdo->exec("INSERT INTO pgs (owner_id, name, city, area, address, price_from, gender, room_type, is_approved, is_active, rating) VALUES
            (2, 'Green Valley PG', 'Chennai', 'Anna Nagar', '12, 2nd Street, Anna Nagar, Chennai', 7500, 'co_living', 'double', 1, 1, 4.8),
            (2, 'Urban Nest PG', 'Chennai', 'Velachery', '22, Velachery Main Road, Chennai', 8200, 'female', 'single', 1, 1, 4.7),
            (2, 'Comfort Stay', 'Chennai', 'Adyar', '8, Adyar River Road, Chennai', 6800, 'male', 'double', 1, 1, 4.6),
            (2, 'Elite Living', 'Chennai', 'T Nagar', '7, Usman Road, T Nagar, Chennai', 9800, 'co_living', 'single', 1, 1, 4.9),
            (2, 'Sunrise Residency', 'Chennai', 'Mylapore', '14, Mylapore Tank Road, Chennai', 7700, 'female', 'triple', 1, 1, 4.5)");

        $pdo->exec("INSERT INTO rooms (pg_id, room_number, room_type, rent, beds_total, status) VALUES
            (1, '101', 'double', 8500, 2, 'active'),
            (1, '204', 'double', 8500, 2, 'active'),
            (2, '201', 'single', 9200, 1, 'active'),
            (3, '305', 'double', 7600, 2, 'active'),
            (4, '401', 'single', 11000, 1, 'active'),
            (5, '110', 'triple', 7800, 3, 'active')");

        $pdo->exec("INSERT INTO beds (room_id, bed_number, status, student_id) VALUES
            (1, 'A', 'occupied', 3),
            (1, 'B', 'available', NULL),
            (2, 'A', 'available', NULL),
            (2, 'B', 'available', NULL),
            (3, 'A', 'occupied', NULL),
            (4, 'A', 'available', NULL),
            (4, 'B', 'available', NULL),
            (5, 'A', 'available', NULL),
            (6, 'A', 'available', NULL),
            (6, 'B', 'occupied', NULL),
            (6, 'C', 'available', NULL)");

        $pdo->exec("INSERT INTO bookings (student_id, pg_id, room_id, bed_id, monthly_amount, status, created_at) VALUES
            (3, 1, 1, 1, 8500, 'active', '2026-09-01 10:00:00'),
            (3, 1, 2, 2, 8500, 'pending', '2026-09-10 11:00:00'),
            (3, 2, 3, 5, 9200, 'completed', '2026-08-20 09:00:00')");

        $pdo->exec("INSERT INTO payments (booking_id, amount, status, due_date, created_at) VALUES
            (1, 8500, 'paid', '2026-10-05', '2026-09-01'),
            (2, 8500, 'pending', '2026-10-05', '2026-09-10'),
            (3, 9200, 'paid', '2026-09-20', '2026-08-20')");

        $pdo->exec("INSERT INTO favorites (user_id, pg_id) VALUES (3, 1), (3, 2), (3, 4)");
        $pdo->exec("INSERT INTO notifications (user_id, title, message, is_read) VALUES
            (1, 'New booking request', 'A new booking request was received for Green Valley PG.', 0),
            (2, 'Payment received', 'Payment of ₹8,500 has been received for August.', 0),
            (3, 'PG approved', 'Green Valley PG was approved and is live for students.', 0)");

        $pdo->exec("INSERT INTO enquiries (user_id, pg_id, message, status) VALUES
            (3, 1, 'I want a single room with Wi-Fi and food support.', 'open'),
            (3, 3, 'Can I visit the property this weekend?', 'answered')");

        $pdo->exec("INSERT INTO reviews (pg_id, user_id, rating, review) VALUES
            (1, 3, 5, 'Very clean and safe environment with helpful staff.'),
            (2, 3, 4, 'Comfortable and near the metro station.')");
    }
}
