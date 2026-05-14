@extends('layouts.app')
@section('title', 'Complaints Management')
@section('content')
<div class="topbar">
  <div><div class="page-title">📋 Complaints Management</div><div class="page-sub">Review and process incoming complaints</div></div>
  <div class="topbar-right">
    <form method="GET" action="{{ route('admin.complaints.index') }}" style="display:flex;gap:10px;">
      <select class="form-input" name="status" onchange="this.form.submit()" style="width:160px;padding:8px 12px">
        <option value="">All Status</option>
        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
      </select>
    </form>
  </div>
</div>

<div class="table-wrap">
  <table>
    <thead><tr><th>Tracking ID</th><th>Reporter</th><th>Location</th><th>Submitted</th><th>Status</th><th>Action</th></tr></thead>
    <tbody>
      @forelse($complaints as $c)
      <tr>
        <td class="td-primary" style="font-family:monospace">{{ $c->tracking_id }}</td>
        <td>{{ $c->reporter_name ?: 'Anonymous' }}</td>
        <td>{{ $c->location }}</td>
        <td>{{ $c->created_at->format('d M Y') }}</td>
        <td>
          @php
            $badgeCls = match($c->status) {
              'pending' => 'badge-pending',
              'approved' => 'badge-active',
              'rejected' => 'badge-rejected',
              default => 'badge-pending'
            };
          @endphp
          <span class="badge {{ $badgeCls }}">{{ ucfirst($c->status) }}</span>
        </td>
        <td>
          <div style="display:flex;gap:6px">
            <a href="{{ route('admin.complaints.show', $c) }}" class="btn btn-ghost btn-sm">View</a>
            @if($c->status == 'pending')
            <form action="{{ route('admin.complaints.approve', $c) }}" method="POST" style="display:inline">
              @csrf
              <button class="btn btn-success btn-sm">✓</button>
            </form>
            <form action="{{ route('admin.complaints.reject', $c) }}" method="POST" style="display:inline">
              @csrf
              <button class="btn btn-danger btn-sm">✗</button>
            </form>
            @endif
          </div>
        </td>
      </tr>
      @empty
      <tr><td colspan="6" style="text-align:center;color:var(--text3);padding:24px;">No complaints found.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
<div style="margin-top:20px;">
  {{ $complaints->links() }}
</div>
@endsection
