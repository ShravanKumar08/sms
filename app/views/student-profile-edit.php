<?php $user = current_user(); $flash = get_flash(); ?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body{background:#f5f7ff;color:#111827}.page{max-width:700px;margin:0 auto;padding:42px 18px}.panel{background:#fff;border:1px solid rgba(15,23,42,.08);border-radius:22px;padding:26px;box-shadow:0 18px 30px rgba(15,23,42,.05)}</style>
</head>
<body><div class="page"><div class="panel"><div class="text-primary fw-bold">Account</div><h1 class="mb-4">Edit Profile</h1><?php if ($flash): ?><div class="alert alert-<?= e($flash['type']) ?>"><?= e($flash['message']) ?></div><?php endif; ?><form method="post" action="/student/profile/edit"><?= csrf_field() ?><div class="mb-3"><label class="form-label">Full name</label><input class="form-control" name="full_name" required value="<?= e($user['name']) ?>"></div><div class="mb-4"><label class="form-label">Email</label><input class="form-control" type="email" name="email" required value="<?= e($user['email']) ?>"></div><div class="d-flex gap-2"><button class="btn btn-primary" type="submit">Save changes</button><a class="btn btn-outline-dark" href="/student/profile">Cancel</a></div></form></div></div></body></html>
