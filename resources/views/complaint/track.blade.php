@extends('layouts.app')
@section('title', 'Track Complaint')
@section('content')
<div class="topbar">
  <div><div class="page-title">🔍 Track Complaint Status</div><div class="page-sub">Enter your tracking ID to see the current status</div></div>
</div>

<div class="track-box">
  <form method="GET" action="{{ route('complaint.track') }}" class="form-group">
    <label class="form-label">Tracking ID</label>
    <div style="display:flex;gap:10px">
      <input class="form-input" name="tracking_id" value="{{ request('tracking_id') }}" placeholder="e.g. CL-2024-0042" style="flex:1" required/>
      <button type="submit" class="btn btn-primary">Track →</button>
    </div>
  </form>

  @if(request()->has('tracking_id'))
    @if($complaint)
      @php
        $badgeCls = match($complaint->status) {
          'pending' => 'badge-pending',
          'approved' => 'badge-active',
          'rejected' => 'badge-rejected',
          'resolved' => 'badge-resolved',
          default => 'badge-pending'
        };
        // Simulated steps for demonstration based on status
        $steps = [
          ['label' => 'Complaint Submitted', 'meta' => $complaint->created_at->format('d M Y, h:i A'), 'done' => true, 'active' => false],
          ['label' => 'Under Review', 'meta' => $complaint->status == 'pending' ? 'Pending admin review' : 'Completed', 'done' => $complaint->status != 'pending', 'active' => $complaint->status == 'pending'],
          ['label' => 'Case Created', 'meta' => $complaint->status == 'approved' ? 'Active Case' : 'Not yet', 'done' => $complaint->case_id != null, 'active' => false],
          ['label' => 'NGO Assigned', 'meta' => $complaint->childCase && $complaint->childCase->assigned_ngo_id ? 'Assigned' : 'Not yet', 'done' => $complaint->childCase && $complaint->childCase->assigned_ngo_id != null, 'active' => false],
          ['label' => 'Rescue Completed', 'meta' => 'Not yet', 'done' => false, 'active' => false]
        ];
      @endphp
      <div id="track-result" style="display:block">
        <div class="track-result">
          <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px">
            <div>
              <div class="track-id">{{ $complaint->tracking_id }}</div>
              <div style="font-size:12px;color:var(--text3);margin-top:4px">{{ $complaint->location }}</div>
            </div>
            <span class="badge {{ $badgeCls }}">{{ strtoupper($complaint->status) }}</span>
          </div>
          <div class="status-timeline">
            @foreach($steps as $step)
              <div class="timeline-item">
                <div class="timeline-dot {{ $step['done'] ? 'done' : ($step['active'] ? 'active' : '') }}"></div>
                <div class="timeline-label">{{ $step['label'] }}</div>
                <div class="timeline-meta">{{ $step['meta'] }}</div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    @else
      <div id="track-result" style="display:block">
        <div class="alert alert-warn">⚠️ No complaint found with this tracking ID. Please check and try again.</div>
      </div>
    @endif
  @endif
</div>
@endsection
