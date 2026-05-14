@extends('layouts.app')
@section('title', 'Complaint Detail')
@section('content')
<div class="topbar">
  <div>
    <div class="page-title">📋 Complaint Detail</div>
    <div class="page-sub">Review details for {{ $complaint->tracking_id }}</div>
  </div>
  <div class="topbar-right">
    <a href="{{ route('admin.complaints.index') }}" class="btn btn-ghost">← Back</a>
  </div>
</div>

<div class="card" style="max-width: 800px;">
  <div class="detail-grid">
    <div class="detail-key">Tracking ID</div><div class="detail-val" style="font-family:monospace">{{ $complaint->tracking_id }}</div>
    <div class="detail-key">Reporter</div><div class="detail-val">{{ $complaint->reporter_name ?: 'Anonymous' }}</div>
    <div class="detail-key">Contact</div><div class="detail-val">{{ $complaint->reporter_phone ?: '—' }}</div>
    <div class="detail-key">Location</div><div class="detail-val">{{ $complaint->location }}</div>
    <div class="detail-key">Date Filed</div><div class="detail-val">{{ $complaint->created_at->format('d M Y, h:i A') }}</div>
    <div class="detail-key">Status</div>
    <div class="detail-val">
      @php
        $badgeCls = match($complaint->status) {
          'pending' => 'badge-pending',
          'approved' => 'badge-active',
          'rejected' => 'badge-rejected',
          default => 'badge-pending'
        };
      @endphp
      <span class="badge {{ $badgeCls }}">{{ ucfirst($complaint->status) }}</span>
    </div>
  </div>
  <div class="divider"></div>
  <div style="font-size:12px;color:var(--text3);margin-bottom:6px;font-weight:600">DESCRIPTION</div>
  <p style="font-size:13px;color:var(--text2);line-height:1.6;white-space:pre-wrap;">{{ $complaint->description }}</p>

  @if($complaint->status == 'pending')
  <div class="divider"></div>
  <div style="display:flex;gap:10px;margin-top:20px">
    <form action="{{ route('admin.complaints.approve', $complaint) }}" method="POST">
      @csrf
      <button class="btn btn-success">✓ Approve & Create Case</button>
    </form>
    <form action="{{ route('admin.complaints.reject', $complaint) }}" method="POST">
      @csrf
      <button class="btn btn-danger">✗ Reject</button>
    </form>
  </div>
  @else
  <div class="divider"></div>
  <span style="font-size:13px;color:var(--text3)">This complaint has been <strong>{{ $complaint->status }}</strong>.</span>
  @endif
</div>
@endsection
