<?php
$bookings = Booking::forStudent((int) current_user()['id']);
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body{background:#f5f7ff;color:#111827}.page{max-width:1000px;margin:0 auto;padding:32px 18px}.panel{background:#fff;border:1px solid rgba(15,23,42,.08);border-radius:22px;padding:22px;box-shadow:0 18px 30px rgba(15,23,42,.05)}.booking{display:flex;justify-content:space-between;align-items:center;gap:18px;padding:18px 0;border-bottom:1px solid #eef0f4}.booking:last-child{border-bottom:0}.status{border-radius:999px;padding:7px 12px;font-size:.8rem;font-weight:700;background:#eef2ff;color:#3730a3}</style>
</head>
<body>
<div class="page">
    <div class="d-flex justify-content-between align-items-center mb-4"><div><div class="text-primary fw-bold">Student Portal</div><h1 class="mb-0">My Bookings</h1></div><a class="btn btn-outline-dark" href="/student">Dashboard</a></div>
    <div class="panel">
        <?php if (!$bookings): ?><p class="text-secondary mb-0">No booking requests yet. <a href="/student/search">Find a PG</a></p><?php endif; ?>
        <?php foreach ($bookings as $booking): ?>
            <article class="booking"><div><h5 class="mb-1"><?= e($booking['pg_name']) ?></h5><div class="text-secondary">₹<?= number_format((float) $booking['monthly_amount'], 0) ?> / month</div><small class="text-secondary">Requested <?= e($booking['created_at']) ?></small></div><span class="status"><?= e(ucfirst($booking['status'])) ?></span></article>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>
