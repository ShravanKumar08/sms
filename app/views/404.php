<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            background: linear-gradient(135deg, #eef2ff 0%, #f8fafc 100%);
            font-family: 'Inter', sans-serif;
            color: #111827;
        }
        .error-card {
            width: min(680px, calc(100% - 32px));
            background: rgba(255,255,255,0.85);
            border: 1px solid rgba(15,23,42,0.08);
            border-radius: 28px;
            box-shadow: 0 30px 60px rgba(79,70,229,0.12);
            padding: 40px 30px;
            text-align: center;
        }
        .error-code {
            font-size: clamp(4rem, 13vw, 8rem);
            font-weight: 800;
            background: linear-gradient(135deg, #4f46e5, #14b8a6);
            -webkit-background-clip: text;
            color: transparent;
            line-height: 1;
        }
        .error-card h1 { font-weight: 800; margin: 12px 0 8px; }
        .error-card p { color: #6b7280; margin-bottom: 24px; }
        .btn-primary-custom { background: linear-gradient(135deg, #4f46e5, #312e81); border: none; border-radius: 14px; padding: 12px 22px; }
    </style>
</head>
<body>
    <div class="error-card">
        <div class="error-code">404</div>
        <h1>We couldn't find that page.</h1>
        <p>The page you're looking for doesn't exist or may have been moved.</p>
        <a href="/login" class="btn btn-primary-custom text-white">Back to Dashboard</a>
    </div>
</body>
</html>
