<?php
$notifications = Notification::allForUser((int) current_user()['id']);
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body{background:#f5f7ff;color:#111827}.page{max-width:900px;margin:0 auto;padding:32px 18px}.panel{background:#fff;border:1px solid rgba(15,23,42,.08);border-radius:22px;padding:22px;box-shadow:0 18px 30px rgba(15,23,42,.05)}.notification{padding:18px 0;border-bottom:1px solid #eef0f4}.notification:last-child{border-bottom:0}.meta{color:#6b7280;font-size:.88rem}</style>
</head>
<body>
<div class="page">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><div class="text-primary fw-bold">Inbox</div><h1 class="mb-0">Notifications</h1></div>
        <a class="btn btn-outline-dark" href="<?= current_user_role() === 'student' ? '/student' : (current_user_role() === 'pg_owner' ? '/pg-owner' : '/super-admin') ?>">Back</a>
    </div>
    <div class="panel">
        <?php if (!$notifications): ?><p class="text-secondary mb-0">You are all caught up.</p><?php endif; ?>
        <?php foreach ($notifications as $notification): ?>
            <article class="notification"><h5 class="mb-1"><?= e($notification['title']) ?></h5><p class="mb-1"><?= e($notification['message']) ?></p><div class="meta"><?= e($notification['created_at']) ?></div></article>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>
