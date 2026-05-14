@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('content')
<div class="topbar">
  <div><div class="page-title">📊 Admin Dashboard</div><div class="page-sub">System overview — as of today</div></div>
  <div class="topbar-right"><span class="text-muted" style="font-size:13px;">Welcome, Administrator</span></div>
</div>

<div class="grid-4">
  <div class="stat-card blue"><div class="stat-val">{{ $stats['total_complaints'] }}</div><div class="stat-label">Total Complaints</div></div>
  <div class="stat-card warn"><div class="stat-val">{{ $stats['pending_complaints'] }}</div><div class="stat-label">Pending Review</div></div>
  <div class="stat-card green"><div class="stat-val">{{ $stats['total_cases'] }}</div><div class="stat-label">Active Cases</div></div>
  <div class="stat-card red"><div class="stat-val">{{ $stats['total_children'] }}</div><div class="stat-label">Children in Registry</div></div>
</div>

<div class="grid-2">
  <div class="card">
    <div class="card-title">Cases by Status</div>
    <div style="display:flex;flex-direction:column;gap:10px;margin-top:4px">
      @php
        $totalCases = max(1, $stats['total_cases']);
        $pendingPct = round(($stats['pending_cases'] / $totalCases) * 100);
        $investPct = round(($stats['investigation'] / $totalCases) * 100);
        $rescuedPct = round(($stats['rescued'] / $totalCases) * 100);
        $rehabPct = round(($stats['rehabilitated'] / $totalCases) * 100);
      @endphp
      <div style="display:flex;align-items:center;gap:10px">
        <div style="flex:1;height:8px;background:var(--bg3);border-radius:4px;overflow:hidden"><div style="width:{{ $pendingPct }}%;height:100%;background:var(--warn)"></div></div>
        <span style="font-size:12px;color:var(--text2);min-width:80px">Pending {{ $pendingPct }}%</span>
      </div>
      <div style="display:flex;align-items:center;gap:10px">
        <div style="flex:1;height:8px;background:var(--bg3);border-radius:4px;overflow:hidden"><div style="width:{{ $investPct }}%;height:100%;background:var(--accent)"></div></div>
        <span style="font-size:12px;color:var(--text2);min-width:80px">Investigation {{ $investPct }}%</span>
      </div>
      <div style="display:flex;align-items:center;gap:10px">
        <div style="flex:1;height:8px;background:var(--bg3);border-radius:4px;overflow:hidden"><div style="width:{{ $rescuedPct }}%;height:100%;background:var(--accent2)"></div></div>
        <span style="font-size:12px;color:var(--text2);min-width:80px">Rescued {{ $rescuedPct }}%</span>
      </div>
      <div style="display:flex;align-items:center;gap:10px">
        <div style="flex:1;height:8px;background:var(--bg3);border-radius:4px;overflow:hidden"><div style="width:{{ $rehabPct }}%;height:100%;background:var(--danger)"></div></div>
        <span style="font-size:12px;color:var(--text2);min-width:80px">Rehabilitated {{ $rehabPct }}%</span>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-title">NGO Partners</div>
    <div style="font-family:var(--sora);font-size:38px;font-weight:700;color:var(--accent2)">{{ $stats['total_ngos'] }}</div>
    <div style="font-size:12px;color:var(--text3);margin-top:4px">Registered Organizations ready to respond</div>
  </div>
</div>

<div class="card">
  <div class="sec-head">
    <div class="sec-title">Recent Complaints</div>
    <a href="{{ route('admin.complaints.index') }}" class="btn btn-ghost btn-sm">View All →</a>
  </div>
  <div class="table-wrap">
    <table>
      <thead><tr><th>ID</th><th>Location</th><th>Date</th><th>Status</th><th>Action</th></tr></thead>
      <tbody>
        @foreach($recentComplaints as $c)
        <tr>
          <td class="td-primary">{{ $c->tracking_id }}</td>
          <td>{{ $c->location }}</td>
          <td>{{ $c->created_at->format('d M Y') }}</td>
          <td><span class="badge badge-{{ $c->status == 'pending' ? 'pending' : ($c->status == 'approved' ? 'active' : 'rejected') }}">{{ ucfirst($c->status) }}</span></td>
          <td><a href="{{ route('admin.complaints.show', $c) }}" class="btn btn-ghost btn-sm">View</a></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
