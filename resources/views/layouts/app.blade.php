<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<title>Child Labour Eradication System</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&family=DM+Sans:wght@400;500&display=swap');
  *{box-sizing:border-box;margin:0;padding:0}
  :root{
    --bg:#0a0e1a;--bg2:#111827;--bg3:#1a2235;--card:#1e2d45;
    --accent:#3b82f6;--accent2:#10b981;--warn:#f59e0b;--danger:#ef4444;
    --text:#f1f5f9;--text2:#94a3b8;--text3:#64748b;
    --border:#2d3f5e;--radius:12px;--radius2:8px;
    --sora:'Sora',sans-serif;--dm:'DM Sans',sans-serif;
  }
  :root.light-theme {
    --bg:#f8fafc;--bg2:#ffffff;--bg3:#f1f5f9;--card:#ffffff;
    --accent:#2563eb;--accent2:#059669;--warn:#d97706;--danger:#dc2626;
    --text:#0f172a;--text2:#475569;--text3:#64748b;
    --border:#e2e8f0;
  }
  body{font-family:var(--dm);background:var(--bg);color:var(--text);min-height:100vh;overflow-x:hidden;transition:background 0.3s, color 0.3s;}
  a{text-decoration:none}
  button{font-family:var(--dm);cursor:pointer;border:none;outline:none}
  input,select,textarea{font-family:var(--dm);outline:none;border:none}

  /* SIDEBAR */
  .sidebar{position:fixed;top:0;left:0;width:240px;height:100vh;background:var(--bg2);border-right:1px solid var(--border);z-index:100;display:flex;flex-direction:column;transition:transform .3s}
  .sidebar-logo{padding:24px 20px 16px;display:flex;align-items:center;gap:10px;border-bottom:1px solid var(--border)}
  .logo-icon{width:34px;height:34px;background:linear-gradient(135deg,#3b82f6,#10b981);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:16px}
  .logo-text{font-family:var(--sora);font-size:13px;font-weight:700;line-height:1.3;color:var(--text)}
  .logo-text span{color:var(--accent2)}
  .nav-section{padding:16px 12px 8px;font-size:10px;letter-spacing:.08em;color:var(--text3);text-transform:uppercase;font-weight:600}
  .nav-item{display:flex;align-items:center;gap:10px;padding:10px 14px;margin:2px 8px;border-radius:var(--radius2);cursor:pointer;font-size:13.5px;color:var(--text2);transition:all .18s;font-weight:500}
  .nav-item:hover{background:var(--bg3);color:var(--text)}
  .nav-item.active{background:rgba(59,130,246,.15);color:var(--accent);border-left:2.5px solid var(--accent)}
  .nav-icon{width:16px;text-align:center;font-size:15px}
  .sidebar-bottom{margin-top:auto;padding:16px;border-top:1px solid var(--border)}
  .role-badge{display:inline-flex;align-items:center;gap:6px;padding:6px 12px;border-radius:20px;font-size:12px;font-weight:600}
  .role-admin{background:rgba(239,68,68,.15);color:#f87171}
  .role-ngo{background:rgba(16,185,129,.15);color:#34d399}
  .role-public{background:rgba(59,130,246,.15);color:#60a5fa}

  /* MAIN */
  .main{margin-left:240px;min-height:100vh;padding:28px 32px}
  .page{display:none}
  .page.active{display:block;animation:fadeIn .25s ease}
  @keyframes fadeIn{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:translateY(0)}}

  /* TOPBAR */
  .topbar{display:flex;align-items:center;justify-content:space-between;margin-bottom:28px}
  .page-title{font-family:var(--sora);font-size:22px;font-weight:700;color:var(--text)}
  .page-sub{font-size:13px;color:var(--text3);margin-top:2px}
  .topbar-right{display:flex;gap:10px;align-items:center}
  .btn{padding:9px 18px;border-radius:var(--radius2);font-size:13px;font-weight:600;cursor:pointer;transition:all .18s}
  .btn-primary{background:var(--accent);color:#fff}
  .btn-primary:hover{background:#2563eb}
  .btn-success{background:var(--accent2);color:#fff}
  .btn-success:hover{background:#059669}
  .btn-ghost{background:transparent;color:var(--text2);border:1px solid var(--border)}
  .btn-ghost:hover{background:var(--bg3);color:var(--text)}
  .btn-danger{background:rgba(239,68,68,.15);color:#f87171;border:1px solid rgba(239,68,68,.25)}
  .btn-danger:hover{background:rgba(239,68,68,.25)}
  .btn-warn{background:rgba(245,158,11,.15);color:#fbbf24;border:1px solid rgba(245,158,11,.25)}
  .btn-warn:hover{background:rgba(245,158,11,.25)}
  .btn-sm{padding:6px 12px;font-size:12px}

  /* CARDS */
  .card{background:var(--card);border:1px solid var(--border);border-radius:var(--radius);padding:22px}
  .card-title{font-family:var(--sora);font-size:14px;font-weight:600;color:var(--text2);margin-bottom:16px;letter-spacing:.02em}
  .grid-4{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px}
  .grid-3{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:24px}
  .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:24px}
  .stat-card{background:var(--card);border:1px solid var(--border);border-radius:var(--radius);padding:20px;position:relative;overflow:hidden}
  .stat-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;border-radius:var(--radius) var(--radius) 0 0}
  .stat-card.blue::before{background:var(--accent)}
  .stat-card.green::before{background:var(--accent2)}
  .stat-card.warn::before{background:var(--warn)}
  .stat-card.red::before{background:var(--danger)}
  .stat-val{font-family:var(--sora);font-size:32px;font-weight:700;color:var(--text);line-height:1}
  .stat-label{font-size:12px;color:var(--text3);margin-top:6px;font-weight:500}
  .stat-trend{font-size:11px;margin-top:8px;font-weight:600}
  .stat-trend.up{color:var(--accent2)}
  .stat-trend.down{color:var(--danger)}

  /* TABLE */
  .table-wrap{overflow-x:auto;border-radius:var(--radius);border:1px solid var(--border)}
  table{width:100%;border-collapse:collapse;background:var(--card)}
  th{padding:12px 16px;text-align:left;font-size:11px;font-weight:600;letter-spacing:.06em;color:var(--text3);text-transform:uppercase;border-bottom:1px solid var(--border);background:var(--bg3)}
  td{padding:13px 16px;font-size:13px;color:var(--text2);border-bottom:1px solid rgba(45,63,94,.5)}
  tr:last-child td{border-bottom:none}
  tr:hover td{background:rgba(59,130,246,.04)}
  .td-primary{color:var(--text);font-weight:500}

  /* BADGES */
  .badge{display:inline-flex;align-items:center;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;letter-spacing:.02em}
  .badge-pending{background:rgba(245,158,11,.15);color:#fbbf24}
  .badge-approved{background:rgba(16,185,129,.15);color:#34d399}
  .badge-rejected{background:rgba(239,68,68,.15);color:#f87171}
  .badge-active{background:rgba(59,130,246,.15);color:#60a5fa}
  .badge-resolved{background:rgba(99,102,241,.15);color:#a78bfa}
  .badge-progress{background:rgba(245,158,11,.15);color:#fbbf24}

  /* FORM */
  .form-group{margin-bottom:18px}
  .form-label{display:block;font-size:12px;font-weight:600;color:var(--text2);margin-bottom:7px;letter-spacing:.03em}
  .form-input{width:100%;padding:10px 14px;background:var(--bg3);border:1px solid var(--border);border-radius:var(--radius2);color:var(--text);font-size:13.5px;transition:border .18s}
  .form-input:focus{border-color:var(--accent)}
  textarea.form-input{resize:vertical;min-height:90px}
  select.form-input{cursor:pointer}
  select.form-input option{background:var(--bg3)}
  .form-row{display:grid;grid-template-columns:1fr 1fr;gap:16px}

  /* MODAL */
  .modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.65);z-index:500;align-items:center;justify-content:center}
  .modal-overlay.open{display:flex;animation:fadeIn .2s}
  .modal{background:var(--bg2);border:1px solid var(--border);border-radius:var(--radius);padding:28px;width:540px;max-width:95vw;max-height:90vh;overflow-y:auto}
  .modal-title{font-family:var(--sora);font-size:18px;font-weight:700;margin-bottom:20px;display:flex;justify-content:space-between;align-items:center}
  .modal-close{background:none;border:none;color:var(--text3);font-size:20px;cursor:pointer;padding:2px 8px;border-radius:4px}
  .modal-close:hover{color:var(--text);background:var(--bg3)}

  /* TRACK FORM */
  .track-box{background:var(--card);border:1px solid var(--border);border-radius:var(--radius);padding:32px;max-width:560px;margin:auto}
  .track-result{background:var(--bg3);border:1px solid var(--border);border-radius:var(--radius2);padding:18px;margin-top:16px}
  .track-id{font-family:monospace;font-size:20px;font-weight:700;letter-spacing:.12em;color:var(--accent)}
  .status-timeline{position:relative;padding-left:24px;margin-top:16px}
  .status-timeline::before{content:'';position:absolute;left:6px;top:6px;bottom:0;width:2px;background:var(--border)}
  .timeline-item{position:relative;margin-bottom:16px}
  .timeline-dot{width:14px;height:14px;border-radius:50%;background:var(--border);border:2px solid var(--border);position:absolute;left:-21px;top:2px}
  .timeline-dot.active{background:var(--accent);border-color:var(--accent)}
  .timeline-dot.done{background:var(--accent2);border-color:var(--accent2)}
  .timeline-label{font-size:13px;font-weight:600;color:var(--text)}
  .timeline-meta{font-size:11px;color:var(--text3);margin-top:2px}

  /* CHART BAR */
  .chart-bars{display:flex;align-items:flex-end;gap:8px;height:120px;padding:0 4px}
  .chart-bar{flex:1;border-radius:4px 4px 0 0;min-width:20px;position:relative;transition:opacity .2s}
  .chart-bar:hover{opacity:.8}
  .chart-bar-label{position:absolute;bottom:-20px;left:50%;transform:translateX(-50%);font-size:10px;color:var(--text3);white-space:nowrap}

  /* PROGRESS LOG */
  .update-log{background:var(--bg3);border:1px solid var(--border);border-radius:var(--radius2);padding:14px;margin-bottom:10px}
  .update-log-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:6px}
  .update-log-date{font-size:11px;color:var(--text3)}
  .update-log-text{font-size:13px;color:var(--text2);line-height:1.5}

  /* LANDING */
  .landing-hero{text-align:center;padding:60px 20px 40px;position:relative}
  .hero-badge{display:inline-flex;align-items:center;gap:6px;padding:5px 14px;background:rgba(59,130,246,.12);border:1px solid rgba(59,130,246,.25);border-radius:20px;font-size:12px;color:#60a5fa;margin-bottom:20px;font-weight:600}
  .hero-title{font-family:var(--sora);font-size:38px;font-weight:700;line-height:1.2;margin-bottom:14px}
  .hero-title span{background:linear-gradient(135deg,#3b82f6,#10b981);-webkit-background-clip:text;-webkit-text-fill-color:transparent}
  .hero-sub{font-size:15px;color:var(--text2);max-width:480px;margin:0 auto 32px;line-height:1.6}
  .hero-btns{display:flex;gap:12px;justify-content:center;flex-wrap:wrap}
  .feature-card{background:var(--card);border:1px solid var(--border);border-radius:var(--radius);padding:24px;text-align:center}
  .feature-icon{font-size:28px;margin-bottom:12px}
  .feature-title{font-family:var(--sora);font-size:15px;font-weight:600;margin-bottom:6px}
  .feature-desc{font-size:13px;color:var(--text3);line-height:1.5}

  /* LOGIN */
  .login-wrap{min-height:80vh;display:flex;align-items:center;justify-content:center}
  .login-card{background:var(--card);border:1px solid var(--border);border-radius:var(--radius);padding:36px;width:400px;max-width:95vw}
  .login-logo{text-align:center;margin-bottom:24px}
  .login-title{font-family:var(--sora);font-size:20px;font-weight:700;text-align:center;margin-bottom:4px}
  .login-sub{font-size:13px;color:var(--text3);text-align:center;margin-bottom:24px}
  .tab-row{display:flex;gap:0;background:var(--bg3);border-radius:var(--radius2);padding:3px;margin-bottom:20px}
  .tab-btn{flex:1;padding:8px;border-radius:6px;font-size:13px;font-weight:600;background:none;color:var(--text3);border:none;cursor:pointer;transition:all .18s}
  .tab-btn.active{background:var(--card);color:var(--text);box-shadow:0 1px 4px rgba(0,0,0,.3)}

  /* ALERT */
  .alert{padding:12px 16px;border-radius:var(--radius2);font-size:13px;margin-bottom:16px;display:flex;gap:10px;align-items:flex-start}
  .alert-success{background:rgba(16,185,129,.12);border:1px solid rgba(16,185,129,.25);color:#34d399}
  .alert-info{background:rgba(59,130,246,.12);border:1px solid rgba(59,130,246,.25);color:#60a5fa}
  .alert-warn{background:rgba(245,158,11,.12);border:1px solid rgba(245,158,11,.25);color:#fbbf24}
  .alert-danger{background:rgba(239,68,68,.15);border:1px solid rgba(239,68,68,.25);color:#f87171}

  /* SECTION HEADER */
  .sec-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:16px}
  .sec-title{font-family:var(--sora);font-size:16px;font-weight:600}
  .detail-grid{display:grid;grid-template-columns:140px 1fr;gap:8px 16px;font-size:13px}
  .detail-key{color:var(--text3);font-weight:500}
  .detail-val{color:var(--text)}
  .divider{height:1px;background:var(--border);margin:20px 0}
  .tag{display:inline-block;padding:2px 8px;background:var(--bg3);border:1px solid var(--border);border-radius:4px;font-size:11px;color:var(--text3)}

  /* SCROLLBAR */
  ::-webkit-scrollbar{width:5px;height:5px}
  ::-webkit-scrollbar-track{background:var(--bg2)}
  ::-webkit-scrollbar-thumb{background:var(--border);border-radius:3px}

  /* RESPONSIVE HIDE SIDEBAR on narrow */
  @media(max-width:900px){.sidebar{transform:translateX(-240px)}.main{margin-left:0}}
</style>
<script>
    if (localStorage.getItem('theme') === 'light') {
        document.documentElement.classList.add('light-theme');
    }
</script>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
  <div class="sidebar-logo">
    <div class="logo-icon">🛡</div>
    <div class="logo-text">Child Labour<br><span>Eradication System</span></div>
  </div>

  @guest
  <!-- PUBLIC NAV -->
  <div id="nav-public">
    <div class="nav-section">Public</div>
    <a href="{{ url('/') }}" class="nav-item {{ request()->is('/') ? 'active' : '' }}">🏠 <span>Home</span></a>
    <a href="{{ route('complaint.create') }}" class="nav-item {{ request()->routeIs('complaint.create') ? 'active' : '' }}">📝 <span>Report Incident</span></a>
    <a href="{{ route('complaint.track') }}" class="nav-item {{ request()->routeIs('complaint.track') ? 'active' : '' }}">🔍 <span>Track Complaint</span></a>
    <a href="{{ route('stories.index') }}" class="nav-item {{ request()->routeIs('stories.index') ? 'active' : '' }}">📖 <span>Stories of Hope</span></a>
    <a href="{{ route('login') }}" class="nav-item {{ request()->routeIs('login') ? 'active' : '' }}">🔐 <span>Staff Login</span></a>
  </div>
  @endguest

  @auth
    @if(auth()->user()->role == 'admin')
    <!-- ADMIN NAV -->
    <div id="nav-admin">
      <div class="nav-section">Admin Panel</div>
      <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">📊 <span>Dashboard</span></a>
      <a href="{{ route('admin.impact') }}" class="nav-item {{ request()->routeIs('admin.impact') ? 'active' : '' }}">📈 <span>Impact Dashboard</span></a>
      <a href="{{ route('admin.complaints.index') }}" class="nav-item {{ request()->routeIs('admin.complaints.*') ? 'active' : '' }}">📋 <span>Complaints</span></a>
      <a href="{{ route('admin.cases.index') }}" class="nav-item {{ request()->routeIs('admin.cases.*') ? 'active' : '' }}">📁 <span>Cases</span></a>
      <a href="{{ route('admin.children.index') }}" class="nav-item {{ request()->routeIs('admin.children.*') ? 'active' : '' }}">👶 <span>Children Registry</span></a>
      <a href="{{ route('admin.stories.index') }}" class="nav-item {{ request()->routeIs('admin.stories.*') ? 'active' : '' }}">📖 <span>Stories Approval</span></a>
      <a href="{{ route('admin.analytics') }}" class="nav-item {{ request()->routeIs('admin.analytics') ? 'active' : '' }}">📈 <span>Analytics</span></a>
    </div>
    @elseif(auth()->user()->role == 'ngo')
    <!-- NGO NAV -->
    <div id="nav-ngo">
      <div class="nav-section">NGO Portal</div>
      <a href="{{ route('ngo.dashboard') }}" class="nav-item {{ request()->routeIs('ngo.dashboard') ? 'active' : '' }}">🏢 <span>My Cases</span></a>
      <a href="{{ route('ngo.contributions') }}" class="nav-item {{ request()->routeIs('ngo.contributions') ? 'active' : '' }}">🤝 <span>My Contributions</span></a>
      @if(request()->routeIs('ngo.cases.show'))
      <a href="#" class="nav-item active">📁 <span>Case Detail</span></a>
      @endif
    </div>
    @endif
  @endauth

  <div class="sidebar-bottom">
    @guest
    <div class="role-badge role-public">👤 Public</div>
    @else
      @if(auth()->user()->role == 'admin')
      <div class="role-badge role-admin">🔑 Admin</div>
      @elseif(auth()->user()->role == 'ngo')
      <div class="role-badge role-ngo">🤝 NGO</div>
      @endif
      <div style="margin-top:10px">
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="btn btn-ghost btn-sm" style="width:100%">↩ Logout</button>
        </form>
      </div>
    @endguest
  </div>
</div>

<!-- MAIN CONTENT -->
<div class="main">
  @if(session('success'))
  <div class="alert alert-success">
    ✅ {{ session('success') }}
  </div>
  @endif
  @if(session('error'))
  <div class="alert alert-danger">
    ⚠️ {{ session('error') }}
  </div>
  @endif

  @if($errors->any())
  <div class="alert alert-danger">
    <ul style="margin:0;padding-left:20px;">
      @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  @yield('content')
</div>

<button id="theme-toggle" style="position:fixed;top:20px;right:20px;background:var(--card);border:1px solid var(--border);color:var(--text);padding:10px;border-radius:50%;width:45px;height:45px;display:flex;align-items:center;justify-content:center;z-index:9999;box-shadow:0 4px 12px rgba(0,0,0,0.15);cursor:pointer;font-size:18px;transition:all 0.2s;">
  ☀️
</button>

<script>
function openModal(id){document.getElementById(id).classList.add('open')}
function closeModal(id){document.getElementById(id).classList.remove('open')}

document.addEventListener('DOMContentLoaded', function() {
    const themeToggleBtn = document.getElementById('theme-toggle');
    const currentTheme = localStorage.getItem('theme');

    if (currentTheme === 'light' && themeToggleBtn) {
        themeToggleBtn.innerHTML = '🌙';
    }

    if(themeToggleBtn) {
        themeToggleBtn.addEventListener('click', function() {
            document.documentElement.classList.toggle('light-theme');
            let theme = 'dark';
            if (document.documentElement.classList.contains('light-theme')) {
                theme = 'light';
                themeToggleBtn.innerHTML = '🌙';
            } else {
                themeToggleBtn.innerHTML = '☀️';
            }
            localStorage.setItem('theme', theme);
        });
    }
});
</script>
@yield('scripts')
</body>
</html>
