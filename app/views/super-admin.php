<?php
$flash = get_flash();
$stats = Dashboard::superAdminStats();
$activity = Dashboard::recentActivity();
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-dark: #312e81;
            --secondary-color: #14b8a6;
            --success-color: #16a34a;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --background-color: #f5f7ff;
            --surface-color: #ffffff;
            --card-color: #ffffff;
            --text-primary: #111827;
            --text-secondary: #6b7280;
            --border-color: rgba(15,23,42,0.08);
            --shadow-sm: 0 8px 24px rgba(79,70,229,0.06);
            --shadow-md: 0 16px 45px rgba(15, 23, 42, 0.08);
            --radius-xl: 28px;
            --radius-lg: 20px;
        }
        * { box-sizing: border-box; }
        body { margin: 0; background: var(--background-color); color: var(--text-primary); font-family: 'Inter', sans-serif; }
        .app-shell { display: flex; min-height: 100vh; }
        .sidebar { width: 260px; background: linear-gradient(180deg, #111827 0%, #1f2937 100%); color: white; padding: 24px 18px; position: sticky; top: 0; min-height: 100vh; }
        .brand { display: flex; align-items: center; gap: 12px; padding: 8px 10px 20px; border-bottom: 1px solid rgba(255,255,255,0.08); }
        .brand-badge { width: 38px; height: 38px; border-radius: 12px; display: grid; place-items: center; background: rgba(255,255,255,0.14); }
        .brand h4 { margin: 0; font-size: 1.1rem; }
        .nav-menu { margin-top: 24px; display: grid; gap: 8px; }
        .nav-item { display: flex; align-items: center; gap: 12px; padding: 12px 14px; border-radius: 14px; color: rgba(255,255,255,0.8); text-decoration: none; font-weight: 600; transition: all 0.2s ease; }
        .nav-item.active { background: rgba(255,255,255,0.18); color: white; box-shadow: inset 3px 0 0 #a5b4fc; }
        .nav-item:hover { background: rgba(255,255,255,0.1); color: white; }
        .content { flex: 1; padding: 24px; }
        .topbar { background: rgba(255,255,255,0.8); backdrop-filter: blur(10px); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 16px 20px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .search-box { position: relative; min-width: 280px; }
        .search-box input { width: 100%; border: 1px solid var(--border-color); background: #f9fafb; border-radius: 12px; padding: 12px 14px 12px 42px; }
        .search-box i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-secondary); }
        .top-actions { display: flex; align-items: center; gap: 14px; }
        .icon-button { width: 42px; height: 42px; border-radius: 12px; border: 1px solid var(--border-color); background: white; display: grid; place-items: center; }
        .user-chip { display: flex; align-items: center; gap: 10px; padding: 6px 8px 6px 6px; border: 1px solid var(--border-color); border-radius: 12px; background: white; }
        .avatar { width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #c7d2fe, #e0e7ff); display: grid; place-items: center; font-weight: 700; color: var(--primary-dark); }
        .page-title { font-size: 2rem; font-weight: 800; margin: 4px 0 8px; }
        .stat-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 18px; }
        .stat-card { background: var(--surface-color); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 20px; box-shadow: var(--shadow-sm); }
        .stat-header { display: flex; justify-content: space-between; align-items: center; }
        .stat-icon { width: 46px; height: 46px; border-radius: 14px; display: grid; place-items: center; color: var(--primary-color); background: rgba(79,70,229,0.08); }
        .stat-value { font-size: 2rem; font-weight: 800; margin-top: 18px; }
        .stat-meta { color: var(--text-secondary); font-size: 0.9rem; }
        .trend-up { color: var(--success-color); }
        .trend-down { color: var(--danger-color); }
        .main-grid { display: grid; grid-template-columns: 1.5fr 1fr; gap: 20px; margin-top: 24px; }
        .panel { background: var(--surface-color); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 20px; box-shadow: var(--shadow-sm); }
        .panel-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; }
        .chart-placeholder { height: 260px; border-radius: 16px; background: linear-gradient(180deg, rgba(79,70,229,0.08), rgba(20,184,166,0.06)); display: grid; place-items: center; color: var(--text-secondary); }
        .timeline { list-style: none; padding: 0; margin: 0; display: grid; gap: 16px; }
        .timeline li { display: flex; gap: 12px; }
        .timeline-dot { width: 10px; height: 10px; border-radius: 50%; background: var(--primary-color); margin-top: 6px; }
        .timeline-body strong { display: block; }
        .timeline-body small { color: var(--text-secondary); }
        @media (max-width: 980px) { .stat-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } .main-grid { grid-template-columns: 1fr; } }
        @media (max-width: 760px) { .app-shell { align-items: flex-start; } .sidebar { width: 220px; min-width: 220px; padding: 18px 12px; } .content { min-width: 0; padding: 14px; } .topbar { flex-wrap: wrap; } .search-box { min-width: 0; width: 100%; } .stat-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="app-shell">
        <?php include BASE_PATH . '/app/views/partials/admin-sidebar.php'; ?>

        <main class="content">
            <header class="topbar">
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" placeholder="Search anything">
                </div>
                <div class="top-actions">
                    <a class="icon-button" href="/notifications" aria-label="Notifications"><i class="bi bi-bell"></i></a>
                    <button class="icon-button" data-theme-toggle><i class="bi bi-moon"></i></button>
                    <div class="user-chip">
                        <div class="avatar">SA</div>
                        <div><div style="font-weight:700;">System Admin</div><small style="color: var(--text-secondary);">Super Admin</small></div>
                    </div>
                </div>
            </header>

            <div class="page-title">Good Morning, Admin 👋</div>
            <div style="color: var(--text-secondary); margin-bottom: 22px;">Here's what's happening with your PG platform today.</div>

            <section class="stat-grid">
                <div class="stat-card">
                    <div class="stat-header"><span style="font-weight:600">Students</span><div class="stat-icon"><i class="bi bi-people-fill"></i></div></div>
                    <div class="stat-value"><?= number_format((int) $stats['students']) ?></div>
                    <div class="stat-meta"><span class="trend-up">▲ 8.4%</span> this month</div>
                </div>
                <div class="stat-card">
                    <div class="stat-header"><span style="font-weight:600">PG Owners</span><div class="stat-icon"><i class="bi bi-person-badge-fill"></i></div></div>
                    <div class="stat-value"><?= number_format((int) $stats['owners']) ?></div>
                    <div class="stat-meta"><span class="trend-up">▲ 4.3%</span> this month</div>
                </div>
                <div class="stat-card">
                    <div class="stat-header"><span style="font-weight:600">Active PGs</span><div class="stat-icon"><i class="bi bi-house-door-fill"></i></div></div>
                    <div class="stat-value"><?= number_format((int) $stats['pgs']) ?></div>
                    <div class="stat-meta"><span class="trend-up">▲ 6.2%</span> this month</div>
                </div>
                <div class="stat-card">
                    <div class="stat-header"><span style="font-weight:600">Available Beds</span><div class="stat-icon"><i class="bi bi-grid-3x3-gap-fill"></i></div></div>
                    <div class="stat-value"><?= number_format((int) $stats['available_beds']) ?></div>
                    <div class="stat-meta"><span class="trend-down">▼ 2.1%</span> this month</div>
                </div>
            </section>

            <section class="main-grid">
                <div class="panel">
                    <div class="panel-header"><h5 class="mb-0">Student Growth</h5><span class="badge bg-primary-subtle text-primary">Monthly</span></div>
                    <div class="chart-placeholder"><i class="bi bi-graph-up-arrow" style="font-size: 2rem;"></i></div>
                </div>
                <div class="panel">
                    <div class="panel-header"><h5 class="mb-0">Recent Activity</h5><span class="badge bg-light text-dark">Live</span></div>
                    <ul class="timeline">
                        <?php foreach ($activity as $item): ?>
                            <li>
                                <div class="timeline-dot"></div>
                                <div class="timeline-body">
                                    <strong><?= e($item['title']) ?></strong>
                                    <div><?= e($item['detail']) ?></div>
                                    <small><?= e($item['time']) ?></small>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </section>
        </main>
    </div>
    <script src="/assets/js/app.js"></script>
</body>
</html>
