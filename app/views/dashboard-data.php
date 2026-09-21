<?php
require dirname(__DIR__) . '/app/bootstrap.php';
header('Content-Type: application/json');

if (!is_logged_in()) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$counts = User::dashboardCounts();
$pgs = PG::all();
$students = User::allStudents();

$payload = [
    'success' => true,
    'data' => [
        'students' => $counts['student'],
        'owners' => $counts['pg_owner'],
        'pgs' => count($pgs),
        'users' => $counts,
        'students_list' => array_slice($students, 0, 5),
    ],
];

echo json_encode($payload, JSON_PRETTY_PRINT);
