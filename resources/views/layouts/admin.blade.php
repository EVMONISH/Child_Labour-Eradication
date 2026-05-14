<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') | CLE Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --sidebar-w: 260px; --primary: #6366f1; --dark: #0f172a; --darker: #080f1f; }
        * { box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #0f172a; color: #e2e8f0; margin: 0; display: flex; min-height: 100vh; }
        /* Sidebar */
        .sidebar { width: var(--sidebar-w); background: linear-gradient(180deg, #080f1f 0%, #0f172a 100%); border-right: 1px solid rgba(255,255,255,0.07); position: fixed; top: 0; left: 0; height: 100vh; overflow-y: auto; z-index: 1000; display: flex; flex-direction: column; }
        .sidebar-brand { padding: 24px 20px; border-bottom: 1px solid rgba(255,255,255,0.07); }
        .sidebar-brand h6 { font-size: 0.7rem; letter-spacing: 2px; color: #64748b; text-transform: uppercase; margin: 0 0 4px; }
        .sidebar-brand h5 { font-size: 1.1rem; font-weight: 800; margin: 0; background: linear-gradient(90deg, #a78bfa, #60a5fa); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .sidebar-nav { padding: 16px 12px; flex: 1; }
        .sidebar-section { font-size: 0.68rem; letter-spacing: 1.5px; text-transform: uppercase; color: #475569; font-weight: 600; padding: 16px 8px 6px; }
        .sidebar .nav-link { color: #94a3b8; border-radius: 10px; padding: 10px 14px; font-weight: 500; font-size: 0.9rem; display: flex; align-items: center; gap: 10px; transition: all 0.2s; margin-bottom: 2px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: rgba(99,102,241,0.15); color: #a78bfa; }
        .sidebar .nav-link i { font-size: 1.1rem; width: 20px; }
        .sidebar-footer { padding: 16px; border-top: 1px solid rgba(255,255,255,0.07); }
        /* Main */
        .main-wrap { margin-left: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; }
        .topbar { background: rgba(15,23,42,0.95); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255,255,255,0.07); padding: 14px 28px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 100; }
        .topbar-title { font-size: 1rem; font-weight: 600; color: #e2e8f0; }
        .user-badge { background: rgba(99,102,241,0.15); border: 1px solid rgba(99,102,241,0.3); border-radius: 10px; padding: 6px 14px; font-size: 0.85rem; color: #a78bfa; font-weight: 600; }
        .page-content { padding: 28px; flex: 1; }
        /* Cards */
        .stat-card { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08); border-radius: 16px; padding: 20px; transition: transform 0.2s, box-shadow 0.2s; }
        .stat-card:hover { transform: translateY(-4px); box-shadow: 0 12px 40px rgba(0,0,0,0.3); }
        .stat-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; }
        .stat-num { font-size: 2rem; font-weight: 800; }
        .stat-label { font-size: 0.82rem; color: #64748b; font-weight: 500; }
        .card { background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); border-radius: 16px; }
        .card-header { background: rgba(255,255,255,0.04); border-bottom: 1px solid rgba(255,255,255,0.07); padding: 16px 20px; }
        .card-body { padding: 20px; }
        /* Table */
        .table { color: #e2e8f0; }
        .table thead th { background: rgba(255,255,255,0.04); border-color: rgba(255,255,255,0.07); font-size: 0.8rem; letter-spacing: 0.5px; text-transform: uppercase; color: #64748b; font-weight: 600; }
        .table tbody tr { border-color: rgba(255,255,255,0.05); transition: background 0.15s; }
        .table tbody tr:hover { background: rgba(99,102,241,0.07); }
        .table td { border-color: rgba(255,255,255,0.05); vertical-align: middle; }
        /* Forms */
        .form-control, .form-select { background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12); color: #e2e8f0; border-radius: 10px; }
        .form-control:focus, .form-select:focus { background: rgba(255,255,255,0.1); border-color: #6366f1; color: #e2e8f0; box-shadow: 0 0 0 3px rgba(99,102,241,0.2); }
        .form-control::placeholder { color: #475569; }
        .form-label { color: #94a3b8; font-size: 0.88rem; font-weight: 500; }
        .form-select option { background: #1e293b; }
        /* Buttons */
        .btn-primary { background: linear-gradient(135deg,#6366f1,#4f46e5); border: none; font-weight: 600; border-radius: 10px; }
        .btn-primary:hover { background: linear-gradient(135deg,#4f46e5,#3730a3); transform: translateY(-1px); }
        .btn-success { background: linear-gradient(135deg,#10b981,#059669); border: none; font-weight: 600; border-radius: 10px; }
        .btn-danger { background: linear-gradient(135deg,#ef4444,#dc2626); border: none; font-weight: 600; border-radius: 10px; }
        .btn-warning { background: linear-gradient(135deg,#f59e0b,#d97706); border: none; font-weight: 600; border-radius: 10px; color: #fff; }
        .btn-outline-secondary { border-color: rgba(255,255,255,0.15); color: #94a3b8; border-radius: 10px; font-weight: 500; }
        .btn-outline-secondary:hover { background: rgba(255,255,255,0.08); color: #e2e8f0; border-color: rgba(255,255,255,0.2); }
        .badge { border-radius: 8px; font-weight: 600; font-size: 0.75rem; padding: 5px 10px; }
        .badge-pending { background: rgba(245,158,11,0.15); color: #f59e0b; }
        .badge-investigation { background: rgba(59,130,246,0.15); color: #60a5fa; }
        .badge-rescued { background: rgba(99,102,241,0.15); color: #a78bfa; }
        .badge-rehabilitated { background: rgba(16,185,129,0.15); color: #34d399; }
        .badge-approved { background: rgba(16,185,129,0.15); color: #34d399; }
        .badge-rejected { background: rgba(239,68,68,0.15); color: #f87171; }
        /* Timeline */
        .timeline { position: relative; padding-left: 24px; }
        .timeline::before { content: ''; position: absolute; left: 8px; top: 0; bottom: 0; width: 2px; background: rgba(255,255,255,0.1); }
        .timeline-item { position: relative; margin-bottom: 20px; }
        .timeline-item::before { content: ''; position: absolute; left: -20px; top: 6px; width: 10px; height: 10px; background: #6366f1; border-radius: 50%; border: 2px solid #0f172a; }
        /* Alert */
        .alert { border-radius: 12px; border: none; }
        /* Pagination */
        .pagination .page-link { background: rgba(255,255,255,0.06); border-color: rgba(255,255,255,0.1); color: #94a3b8; }
        .pagination .page-link:hover { background: #6366f1; color: #fff; border-color: #6366f1; }
        .pagination .active .page-link { background: #6366f1; border-color: #6366f1; }
        
        /* Light Theme Overrides */
        body.light-theme { background: #f8fafc; color: #1e293b; }
        body.light-theme .sidebar { background: #ffffff; border-right: 1px solid #e2e8f0; }
        body.light-theme .sidebar-brand { border-bottom: 1px solid #e2e8f0; }
        body.light-theme .sidebar-brand h5 { background: linear-gradient(90deg, #6366f1, #3b82f6); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        body.light-theme .sidebar-footer { border-top: 1px solid #e2e8f0; }
        body.light-theme .topbar { background: rgba(255, 255, 255, 0.95); border-bottom: 1px solid #e2e8f0; }
        body.light-theme .topbar-title { color: #1e293b; }
        body.light-theme .card, body.light-theme .stat-card { background: #ffffff; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); }
        body.light-theme .card-header { background: #ffffff; border-bottom: 1px solid #e2e8f0; }
        body.light-theme .table { color: #1e293b; }
        body.light-theme .table thead th { background: #f1f5f9; border-color: #e2e8f0; color: #475569; }
        body.light-theme .table tbody tr { border-color: #e2e8f0; }
        body.light-theme .table tbody tr:hover { background: #f8fafc; }
        body.light-theme .table td { border-color: #e2e8f0; }
        body.light-theme .form-control, body.light-theme .form-select { background: #ffffff; border: 1px solid #cbd5e1; color: #1e293b; }
        body.light-theme .form-select option { background: #ffffff; color: #1e293b; }
        body.light-theme .form-control:focus, body.light-theme .form-select:focus { background: #ffffff; border-color: #6366f1; color: #1e293b; box-shadow: 0 0 0 3px rgba(99,102,241,0.2); }
        body.light-theme .sidebar .nav-link { color: #475569; }
        body.light-theme .sidebar .nav-link:hover, body.light-theme .sidebar .nav-link.active { background: rgba(99,102,241,0.1); color: #4f46e5; }
        body.light-theme .timeline::before { background: #e2e8f0; }
        body.light-theme .timeline-item::before { border: 2px solid #ffffff; }
        body.light-theme .pagination .page-link { background: #ffffff; border-color: #e2e8f0; color: #475569; }
        body.light-theme .user-badge { background: rgba(99,102,241,0.1); color: #4f46e5; border-color: rgba(99,102,241,0.2); }
        body.light-theme .btn-outline-secondary { border-color: #cbd5e1; color: #475569; }
        body.light-theme .btn-outline-secondary:hover { background: #f1f5f9; color: #1e293b; border-color: #94a3b8; }
        body.light-theme .text-muted { color: #64748b !important; }
    </style>
    @yield('styles')
    <script>
        const currentTheme = localStorage.getItem('theme');
        if (currentTheme === 'light') {
            document.documentElement.classList.add('light-theme'); // Adding to html tag is safer for early execution
            document.addEventListener('DOMContentLoaded', function() {
                document.body.classList.add('light-theme');
            });
        }
    </script>
</head>
<body>
<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="sidebar-brand">
        <h6>Admin Panel</h6>
        <h5><i class="bi bi-shield-heart-fill"></i> CLE Portal</h5>
    </div>
    <nav class="sidebar-nav">
        <div class="sidebar-section">Main</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <div class="sidebar-section">Cases</div>
        <a href="{{ route('admin.complaints.index') }}" class="nav-link {{ request()->routeIs('admin.complaints*') ? 'active' : '' }}">
            <i class="bi bi-megaphone-fill"></i> Complaints
        </a>
        <a href="{{ route('admin.cases.index') }}" class="nav-link {{ request()->routeIs('admin.cases*') ? 'active' : '' }}">
            <i class="bi bi-folder2-open"></i> Cases
        </a>
        <div class="sidebar-section">Database</div>
        <a href="{{ route('admin.children.index') }}" class="nav-link {{ request()->routeIs('admin.children*') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i> Child Database
        </a>
        <div class="sidebar-section">Reports</div>
        <a href="{{ route('admin.analytics') }}" class="nav-link {{ request()->routeIs('admin.analytics') ? 'active' : '' }}">
            <i class="bi bi-bar-chart-fill"></i> Analytics
        </a>
    </nav>
    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-secondary w-100 btn-sm">
                <i class="bi bi-box-arrow-left me-2"></i>Logout
            </button>
        </form>
    </div>
</aside>

<!-- MAIN -->
<div class="main-wrap">
    <div class="topbar">
        <span class="topbar-title"><i class="bi bi-chevron-right text-muted me-2"></i>@yield('page-title', 'Dashboard')</span>
        <div class="d-flex align-items-center gap-3">
            <button id="theme-toggle" class="btn btn-outline-secondary btn-sm" style="border-radius:50%;width:35px;height:35px;display:flex;align-items:center;justify-content:center;" title="Toggle Theme"><i class="bi bi-sun-fill"></i></button>
            <div class="user-badge"><i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}</div>
        </div>
    </div>
    <div class="page-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4"><i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const themeToggleBtn = document.getElementById('theme-toggle');
        
        if (localStorage.getItem('theme') === 'light' && themeToggleBtn) {
            themeToggleBtn.innerHTML = '<i class="bi bi-moon-fill"></i>';
        }
        
        if(themeToggleBtn) {
            themeToggleBtn.addEventListener('click', function() {
                document.body.classList.toggle('light-theme');
                document.documentElement.classList.toggle('light-theme');
                let theme = 'dark';
                if (document.body.classList.contains('light-theme')) {
                    theme = 'light';
                    themeToggleBtn.innerHTML = '<i class="bi bi-moon-fill"></i>';
                } else {
                    themeToggleBtn.innerHTML = '<i class="bi bi-sun-fill"></i>';
                }
                localStorage.setItem('theme', theme);
            });
        }
    });
</script>
@yield('scripts')
</body>
</html>
