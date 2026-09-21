<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body{font-family:'Inter',sans-serif;background:#f5f7ff;color:#111827;} .shell{max-width:1160px;margin:0 auto;padding:28px 18px 60px}.header{background:linear-gradient(135deg,#eef2ff,#f8fafc);border:1px solid rgba(15,23,42,.08);border-radius:28px;padding:26px;box-shadow:0 20px 34px rgba(15,23,42,.04)} .cover{height:180px;border-radius:22px;background:linear-gradient(135deg,#c7d2fe,#f5d0fe);position:relative}.avatar{width:124px;height:124px;border:6px solid white;border-radius:50%;background:linear-gradient(135deg,#4f46e5,#14b8a6);position:absolute;left:28px;bottom:-40px;display:grid;place-items:center;font-size:2.4rem;font-weight:800;color:white}.profile-main{padding-top:52px}.card{background:white;border:1px solid rgba(15,23,42,.08);border-radius:22px;padding:20px;box-shadow:0 18px 30px rgba(15,23,42,.04)} .stat{display:flex;justify-content:space-between;align-items:center;padding:16px 0;border-bottom:1px solid rgba(15,23,42,.08)} .stat:last-child{border:none;padding-bottom:0}.field{margin-bottom:18px}.field label{display:block;margin-bottom:8px;font-weight:600}.field .value{background:#f8fafc;border:1px solid rgba(15,23,42,.06);padding:14px 16px;border-radius:14px;color:#374151}
    </style>
</head>
<body>
    <div class="shell">
        <div class="header">
                <div class="cover">
                <div class="avatar"><?= e(strtoupper(substr(current_user()['name'], 0, 2))) ?></div>
            </div>
            <div class="profile-main d-flex justify-content-between align-items-end flex-wrap gap-3">
                <div>
                    <h1 class="mb-1"><?= e(current_user()['name']) ?></h1>
                    <div class="text-secondary">Student • Chennai</div>
                </div>
                <a class="btn btn-dark" href="/student/profile/edit">Edit Profile</a>
            </div>
        </div>

        <div class="row mt-4 g-4">
            <div class="col-lg-4">
                <div class="card">
                    <h5 class="mb-3">Personal Information</h5>
                    <div class="stat"><span class="text-secondary">Phone</span><strong>+91 98765 43210</strong></div>
                    <div class="stat"><span class="text-secondary">Email</span><strong><?= e(current_user()['email']) ?></strong></div>
                    <div class="stat"><span class="text-secondary">Gender</span><strong>Male</strong></div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <h5 class="mb-3">Contact & Education</h5>
                    <div class="row">
                        <div class="col-md-6 field"><label>College</label><div class="value">SRM Institute of Technology</div></div>
                        <div class="col-md-6 field"><label>Course</label><div class="value">B.Tech Computer Science</div></div>
                        <div class="col-md-6 field"><label>Emergency Contact</label><div class="value">Ravi Kumar</div></div>
                        <div class="col-md-6 field"><label>Relation</label><div class="value">Brother</div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
