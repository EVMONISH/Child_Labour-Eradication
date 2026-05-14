@extends('layouts.app')
@section('title', 'Case Management')
@section('content')
<div class="topbar">
  <div><div class="page-title">📁 Case Management</div><div class="page-sub">Manage active rescue operations</div></div>
</div>

<div class="table-wrap">
  <table>
    <thead><tr><th>Case ID</th><th>Complaint Ref</th><th>Location</th><th>Assigned NGO</th><th>Status</th><th>Created</th><th>Action</th></tr></thead>
    <tbody>
      @forelse($cases as $c)
      <tr>
        <td class="td-primary">{{ $c->case_number }}</td>
        <td style="font-family:monospace;font-size:12px">{{ $c->complaint->tracking_id ?? 'N/A' }}</td>
        <td>{{ $c->location }}</td>
        <td>{!! $c->ngo ? $c->ngo->name : '<span class="tag">Unassigned</span>' !!}</td>
        <td>
          @php
            $badgeCls = match($c->status) {
              'pending' => 'badge-pending',
              'under_investigation' => 'badge-progress',
              'rescued' => 'badge-active',
              'rehabilitated' => 'badge-resolved',
              default => 'badge-pending'
            };
          @endphp
          <span class="badge {{ $badgeCls }}">{{ str_replace('_', ' ', ucfirst($c->status)) }}</span>
        </td>
        <td>{{ $c->created_at->format('d M Y') }}</td>
        <td>
          <div style="display:flex;gap:6px">
            @if(!$c->assigned_ngo_id)
            <button class="btn btn-primary btn-sm" onclick="openAssignModal('{{ $c->id }}', '{{ $c->case_number }}')">Assign NGO</button>
            @else
            <button class="btn btn-ghost btn-sm" onclick="openAssignModal('{{ $c->id }}', '{{ $c->case_number }}')">Reassign</button>
            @endif
            <a href="{{ route('admin.cases.show', $c) }}" class="btn btn-ghost btn-sm">View</a>
          </div>
        </td>
      </tr>
      @empty
      <tr><td colspan="7" style="text-align:center;padding:24px;color:var(--text3)">No cases found.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
<div style="margin-top:20px;">
  {{ $cases->links() }}
</div>

<!-- Assign Modal -->
<div class="modal-overlay" id="assign-modal" onclick="if(event.target===this)closeModal('assign-modal')">
  <div class="modal">
    <div class="modal-title"><span>🤝 Assign NGO to Case <span id="modal-case-id" style="font-family:monospace;font-size:14px;color:var(--text3)"></span></span><button type="button" class="modal-close" onclick="closeModal('assign-modal')">✕</button></div>
    <form id="assign-form" method="POST" action="">
      @csrf
      <div class="form-group">
        <label class="form-label">Select NGO</label>
        <select class="form-input" name="ngo_id" required>
          <option value="">Choose an NGO...</option>
          @foreach($ngos as $ngo)
          <option value="{{ $ngo->id }}">{{ $ngo->name }}</option>
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

@endsection
@section('scripts')
<script>
function openAssignModal(id, caseNumber) {
    document.getElementById('modal-case-id').innerText = caseNumber;
    let form = document.getElementById('assign-form');
    let url = '{{ route("admin.cases.assign-ngo", ":id") }}'.replace(':id', id);
    form.action = url;
    openModal('assign-modal');
}
</script>
@endsection
