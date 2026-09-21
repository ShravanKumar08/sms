<?php
require dirname(__DIR__) . '/app/bootstrap.php';

$route = $_GET['page'] ?? 'login';
$path = trim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH), '/');

if ($path === '') {
    $path = 'login';
}

if ($path === 'logout') {
    Auth::logout();
    redirect('/login');
}

if ($path === 'login') {
    if (is_logged_in()) {
        $role = current_user_role();
        redirect($role === 'super_admin' ? '/super-admin' : ($role === 'pg_owner' ? '/pg-owner' : '/student'));
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!verify_csrf()) {
            set_flash('error', 'Your session expired. Please try again.');
            redirect('/login');
        }

        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) ?: '';
        $password = $_POST['password'] ?? '';
        if (Auth::login($email, $password)) {
            set_flash('success', 'Welcome back!');
            $role = current_user_role();
            redirect($role === 'super_admin' ? '/super-admin' : ($role === 'pg_owner' ? '/pg-owner' : '/student'));
        }

        set_flash('error', 'Invalid email or password.');
        redirect('/login');
    }

    include BASE_PATH . '/app/views/login.php';
    exit;
}

require_login();
$role = current_user_role();

if ($path === 'student/bookings') {
    Auth::requireRole(['student']);
    include BASE_PATH . '/app/views/student-bookings.php';
    exit;
}

if ($path === 'notifications') {
    include BASE_PATH . '/app/views/notifications.php';
    exit;
}

if ($path === 'student/profile/edit') {
    Auth::requireRole(['student']);
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf()) {
        $name = trim((string) ($_POST['full_name'] ?? ''));
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) ?: '';
        if ($name !== '' && filter_var($email, FILTER_VALIDATE_EMAIL) && User::updateProfile((int) current_user()['id'], $name, $email)) {
            Session::set('user', array_merge(current_user(), ['name' => $name, 'email' => $email]));
            set_flash('success', 'Profile updated successfully.');
            redirect('/student/profile');
        }
        set_flash('error', 'Please enter a valid name and email.');
    }
    include BASE_PATH . '/app/views/student-profile-edit.php';
    exit;
}

if ($path === 'student/booking-request' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    Auth::requireRole(['student']);
    if (!verify_csrf()) {
        set_flash('error', 'Your session expired. Please try again.');
        redirect('/student/search');
    }
    $pg = PG::findById((int) ($_POST['pg_id'] ?? 0));
    if ($pg) {
        Booking::request((int) current_user()['id'], (int) $pg['id'], (float) $pg['price_from']);
        set_flash('success', 'Booking request sent to the PG owner.');
        redirect('/student/bookings');
    }
    set_flash('error', 'That property could not be found.');
    redirect('/student/search');
}

if ($path === 'owner/property/create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    Auth::requireRole(['pg_owner']);
    if (verify_csrf() && trim((string) ($_POST['name'] ?? '')) !== '') {
        PG::create([
            'name' => trim($_POST['name']), 'city' => trim($_POST['city'] ?? ''), 'area' => trim($_POST['area'] ?? ''),
            'address' => trim($_POST['address'] ?? ''), 'price_from' => (float) ($_POST['price_from'] ?? 0),
            'gender' => $_POST['gender'] ?? 'co_living', 'room_type' => $_POST['room_type'] ?? 'double',
        ], (int) current_user()['id']);
        set_flash('success', 'Property submitted for admin approval.');
        redirect('/owner/properties');
    }
    set_flash('error', 'Property name is required.');
    redirect('/owner/properties');
}

