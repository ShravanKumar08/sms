<?php
$pg = PG::findById((int) ($_GET['id'] ?? 1));
if (!$pg) { http_response_code(404); include BASE_PATH . '/app/views/404.php'; exit; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PG Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body{font-family:'Inter',sans-serif;background:#f5f7ff;color:#111827}.page{max-width:1280px;margin:0 auto;padding:28px 18px 60px}.gallery{display:grid;grid-template-columns:2fr 1fr;gap:16px}.main-image{height:440px;border-radius:28px;background:linear-gradient(135deg,#dbeafe,#bfdbfe);position:relative}.thumbs{display:grid;grid-template-columns:repeat(2,1fr);gap:12px}.thumb{height:150px;border-radius:18px;background:linear-gradient(135deg,#dcfce7,#bbf7d0)}.content-grid{display:grid;grid-template-columns:1.6fr .8fr;gap:24px;margin-top:28px}.panel{background:white;border:1px solid rgba(15,23,42,.08);border-radius:24px;padding:22px;box-shadow:0 20px 30px rgba(15,23,42,.04)}.badge{display:inline-flex;padding:8px 12px;border-radius:999px;background:rgba(22,163,74,.08);color:#15803d;font-weight:700}.amenities{display:flex;flex-wrap:wrap;gap:10px}.amenity{padding:8px 12px;border-radius:999px;background:#f3f4f6;color:#374151;font-weight:600}.price-card{position:sticky;top:24px}.cta{width:100%;padding:16px;border-radius:16px;background:linear-gradient(135deg,#4f46e5,#312e81);border:none;color:white;font-weight:700}.meta{color:#6b7280}.nav-tabs .nav-link.active{background:#4f46e5;color:white}. @media (max-width: 980px){ .gallery, .content-grid { grid-template-columns: 1fr; } .price-card{position:relative;} }
    </style>
</head>
<body>
    <div class="page">
        <div class="gallery">
            <div class="main-image"></div>
            <div class="thumbs">
                <div class="thumb"></div>
                <div class="thumb" style="background:linear-gradient(135deg,#d1fae5,#a7f3d0);"></div>
                <div class="thumb" style="background:linear-gradient(135deg,#e0e7ff,#c7d2fe);"></div>
                <div class="thumb" style="background:linear-gradient(135deg,#fee2e2,#fecaca);"></div>
            </div>
        </div>

        <div class="content-grid">
            <div>
                <div class="panel mt-4">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                        <div>
                            <div class="text-primary fw-bold">Premium PG</div>
                            <h1 class="mb-1"><?= e($pg['name']) ?></h1>
                            <div class="meta"><i class="bi bi-geo-alt me-1"></i><?= e($pg['area'] . ', ' . $pg['city']) ?></div>
                        </div>
                        <span class="badge">Available</span>
                    </div>
                    <div class="mt-3"><i class="bi bi-star-fill text-warning me-1"></i> <?= number_format((float) $pg['rating'], 1) ?> rating</div>
                    <div class="amenities mt-4">
                        <span class="amenity">Wi‑Fi</span>
                        <span class="amenity">Food</span>
                        <span class="amenity">AC</span>
                        <span class="amenity">Parking</span>
                        <span class="amenity">Laundry</span>
                        <span class="amenity">CCTV</span>
                    </div>
                </div>

                <div class="panel mt-4">
                    <ul class="nav nav-tabs" data-detail-tabs>
                        <li class="nav-item"><button type="button" class="nav-link active" data-tab="overview">Overview</button></li>
                        <li class="nav-item"><button type="button" class="nav-link" data-tab="rooms">Rooms</button></li>
                        <li class="nav-item"><button type="button" class="nav-link" data-tab="amenities">Amenities</button></li>
                        <li class="nav-item"><button type="button" class="nav-link" data-tab="reviews">Reviews</button></li>
                    </ul>
                    <div class="mt-4" data-tab-panel="overview">
                        <p class="meta">A premium student accommodation with well-maintained rooms, high-speed internet, nutritious meals, and a safe community living environment near colleges and transport hubs.</p>
                        <div class="row g-3 mt-2">
                            <div class="col-md-6"><div class="p-3 rounded-4 bg-light"><strong>Room Type:</strong> Double Sharing</div></div>
                            <div class="col-md-6"><div class="p-3 rounded-4 bg-light"><strong>Available:</strong> 8 beds</div></div>
                            <div class="col-md-6"><div class="p-3 rounded-4 bg-light"><strong>Security:</strong> 24/7 CCTV</div></div>
                            <div class="col-md-6"><div class="p-3 rounded-4 bg-light"><strong>Move-in:</strong> Immediate</div></div>
                        </div>
                    </div>
                    <div class="mt-4 d-none" data-tab-panel="rooms"><p class="meta mb-0">Rooms are available in <?= e(ucfirst($pg['room_type'])) ?> sharing. Contact the owner to confirm the exact bed before moving in.</p></div>
                    <div class="mt-4 d-none" data-tab-panel="amenities"><p class="meta mb-0">Wi-Fi, food support, security monitoring, housekeeping, and common-area access are available at this property.</p></div>
                    <div class="mt-4 d-none" data-tab-panel="reviews"><p class="meta mb-0">This property is rated <?= number_format((float) $pg['rating'], 1) ?> by verified residents.</p></div>
                </div>
            </div>

            <aside class="price-card panel">
                <div class="text-secondary">Starting from</div>
                <div class="display-6 fw-bold mt-2">₹<?= number_format((float) $pg['price_from'], 0) ?> <span class="fs-6 text-secondary">/ month</span></div>
                <div class="mt-3 fw-semibold"><?= e(ucfirst($pg['room_type'])) ?> sharing</div>
                <div class="mt-2 text-success fw-semibold">Available</div>
                <?php if (current_user_role() === 'student'): ?>
                    <form method="post" action="/student/booking-request"><input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>"><input type="hidden" name="pg_id" value="<?= (int) $pg['id'] ?>"><button class="cta mt-4" type="submit">Request Booking</button></form>
                <?php else: ?>
                    <a class="cta mt-4 d-block text-center text-decoration-none" href="/login">Login to request</a>
                <?php endif; ?>
                <div class="mt-4 border-top pt-3">
                    <div class="d-flex justify-content-between"><span class="meta">Includes</span><span>Food + Wi‑Fi</span></div>
                    <div class="d-flex justify-content-between mt-2"><span class="meta">Security</span><span>24/7</span></div>
                    <div class="d-flex justify-content-between mt-2"><span class="meta">Approx. walk</span><span>2.4 km</span></div>
                </div>
            </aside>
        </div>
    </div>
    <script>
        document.querySelectorAll('[data-detail-tabs] [data-tab]').forEach(function (tab) {
            tab.addEventListener('click', function () {
                document.querySelectorAll('[data-detail-tabs] [data-tab]').forEach(function (item) { item.classList.toggle('active', item === tab); });
                document.querySelectorAll('[data-tab-panel]').forEach(function (panel) { panel.classList.toggle('d-none', panel.dataset.tabPanel !== tab.dataset.tab); });
            });
        });
    </script>
</body>
</html>
