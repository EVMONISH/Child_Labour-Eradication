@extends('layouts.app')
@section('title', 'Report Submitted')
@section('content')
<div class="topbar">
  <div><div class="page-title">📝 Report Child Labour Incident</div><div class="page-sub">Your report will be reviewed within 48 hours</div></div>
</div>

<div style="max-width:680px">
  <div class="alert alert-success">✅ Complaint submitted successfully! Save your tracking ID to check the status later.</div>
  <div class="card">
    <div class="card-title">Your Tracking ID</div>
    <div class="track-id">{{ $complaint->tracking_id }}</div>
    <p style="font-size:13px;color:var(--text3);margin-top:8px">Take note of this ID. Use it on the Track Complaint page to check your complaint status.</p>
    <div style="margin-top:16px;display:flex;gap:10px">
      <a href="{{ route('complaint.track', ['tracking_id' => $complaint->tracking_id]) }}" class="btn btn-ghost btn-sm">🔍 Track This Complaint</a>
      <a href="{{ route('complaint.create') }}" class="btn btn-ghost btn-sm">📝 File Another Report</a>
    </div>
  </div>
</div>
@endsection
