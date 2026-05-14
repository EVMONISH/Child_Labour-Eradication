@extends('layouts.app')
@section('title', 'Login')
@section('content')
<div class="login-wrap">
  <div class="login-card">
    <div class="login-logo" style="font-size:32px">🛡</div>
    <div class="login-title">Staff Portal</div>
    <div class="login-sub">Login to access your dashboard</div>
    
    <div class="tab-row">
      <button type="button" class="tab-btn active" id="tab-admin" onclick="setDemo('admin@childlabour.org', 'password')">Admin</button>
      <button type="button" class="tab-btn" id="tab-ngo" onclick="setDemo('ngo@help.org', 'password')">NGO</button>
    </div>

    <form method="POST" action="{{ route('login.post') }}">
      @csrf
      <div class="form-group">
        <label class="form-label">Email Address</label>
        <input class="form-input" type="email" name="email" id="login-email" value="{{ old('email') }}" required placeholder="admin@childlabour.org" />
      </div>
      <div class="form-group">
        <label class="form-label">Password</label>
        <input class="form-input" type="password" name="password" id="login-pass" required placeholder="password" />
      </div>
      <button type="submit" class="btn btn-primary" style="width:100%;padding:11px">Login →</button>
      <p style="font-size:11px;color:var(--text3);margin-top:14px;text-align:center">Click the tabs above to autofill demo credentials.</p>
    </form>
  </div>
</div>

<script>
function setDemo(email, pass) {
    document.getElementById('login-email').value = email;
    document.getElementById('login-pass').value = pass;
    document.getElementById('tab-admin').classList.remove('active');
    document.getElementById('tab-ngo').classList.remove('active');
    if(email.includes('admin')) {
        document.getElementById('tab-admin').classList.add('active');
    } else {
        document.getElementById('tab-ngo').classList.add('active');
    }
}
</script>
@endsection
