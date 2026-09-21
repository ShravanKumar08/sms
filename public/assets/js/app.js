document.addEventListener('DOMContentLoaded', function () {
    const root = document.body;
    const savedTheme = localStorage.getItem('pg-theme');
    if (savedTheme) {
        root.setAttribute('data-theme', savedTheme);
    }

    const themeButtons = document.querySelectorAll('[data-theme-toggle]');
    themeButtons.forEach((button) => {
        button.addEventListener('click', function () {
            const current = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            root.setAttribute('data-theme', current);
            localStorage.setItem('pg-theme', current);
        });
    });

    const loginButton = document.getElementById('loginBtn');
    if (loginButton) {
        loginButton.addEventListener('click', function () {
            this.classList.add('btn-loading');
            const label = this.querySelector('.btn-label');
            if (label) label.innerHTML = '<span class="me-2"><i class="bi bi-arrow-repeat"></i></span>Signing in...';
        });
    }

    document.querySelectorAll('[data-favorite]').forEach((button) => {
        button.addEventListener('click', function () {
            const active = this.dataset.favorite === 'active';
            this.dataset.favorite = active ? 'inactive' : 'active';
            this.querySelector('i')?.classList.toggle('bi-heart-fill', !active);
            this.querySelector('i')?.classList.toggle('bi-heart', active);
            showToast(active ? 'Removed from favorites' : 'Saved to favorites');
        });
    });
});

function showToast(message, type = 'success') {
    const existing = document.querySelector('.toast');
    if (existing) existing.remove();

    const toast = document.createElement('div');
    toast.className = 'toast show';
    toast.innerHTML = '<div class="d-flex align-items-center gap-2"><span class="fw-bold">' + (type === 'success' ? '✓' : type === 'warning' ? '⚠' : '✕') + '</span><span>' + message + '</span></div>';
    document.body.appendChild(toast);
    setTimeout(() => toast.classList.remove('show'), 2200);
    setTimeout(() => toast.remove(), 2800);
}
