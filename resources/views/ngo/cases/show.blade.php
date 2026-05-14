@extends('layouts.app')
@section('title', 'Case Details')
@section('content')
<div class="topbar">
  <div><div class="page-title" id="ngo-case-title">📁 Case {{ $case->case_number }}</div><div class="page-sub">Rescue operation details and progress</div></div>
  <div class="topbar-right">
    <button class="btn btn-success btn-sm" onclick="openModal('update-modal')">+ Add Progress Update</button>
    <button class="btn btn-primary btn-sm" onclick="openModal('add-child-modal')">+ Register Child</button>
    @if($case->child)
    <button class="btn btn-info btn-sm" onclick="openModal('story-modal')" style="background-color: var(--accent); color: white;">📖 Submit Story</button>
    @endif
  </div>
</div>

<div class="grid-2" style="margin-bottom:0">
  <div class="card" style="margin-bottom:16px">
    <div class="card-title">Case Information</div>
    <div class="detail-grid">
      <div class="detail-key">Case ID</div><div class="detail-val">{{ $case->case_number }}</div>
      <div class="detail-key">Status</div>
      <div class="detail-val">
        @php
          $badgeCls = match($case->status) {
            'pending' => 'badge-pending',
            'under_investigation' => 'badge-progress',
            'rescued' => 'badge-active',
            'rehabilitated' => 'badge-resolved',
            default => 'badge-pending'
          };
        @endphp
        <span class="badge {{ $badgeCls }}">{{ str_replace('_', ' ', ucfirst($case->status)) }}</span>
      </div>
      <div class="detail-key">Assigned NGO</div><div class="detail-val">{{ $case->ngo->name ?? '—' }}</div>
      <div class="detail-key">Created</div><div class="detail-val">{{ $case->created_at->format('d M Y') }}</div>
    </div>
  </div>
  <div class="card" style="margin-bottom:16px">
    <div class="card-title">Complaint Reference</div>
    <div class="detail-grid">
      <div class="detail-key">Tracking ID</div><div class="detail-val" style="font-family:monospace">{{ $case->complaint->tracking_id ?? 'N/A' }}</div>
      <div class="detail-key">Location</div><div class="detail-val">{{ $case->location }}</div>
      <div class="detail-key">Description</div><div class="detail-val" style="grid-column:span 1">{{ Str::limit($case->description, 100) }}</div>
    </div>
  </div>
</div>

<div class="card" style="margin-bottom:16px">
  <div class="sec-head">
    <div class="sec-title">Progress Log</div>
    <span style="font-size:12px;color:var(--text3)">{{ $case->updates->count() }} entries</span>
  </div>
  <div id="progress-log">
    @forelse($case->updates->sortByDesc('created_at') as $update)
    <div class="update-log">
      <div class="update-log-head">
        <span style="font-size:12px;font-weight:600;color:var(--accent)">{{ str_replace('_', ' ', ucfirst($update->status)) }}</span>
        <span class="update-log-date">{{ $update->created_at->format('d M Y, h:i A') }} (by {{ $update->updater->name ?? 'System' }})</span>
      </div>
      <p class="update-log-text" style="white-space:pre-wrap;">{{ $update->note }}</p>
    </div>
    @empty
    <p style="font-size:13px;color:var(--text3)">No progress updates yet. Add the first update above.</p>
    @endforelse
  </div>
</div>

<div class="card">
  <div class="sec-head"><div class="sec-title">Rescued Children</div></div>
  <div class="table-wrap" style="border:none">
    <table>
      <thead><tr><th>Name</th><th>Age</th><th>Gender</th><th>Condition</th><th>Registered On</th></tr></thead>
      <tbody>
        @if($case->child)
        @php $child = $case->child; @endphp
        <tr>
          <td class="td-primary">{{ $child->name }}</td>
          <td>{{ $child->age }} yrs</td>
          <td>{{ $child->gender }}</td>
          <td>
            @php
              $condCls = match($child->health_status) {
                'Good' => 'approved',
                'Critical' => 'rejected',
                default => 'active'
              };
            @endphp
            <span class="badge badge-{{ $condCls }}">{{ $child->health_status ?? 'Unknown' }}</span>
          </td>
          <td>{{ \Carbon\Carbon::parse($child->rescue_date)->format('d M Y') }}</td>
        </tr>
        @else
        <tr><td colspan="5" style="text-align:center;color:var(--text3);padding:24px">No children registered for this case yet.</td></tr>
        @endif
      </tbody>
    </table>
  </div>
