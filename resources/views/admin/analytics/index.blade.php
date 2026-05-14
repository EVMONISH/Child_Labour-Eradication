@extends('layouts.app')
@section('title', 'Analytics & Trends')
@section('content')
<div class="topbar">
  <div><div class="page-title">📈 Analytics & Trends</div><div class="page-sub">System-wide insights and reporting</div></div>
</div>

<div class="grid-4" style="margin-bottom:24px">
  <div class="stat-card blue"><div class="stat-val">{{ date('Y') }}</div><div class="stat-label">Current Year</div></div>
  <div class="stat-card green"><div class="stat-val">{{ $totalChildren > 0 ? round(($enrolledChildren / $totalChildren) * 100) : 0 }}%</div><div class="stat-label">Rehabilitation Rate</div></div>
  <div class="stat-card warn"><div class="stat-val">{{ $totalChildren }}</div><div class="stat-label">Total Children Profiled</div></div>
  <div class="stat-card red"><div class="stat-val">{{ count($topCities) }}</div><div class="stat-label">Active Cities</div></div>
</div>

<div class="grid-2">
  <div class="card">
    <div class="card-title">Monthly Complaint Volume (Last 12 Months)</div>
    @php
      $maxVol = 1;
      foreach($monthlyComplaints as $mc) {
          if($mc->total > $maxVol) $maxVol = $mc->total;
      }
    @endphp
    <div class="chart-bars" style="height:140px">
      @forelse($monthlyComplaints as $mc)
        <div class="chart-bar" style="height:{{ max(($mc->total / $maxVol) * 100, 5) }}%;background:rgba(59,130,246,.5)">
          <div class="chart-bar-label">{{ \Carbon\Carbon::parse($mc->month)->format('M') }}</div>
        </div>
      @empty
        <div style="font-size:13px;color:var(--text3);text-align:center;width:100%;margin-top:50px;">Not enough data yet.</div>
      @endforelse
    </div>
    <div style="height:24px"></div>
  </div>
  <div class="card">
    <div class="card-title">Children Age Breakdown</div>
    <div style="display:flex;flex-direction:column;gap:8px;margin-top:4px">
      @php
        $colors = ['#3b82f6', '#10b981', '#f59e0b', '#ef4444'];
        $i = 0;
      @endphp
      @foreach($ageGroups as $range => $count)
        <div style="display:flex;align-items:center;gap:10px">
          <div style="width:12px;height:12px;border-radius:2px;background:{{ $colors[$i % 4] }}"></div>
          <span style="flex:1;font-size:13px;color:var(--text2)">Ages {{ $range }}</span>
          <span style="font-size:13px;font-weight:600">{{ $count }}</span>
        </div>
        @php $i++; @endphp
      @endforeach
    </div>
  </div>
</div>

<div class="card">
  <div class="card-title">Top Cities by Case Volume</div>
  <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:12px">
    @forelse($topCities as $city)
    <div style="text-align:center">
      <div style="font-family:var(--sora);font-size:22px;font-weight:700;color:var(--accent)">{{ $city->total }}</div>
      <div style="font-size:12px;color:var(--text3)">{{ $city->city ?: 'Unknown' }}</div>
    </div>
    @empty
    <div style="grid-column:span 5;text-align:center;color:var(--text3);font-size:13px;">No city data available yet.</div>
    @endforelse
  </div>
</div>
@endsection
