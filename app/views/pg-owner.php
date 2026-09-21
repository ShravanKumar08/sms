<?php
$flash = get_flash();
$stats = Dashboard::ownerStats((int) current_user()['id']);
$pgs = PG::byOwner((int) current_user()['id']);
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PG Owner Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { background: #f5f7ff; font-family: 'Inter', sans-serif; color: #111827; }
        .container { max-width: 1200px; margin: 0 auto; padding: 24px 18px 40px; }
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .stat-grid { display: grid; grid-template-columns: repeat(4, minmax(0,1fr)); gap: 16px; }
        .stat-card { background: #fff; border: 1px solid rgba(17,24,39,.08); border-radius: 22px; padding: 20px; box-shadow: 0 12px 28px rgba(15,23,42,.05); }
        .stat-value { font-size: 2rem; font-weight: 800; }
        .property-card { background: white; border: 1px solid rgba(17,24,39,.08); border-radius: 24px; overflow: hidden; }
        .property-image { height: 180px; background: linear-gradient(135deg, #dbeafe, #bfdbfe); }
        .property-body { padding: 18px; }
        .status { display: inline-block; padding: 6px 10px; border-radius: 999px; background: rgba(22,163,74,0.08); color: #15803d; font-size: 0.78rem; font-weight: 700; }
        .action-row { display: flex; gap: 10px; margin-top: 16px; }
        .btn-primary-custom { background: linear-gradient(135deg, #4f46e5, #312e81); border: none; }
        @media (max-width: 768px) { .stat-grid { grid-template-columns: repeat(2, minmax(0,1fr)); } }
    </style>
</head>
<body>
    <div class="container">
        <div class="topbar">
            <div>
                <div class="text-primary fw-bold">Owner Portal</div>
                <h1 class="mb-0">Good Morning, Kumar 👋</h1>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <a class="btn btn-light border" href="/notifications">Notifications</a>
                <a href="/logout" class="btn btn-outline-dark">Logout</a>
            </div>
        </div>

        <div class="stat-grid">
            <div class="stat-card"><div class="text-secondary">My PGs</div><div class="stat-value"><?= number_format((int) $stats['pgs']) ?></div></div>
            <div class="stat-card"><div class="text-secondary">Total Rooms</div><div class="stat-value"><?= number_format((int) $stats['total_rooms']) ?></div></div>
            <div class="stat-card"><div class="text-secondary">Total Beds</div><div class="stat-value"><?= number_format((int) $stats['total_beds']) ?></div></div>
            <div class="stat-card"><div class="text-secondary">Available Beds</div><div class="stat-value"><?= number_format((int) $stats['available_beds']) ?></div></div>
        </div>

        <div class="mt-4 row g-4">
            <?php foreach ($pgs as $pg):
                $occupancy = $stats['total_beds'] > 0 ? min(100, max(0, round((($stats['occupied_beds'] / $stats['total_beds']) * 100), 0))) : 0;
            ?>
                <div class="col-md-6 col-xl-4">
                    <div class="property-card">
                        <div class="property-image"></div>
                        <div class="property-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h4 class="mb-1"><?= e($pg['name']) ?></h4>
                                    <div class="text-secondary"><?= e(trim(($pg['area'] ?? '') . ', ' . ($pg['city'] ?? ''))) ?></div>
                                </div>
                                <span class="status"><?= (int) ($pg['is_active'] ?? 1) ? 'Active' : 'Draft' ?></span>
                            </div>
                            <div class="mt-3"><i class="bi bi-star-fill text-warning"></i> <?= number_format((float) ($pg['rating'] ?? 0), 1) ?></div>
                            <div class="mt-2 text-secondary"><?= e($pg['room_type'] ?? 'Mixed') ?> • <?= e($pg['gender'] ?? 'All') ?></div>
                            <div class="mt-1 text-secondary">From ₹<?= number_format((float) ($pg['price_from'] ?? 0), 0) ?>/month</div>
                            <div class="mt-3">
                                <div class="fw-semibold">Occupancy <?= $occupancy ?>%</div>
                                <div class="progress mt-2" style="height: 10px;">
                                    <div class="progress-bar bg-success" style="width: <?= $occupancy ?>%"></div>
                                </div>
                            </div>
                            <div class="action-row">
                                <a class="btn btn-primary-custom text-white flex-grow-1" href="/pg-details?id=<?= (int) $pg['id'] ?>">View</a>
                                <a class="btn btn-outline-dark flex-grow-1" href="/owner/properties">Manage</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
