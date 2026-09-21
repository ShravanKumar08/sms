<?php $pgs = PG::publicListings(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
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
            --shadow-md: 0 18px 40px rgba(15, 23, 42, 0.08);
            --radius-lg: 24px;
        }
        body { margin: 0; background: linear-gradient(180deg, #f6f8ff 0%, #eef2ff 100%); font-family: 'Inter', sans-serif; color: var(--text-primary); }
        .page-shell { max-width: 1200px; margin: 0 auto; padding: 28px 18px 60px; }
        .hero {
            background: linear-gradient(135deg, rgba(79,70,229,0.08), rgba(20,184,166,0.12));
            border: 1px solid var(--border-color); border-radius: 28px; padding: 28px; box-shadow: var(--shadow-sm);
        }
        .hero h1 { font-size: clamp(2rem, 3vw, 3rem); font-weight: 800; margin: 0 0 8px; }
        .hero p { color: var(--text-secondary); margin: 0 0 22px; }
        .search-box { display: flex; gap: 10px; background: white; border-radius: 18px; padding: 12px; border: 1px solid var(--border-color); box-shadow: var(--shadow-sm); }
        .search-box input { flex: 1; border: none; background: transparent; padding: 12px 14px; }
        .search-box button { background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)); color: white; border: none; border-radius: 14px; padding: 12px 22px; font-weight: 700; }
        .cards-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 20px; margin-top: 28px; }
        .pg-card { background: white; border: 1px solid var(--border-color); border-radius: 24px; overflow: hidden; box-shadow: var(--shadow-sm); }
        .pg-card .image { height: 220px; background: linear-gradient(135deg, #dbeafe, #c7d2fe); }
        .pg-card .body { padding: 18px; }
        .pg-name { font-size: 1.3rem; font-weight: 800; }
        .meta { color: var(--text-secondary); margin-top: 6px; }
        .rating { margin-top: 12px; color: #f59e0b; }
        .price { font-size: 1.6rem; font-weight: 800; margin-top: 10px; }
        .smaller { font-size: 0.85rem; color: var(--text-secondary); }
        .badge-pill { display: inline-block; background: rgba(22,163,74,0.1); color: var(--success-color); border-radius: 999px; padding: 7px 10px; font-size: 0.78rem; font-weight: 700; }
    </style>
</head>
<body>
    <div class="page-shell">
        <section class="hero">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <div class="text-primary fw-bold mb-1">Student Portal</div>
                    <h1>Welcome back, Arjun 👋</h1>
                </div>
                <div class="d-flex gap-2"><a href="/student/bookings" class="btn btn-outline-primary">Bookings</a><a href="/student/profile" class="btn btn-outline-dark">Profile</a><a href="/logout" class="btn btn-outline-dark">Logout</a></div>
            </div>
            <p>Let's find a place you'll love.</p>
            <form class="search-box" method="get" action="/student/search">
                <input name="q" type="text" placeholder="Where do you want to stay?" value="">
                <button type="submit">Search PG</button>
            </form>
        </section>

        <section class="cards-grid">
            <?php foreach ($pgs as $pg): ?>
                <article class="pg-card">
                    <div class="image"></div>
                    <div class="body">
                        <div class="pg-name"><?= e($pg['name']) ?></div>
                        <div class="meta"><?= e($pg['area'] . ', ' . $pg['city']) ?></div>
                        <div class="rating"><i class="bi bi-star-fill"></i> <?= number_format((float) $pg['rating'], 1) ?></div>
                        <div class="smaller mt-3">Verified accommodation • <?= e($pg['room_type']) ?> rooms</div>
                        <div class="price">₹<?= number_format((float) $pg['price_from'], 0) ?><span class="smaller">/month</span></div>
                        <div class="mt-3 d-flex justify-content-between align-items-center">
                            <span class="badge-pill">View availability</span>
                            <a class="btn btn-dark" href="/pg-details?id=<?= (int) $pg['id'] ?>">View Details</a>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </section>
    </div>
</body>
</html>
