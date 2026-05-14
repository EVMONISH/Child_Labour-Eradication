@extends('layouts.app')
@section('title', 'Case Details')
@section('content')
<div class="topbar">
  <div><div class="page-title">📁 Case {{ $case->case_number }}</div><div class="page-sub">Rescue operation details and progress</div></div>
  <div class="topbar-right">
    @if(!$case->assigned_ngo_id)
      <button class="btn btn-primary btn-sm" onclick="openAssignModal('{{ $case->id }}', '{{ $case->case_number }}')">Assign NGO</button>
    @else
      <button class="btn btn-ghost btn-sm" onclick="openAssignModal('{{ $case->id }}', '{{ $case->case_number }}')">Reassign</button>
    @endif
    <button class="btn btn-success btn-sm" onclick="openModal('update-modal')">+ Update Status</button>
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
      <div class="detail-key">Tracking ID</div><div class="detail-val" style="font-family:monospace">
        @if($case->complaint)
        <a href="{{ route('admin.complaints.show', $case->complaint) }}" style="color:var(--accent)">{{ $case->complaint->tracking_id }}</a>
        @else
        N/A
        @endif
      </div>
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
    <p style="font-size:13px;color:var(--text3)">No progress updates yet.</p>
    @endforelse
  </div>
</div>

<div class="card">
  <div class="sec-head">
    <div class="sec-title">Rescued Children</div>
    <button class="btn btn-primary btn-sm" onclick="openModal('add-child-modal')">+ Register Child</button>
  </div>
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
    <div class="modal-title"><span>📝 Admin: Update Status</span><button class="modal-close" onclick="closeModal('update-modal')">✕</button></div>
    <form action="{{ route('admin.cases.update-status', $case) }}" method="POST">
      @csrf
      <div class="form-group">
        <label class="form-label">Update Case Status</label>
        <select class="form-input" name="status" required>
          <option value="pending" {{ $case->status == 'pending' ? 'selected' : '' }}>Pending</option>
          <option value="under_investigation" {{ $case->status == 'under_investigation' ? 'selected' : '' }}>Under Investigation</option>
          <option value="rescued" {{ $case->status == 'rescued' ? 'selected' : '' }}>Rescued</option>
          <option value="rehabilitated" {{ $case->status == 'rehabilitated' ? 'selected' : '' }}>Rehabilitated</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Update Note *</label>
        <textarea class="form-input" name="note" placeholder="Admin note..." required></textarea>
      </div>
      <button type="submit" class="btn btn-success" style="width:100%">Save Update →</button>
    </form>
  </div>
</div>

<div class="modal-overlay" id="assign-modal" onclick="if(event.target===this)closeModal('assign-modal')">
  <div class="modal">
    <div class="modal-title"><span>🤝 Assign NGO to Case <span id="modal-case-id" style="font-family:monospace;font-size:14px;color:var(--text3)">{{ $case->case_number }}</span></span><button type="button" class="modal-close" onclick="closeModal('assign-modal')">✕</button></div>
    <form id="assign-form" method="POST" action="{{ route('admin.cases.assign-ngo', $case) }}">
      @csrf
      <div class="form-group">
        <label class="form-label">Select NGO</label>
        <select class="form-input" name="ngo_id" required>
          <option value="">Choose an NGO...</option>
          @foreach($ngos as $ngo)
          <option value="{{ $ngo->id }}" {{ $case->assigned_ngo_id == $ngo->id ? 'selected' : '' }}>{{ $ngo->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Assignment Type</label>
        <select class="form-input" name="assigned_to_type" required>
          <option value="ngo">NGO Only</option>
          <option value="police">Police Coordination Required</option>
          <option value="both">Joint Operation (NGO + Police)</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary" style="width:100%;margin-top:10px;">Assign NGO →</button>
    </form>
  </div>
</div>

<div class="modal-overlay" id="add-child-modal" onclick="if(event.target===this)closeModal('add-child-modal')">
  <div class="modal">
    <div class="modal-title"><span>👶 Register Rescued Child</span><button class="modal-close" onclick="closeModal('add-child-modal')">✕</button></div>
    <form action="{{ route('admin.children.store', $case) }}" method="POST" enctype="multipart/form-data">
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
@endsection
@section('scripts')
<script>
function openAssignModal(id, caseNumber) {
    document.getElementById('modal-case-id').innerText = caseNumber;
    openModal('assign-modal');
}
</script>
@endsection
