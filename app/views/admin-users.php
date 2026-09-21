<?php $students = User::allStudents(); $flash = get_flash(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body{font-family:'Inter',sans-serif;background:#f5f7ff;color:#111827}.app-shell{display:flex;min-height:100vh}.sidebar{width:260px;min-width:260px;background:linear-gradient(180deg,#111827 0%,#1f2937 100%);color:white;padding:24px 18px;position:sticky;top:0;height:100vh}.brand{display:flex;align-items:center;gap:12px;padding:8px 10px 20px;border-bottom:1px solid rgba(255,255,255,.08)}.brand-badge{width:38px;height:38px;border-radius:12px;display:grid;place-items:center;background:rgba(255,255,255,.14)}.brand h4{margin:0;font-size:1.1rem}.nav-menu{margin-top:24px;display:grid;gap:8px}.nav-item{display:flex;align-items:center;gap:12px;padding:12px 14px;border-radius:14px;color:rgba(255,255,255,.8);text-decoration:none;font-weight:600}.nav-item.active{background:rgba(255,255,255,.18);color:#fff;box-shadow:inset 3px 0 0 #a5b4fc}.nav-item:hover{background:rgba(255,255,255,.1);color:#fff}.content{flex:1;min-width:0}.page{max-width:1200px;margin:0 auto;padding:28px 18px 60px}.panel{background:white;border:1px solid rgba(15,23,42,.08);border-radius:24px;padding:20px;box-shadow:0 20px 30px rgba(15,23,42,.04)}.user-table{width:100%;border-collapse:separate;border-spacing:0 12px}.user-table th{font-size:.82rem;letter-spacing:.04em;color:#6b7280;text-transform:uppercase}.user-table td{background:#fff;border-top:1px solid rgba(15,23,42,.08);border-bottom:1px solid rgba(15,23,42,.08);padding:16px 14px}.user-table td:first-child{border-left:1px solid rgba(15,23,42,.08);border-radius:14px 0 0 14px}.user-table td:last-child{border-right:1px solid rgba(15,23,42,.08);border-radius:0 14px 14px 0}.avatar{width:42px;height:42px;border-radius:50%;display:grid;place-items:center;background:linear-gradient(135deg,#c7d2fe,#e0e7ff);font-weight:700}.status{display:inline-flex;padding:6px 10px;border-radius:999px;font-size:0.72rem;font-weight:700}.status.active{background:rgba(22,163,74,.1);color:#15803d}.status.inactive{background:rgba(239,68,68,.08);color:#b91c1c}.btn-primary-custom{background:linear-gradient(135deg,#4f46e5,#312e81);border:none}@media(max-width:760px){.sidebar{width:220px;min-width:220px;padding:18px 12px}.page{padding:18px 12px}}
    </style>
</head>
<body>
    <div class="app-shell">
        <?php include BASE_PATH . '/app/views/partials/admin-sidebar.php'; ?>
        <main class="content"><div class="page">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <div class="text-primary fw-bold">People</div>
                <h1 class="mb-0">Student Management</h1>
            </div>
            <a class="btn btn-primary-custom text-white" href="#studentForm">+ Add Student</a>
        </div>
        <?php if ($flash): ?><div class="alert alert-<?= e($flash['type']) ?>"><?= e($flash['message']) ?></div><?php endif; ?>
        <form id="studentForm" class="panel mb-4" method="post" action="/admin/student/create"><h5>Add student</h5><?= csrf_field() ?><div class="row g-3"><div class="col-md-4"><input class="form-control" name="full_name" placeholder="Full name" required></div><div class="col-md-4"><input class="form-control" type="email" name="email" placeholder="Email" required></div><div class="col-md-4"><input class="form-control" type="password" name="password" placeholder="Temporary password" required></div></div><button class="btn btn-primary-custom text-white mt-3" type="submit">Create student</button></form>
        <div class="panel">
            <div class="d-flex flex-wrap gap-3 mb-4">
                <input type="text" class="form-control" placeholder="Search students..." style="max-width: 360px;">
                <select class="form-select" style="max-width: 180px;"><option>Status</option></select>
                <select class="form-select" style="max-width: 180px;"><option>Date</option></select>
            </div>
            <table class="user-table">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Email</th>
                        <th>PG</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><div class="d-flex align-items-center gap-3"><div class="avatar"><?= e(strtoupper(substr($student['full_name'], 0, 2))) ?></div><div><div class="fw-bold"><?= e($student['full_name']) ?></div><div class="text-secondary small">Student</div></div></div></td>
                            <td><?= e($student['email']) ?></td>
                            <td>Unassigned</td>
                            <td><span class="status <?= (int) $student['is_active'] === 1 ? 'active' : 'inactive' ?>"><?= (int) $student['is_active'] === 1 ? 'Active' : 'Inactive' ?></span></td>
                            <td><form method="post" action="/admin/student/toggle"><input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>"><input type="hidden" name="id" value="<?= (int) $student['id'] ?>"><button class="btn btn-sm btn-outline-dark" type="submit"><?= (int) $student['is_active'] === 1 ? 'Deactivate' : 'Activate' ?></button></form></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        </div></main>
    </div>
</body>
</html>