if ($path === 'owner/property/update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    Auth::requireRole(['pg_owner']);
    if (verify_csrf() && trim((string) ($_POST['name'] ?? '')) !== '') {
        PG::updateOwned((int) ($_POST['id'] ?? 0), (int) current_user()['id'], [
            'name' => trim($_POST['name']), 'city' => trim($_POST['city'] ?? ''), 'area' => trim($_POST['area'] ?? ''),
            'address' => trim($_POST['address'] ?? ''), 'price_from' => (float) ($_POST['price_from'] ?? 0),
            'gender' => $_POST['gender'] ?? 'co_living', 'room_type' => $_POST['room_type'] ?? 'double',
        ]);
        set_flash('success', 'Property updated.');
    } else {
        set_flash('error', 'Property name is required.');
    }
    redirect('/owner/properties');
}

if ($path === 'owner/room/create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    Auth::requireRole(['pg_owner']);
    if (verify_csrf() && (int) ($_POST['pg_id'] ?? 0) > 0 && trim((string) ($_POST['room_number'] ?? '')) !== '') {
        PG::createRoom((int) $_POST['pg_id'], (int) current_user()['id'], [
            'room_number' => trim($_POST['room_number']), 'room_type' => $_POST['room_type'] ?? 'double',
            'rent' => (float) ($_POST['rent'] ?? 0), 'beds_total' => max(1, (int) ($_POST['beds_total'] ?? 1)),
        ]);
        set_flash('success', 'Room and beds created.');
    } else {
        set_flash('error', 'Property and room number are required.');
    }
    redirect('/owner/rooms');
}

if ($path === 'admin/student/create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    Auth::requireRole(['super_admin']);
    if (verify_csrf() && trim((string) ($_POST['full_name'] ?? '')) !== '') {
        User::createStudent(trim($_POST['full_name']), trim($_POST['email']), (string) $_POST['password']);
        set_flash('success', 'Student account created.');
    } else {
        set_flash('error', 'Name, email, and password are required.');
    }
    redirect('/admin/users');
}

if ($path === 'admin/student/toggle' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    Auth::requireRole(['super_admin']);
    if (verify_csrf()) {
        User::toggleActive((int) ($_POST['id'] ?? 0));
        set_flash('success', 'Student status updated.');
    }
    redirect('/admin/users');
}

if ($path === 'super-admin') {
    Auth::requireRole(['super_admin']);
    include BASE_PATH . '/app/views/super-admin.php';
    exit;
}

if ($path === 'admin/users') {
    Auth::requireRole(['super_admin']);
    include BASE_PATH . '/app/views/admin-users.php';
    exit;
}

$adminSections = [
    'admin/owners' => 'PG Owners',
    'admin/pgs' => 'PGs',
    'admin/bookings' => 'Bookings',
    'admin/payments' => 'Payments',
    'admin/reports' => 'Reports',
    'admin/settings' => 'Settings',
];
if (isset($adminSections[$path])) {
    Auth::requireRole(['super_admin']);
    $section = $adminSections[$path];
    include BASE_PATH . '/app/views/admin-section.php';
    exit;
}

if ($path === 'pg-owner') {
    Auth::requireRole(['pg_owner']);
    include BASE_PATH . '/app/views/pg-owner.php';
    exit;
}

if ($path === 'owner/properties') {
    Auth::requireRole(['pg_owner']);
    include BASE_PATH . '/app/views/owner-properties.php';
    exit;
}

if ($path === 'owner/rooms') {
    Auth::requireRole(['pg_owner']);
    include BASE_PATH . '/app/views/owner-room-management.php';
    exit;
}

if ($path === 'student') {
    Auth::requireRole(['student']);
    include BASE_PATH . '/app/views/student.php';
    exit;
}

if ($path === 'student/search') {
    Auth::requireRole(['student']);
    include BASE_PATH . '/app/views/student-search.php';
    exit;
}

if ($path === 'student/profile') {
    Auth::requireRole(['student']);
    include BASE_PATH . '/app/views/student-profile.php';
    exit;
}

if ($path === 'pg-details') {
    Auth::requireRole(['student', 'pg_owner', 'super_admin']);
    include BASE_PATH . '/app/views/pg-details.php';
    exit;
}

http_response_code(404);
include BASE_PATH . '/app/views/404.php';