</div>

<!-- Modals -->
<div class="modal-overlay" id="update-modal" onclick="if(event.target===this)closeModal('update-modal')">
  <div class="modal">
    <div class="modal-title"><span>📝 Add Progress Update</span><button class="modal-close" onclick="closeModal('update-modal')">✕</button></div>
    <form action="{{ route('ngo.cases.update', $case) }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="form-group">
        <label class="form-label">Update Case Status</label>
        <select class="form-input" name="status" required>
          <option value="under_investigation" {{ $case->status == 'under_investigation' ? 'selected' : '' }}>Under Investigation</option>
          <option value="rescued" {{ $case->status == 'rescued' ? 'selected' : '' }}>Rescued</option>
          <option value="rehabilitated" {{ $case->status == 'rehabilitated' ? 'selected' : '' }}>Rehabilitated</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Update Details *</label>
        <textarea class="form-input" name="note" placeholder="Describe what happened, steps taken, current status..." required></textarea>
      </div>
      <div class="form-group">
        <label class="form-label">Attach Document (Optional)</label>
        <input type="file" name="document" class="form-input" style="background:transparent;padding-left:0;">
      </div>
      <button type="submit" class="btn btn-success" style="width:100%">Save Update →</button>
    </form>
  </div>
</div>

<div class="modal-overlay" id="add-child-modal" onclick="if(event.target===this)closeModal('add-child-modal')">
  <div class="modal">
    <div class="modal-title"><span>👶 Register Rescued Child</span><button class="modal-close" onclick="closeModal('add-child-modal')">✕</button></div>
    <form action="{{ route('ngo.cases.add-child', $case) }}" method="POST" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="rescue_date" value="{{ date('Y-m-d') }}">
      <input type="hidden" name="rescue_city" value="{{ $case->city }}">
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Name (if known)</label>
          <input class="form-input" name="name" placeholder="Child's name or Unknown" required/>
        </div>
        <div class="form-group">
          <label class="form-label">Estimated Age</label>
          <input class="form-input" name="age" type="number" placeholder="e.g. 10" min="1" max="17" required/>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Gender</label>
          <select class="form-input" name="gender">
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Not Disclosed</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Condition on Rescue</label>
          <select class="form-input" name="health_status">
            <option value="Good">Good</option>
            <option value="Malnourished">Malnourished</option>
            <option value="Injured">Injured</option>
            <option value="Critical">Critical</option>
            <option value="Under Observation">Under Observation</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="form-label">Notes / Additional Info</label>
        <textarea class="form-input" name="notes" placeholder="Family info, medical needs..."></textarea>
      </div>
      <button type="submit" class="btn btn-primary" style="width:100%">Register Child →</button>
    </form>
  </div>
</div>

<div class="modal-overlay" id="story-modal" onclick="if(event.target===this)closeModal('story-modal')">
  <div class="modal">
    <div class="modal-title"><span>📖 Submit Story of Hope</span><button class="modal-close" onclick="closeModal('story-modal')">✕</button></div>
    <form action="{{ route('ngo.stories.store', $case) }}" method="POST">
      @csrf
      <p style="font-size: 13px; color: var(--text2); margin-bottom: 16px;">
        Share the journey of <strong>{{ $case->child->name ?? 'the child' }}</strong>. Your story will be reviewed by admins before being published on the public portal to inspire others.
      </p>
      <div class="form-group">
        <label class="form-label">Story Content (Min 20 characters)</label>
        <textarea class="form-input" name="content" placeholder="Describe the rescue, the child's courage, and their path to recovery..." rows="6" required minlength="20"></textarea>
      </div>
      <button type="submit" class="btn btn-info" style="width:100%; background-color: var(--accent); color: white;">Submit Story →</button>
    </form>
  </div>
</div>
@endsection
