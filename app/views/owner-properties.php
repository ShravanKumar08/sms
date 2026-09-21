<?php
$pgs = PG::byOwner((int) current_user()['id']);
$stats = Dashboard::ownerStats((int) current_user()['id']);
$flash = get_flash();
$editing = null;
foreach ($pgs as $property) { if ((int) ($property['id'] ?? 0) === (int) ($_GET['edit'] ?? 0)) { $editing = $property; break; } }
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My PGs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body{background:#f4f7ff;font-family:'Inter',sans-serif;color:#111827}.page{max-width:1200px;margin:0 auto;padding:28px 18px 60px}.hero{display:flex;justify-content:space-between;align-items:center;margin-bottom:22px}.cards{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:18px}.card{background:white;border:1px solid rgba(15,23,42,.08);border-radius:24px;overflow:hidden;box-shadow:0 20px 30px rgba(15,23,42,.04)}.image{height:200px;background:linear-gradient(135deg,#dbeafe,#bfdbfe)}.body{padding:18px}.status{display:inline-flex;padding:6px 10px;border-radius:999px;font-size:.72rem;font-weight:700;background:rgba(22,163,74,.08);color:#15803d}.meta{color:#6b7280}.progress{height:10px}.btn-primary-custom{background:linear-gradient(135deg,#4f46e5,#312e81);border:none}@media (max-width:980px){.cards{grid-template-columns:1fr}}.
    </style>
</head>
<body>
    <div class="page">
        <div class="hero">
            <div>
                <div class="text-primary fw-bold">PG Portfolio</div>
                <h1 class="mb-0">My Properties</h1>
            </div>
            <button class="btn btn-dark" data-bs-toggle="collapse" data-bs-target="#propertyForm"><?= $editing ? 'Close editor' : '+ Add Property' ?></button>
        </div>
        <?php if ($flash): ?><div class="alert alert-<?= e($flash['type']) ?>"><?= e($flash['message']) ?></div><?php endif; ?>
        <div class="collapse mb-4 <?= $editing ? 'show' : '' ?>" id="propertyForm"><form class="card card-body" method="post" action="<?= $editing ? '/owner/property/update' : '/owner/property/create' ?>"><?= csrf_field() ?><?php if ($editing): ?><input type="hidden" name="id" value="<?= (int) $editing['id'] ?>"><?php endif; ?><div class="row g-3"><div class="col-md-6"><label class="form-label">Property name</label><input class="form-control" name="name" required value="<?= e($editing['name'] ?? '') ?>"></div><div class="col-md-6"><label class="form-label">City</label><input class="form-control" name="city" required value="<?= e($editing['city'] ?? 'Chennai') ?>"></div><div class="col-md-6"><label class="form-label">Area</label><input class="form-control" name="area" required value="<?= e($editing['area'] ?? '') ?>"></div><div class="col-md-6"><label class="form-label">Address</label><input class="form-control" name="address" value="<?= e($editing['address'] ?? '') ?>"></div><div class="col-md-4"><label class="form-label">Starting rent</label><input class="form-control" type="number" name="price_from" min="0" required value="<?= e((string) ($editing['price_from'] ?? '')) ?>"></div><div class="col-md-4"><label class="form-label">Gender</label><select class="form-select" name="gender"><option value="co_living">Co-living</option><option value="male">Male</option><option value="female">Female</option></select></div><div class="col-md-4"><label class="form-label">Room type</label><select class="form-select" name="room_type"><option value="single">Single</option><option value="double">Double</option><option value="triple">Triple</option></select></div></div><button class="btn btn-primary-custom text-white mt-3" type="submit"><?= $editing ? 'Save property' : 'Submit property' ?></button></form></div>
        <div class="cards">
            <?php foreach ($pgs as $pg):
                $occupancy = $stats['total_beds'] > 0 ? min(100, max(0, round((($stats['occupied_beds'] / $stats['total_beds']) * 100), 0))) : 0;
            ?>
                <article class="card">
                    <div class="image"></div>
                    <div class="body">
                        <div class="d-flex justify-content-between align-items-start"><h4 class="mb-1"><?= e($pg['name']) ?></h4><span class="status"><?= (int) ($pg['is_active'] ?? 1) ? 'Active' : 'Draft' ?></span></div>
                        <div class="meta mt-2"><?= e(trim(($pg['area'] ?? '') . ', ' . ($pg['city'] ?? ''))) ?></div>
                        <div class="mt-3"><i class="bi bi-star-fill text-warning"></i> <?= number_format((float) ($pg['rating'] ?? 0), 1) ?></div>
                        <div class="mt-3 meta"><?= e($pg['room_type'] ?? 'Mixed') ?> • <?= e($pg['gender'] ?? 'All') ?></div>
                        <div class="mt-1 meta">From ₹<?= number_format((float) ($pg['price_from'] ?? 0), 0) ?>/month</div>
                        <div class="mt-3">
                            <div class="fw-semibold">Occupancy <?= $occupancy ?>%</div>
                            <div class="progress mt-2"><div class="progress-bar bg-success" style="width:<?= $occupancy ?>%"></div></div>
                        </div>
                        <div class="d-flex gap-2 mt-4">
                            <a class="btn btn-primary-custom text-white flex-grow-1" href="/pg-details?id=<?= (int) $pg['id'] ?>">View</a>
                            <a class="btn btn-outline-dark flex-grow-1" href="/owner/properties?edit=<?= (int) $pg['id'] ?>">Edit</a>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>
