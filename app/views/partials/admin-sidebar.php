<?php
$currentPath = trim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH), '/');
$adminNav = [
    'super-admin' => ['Dashboard', 'bi-speedometer2'],
    'admin/users' => ['Students', 'bi-people'],
    'admin/owners' => ['PG Owners', 'bi-person-workspace'],
    'admin/pgs' => ['PGs', 'bi-house-door'],
    'admin/bookings' => ['Bookings', 'bi-calendar-check'],
    'admin/payments' => ['Payments', 'bi-currency-rupee'],
    'admin/reports' => ['Reports', 'bi-graph-up-arrow'],
    'admin/settings' => ['Settings', 'bi-gear'],
];
?><aside class="sidebar">
    <div class="brand">
        <div class="brand-badge"><i class="bi bi-building"></i></div>
        <div><h4>StayNest Admin</h4></div>
    </div>
    <nav class="nav-menu">
        <?php foreach ($adminNav as $path => [$label, $icon]): ?>
            <a href="/<?= e($path) ?>" class="nav-item <?= $currentPath === $path ? 'active' : '' ?>"><i class="bi <?= e($icon) ?>"></i> <?= e($label) ?></a>
        <?php endforeach; ?>
        <a href="/logout" class="nav-item"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </nav>
</aside>
