@extends('layouts.app')
@section('title', 'NGO Dashboard')
@section('content')
<div class="topbar">
  <div><div class="page-title">🏢 NGO Dashboard</div><div class="page-sub" id="ngo-org-name">{{ $user->ngo->name ?? 'Your Organization' }} — Cases assigned to you</div></div>
  <div class="topbar-right">
      <button class="btn btn-primary" onclick="openModal('storyModal')">📖 Submit Story</button>
  </div>
</div>

<div class="grid-3" style="margin-bottom:24px">
  <div class="stat-card blue"><div class="stat-val">{{ $stats['total'] }}</div><div class="stat-label">Total Assigned Cases</div></div>
  <div class="stat-card warn"><div class="stat-val">{{ $stats['investigation'] }}</div><div class="stat-label">In Progress</div></div>
  <div class="stat-card green"><div class="stat-val">{{ $stats['rescued'] + $stats['rehabilitated'] }}</div><div class="stat-label">Resolved / Rescued</div></div>
</div>

<div class="card">
  <div class="sec-head"><div class="sec-title">My Assigned Cases</div></div>
  <div class="table-wrap" style="border:none">
    <table>
      <thead><tr><th>Case ID</th><th>Location</th><th>Last Update</th><th>Status</th><th>Action</th></tr></thead>
      <tbody>
        @forelse($cases as $c)
        <tr>
          <td class="td-primary">{{ $c->case_number }}</td>
          <td>{{ $c->location }}</td>
          <td>
            @if($c->updates->isNotEmpty())
              {{ $c->updates->first()->created_at->format('d M, h:i A') }}
            @else
              No updates
            @endif
          </td>
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
          <td><a href="{{ route('ngo.cases.show', $c) }}" class="btn btn-primary btn-sm">Open Case →</a></td>
        </tr>
        @empty
        <tr><td colspan="5" style="text-align:center;padding:24px;color:var(--text3)">No cases assigned to your NGO yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div style="margin-top:20px;">
    {{ $cases->links() }}
  </div>
</div>
</div>

<!-- Story Submission Modal -->
<div class="modal-overlay" id="storyModal">
  <div class="modal">
    <div class="modal-title">
      Submit a Story of Hope
      <button class="modal-close" onclick="closeModal('storyModal')">×</button>
    </div>
    
    @if($resolved_cases->isEmpty())
    <div class="alert alert-info" style="margin-bottom:0;">
        You don't have any rehabilitated cases to submit stories for yet.
    </div>
    @else
    <form action="" method="POST" id="storyForm">
      @csrf
      <div class="form-group">
        <label class="form-label">Select Rehabilitated Case</label>
        <select class="form-input" id="caseSelector" onchange="updateStoryFormAction(this)" required>
            <option value="">-- Select Case --</option>
            @foreach($resolved_cases as $rc)
                <option value="{{ $rc->id }}" data-action="{{ route('ngo.stories.store', $rc->id) }}">
                    {{ $rc->case_number }} - {{ $rc->child->name ?? 'Unknown Child' }}
                </option>
            @endforeach
        </select>
      </div>

      <div class="form-group">
        <label class="form-label">Story Description</label>
        <textarea name="content" class="form-input" placeholder="Share the inspiring journey of rescue and rehabilitation..." required></textarea>
        <div style="font-size:11px; color:var(--text3); margin-top:4px;">Minimum 20 characters. Stories will be reviewed by admins before publishing.</div>
      </div>
      
      <div style="text-align:right">
        <button type="submit" class="btn btn-success">Submit for Review</button>
      </div>
    </form>
    @endif
  </div>
</div>

<script>
function updateStoryFormAction(selectElement) {
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    const form = document.getElementById('storyForm');
    if (selectedOption.value) {
        form.action = selectedOption.getAttribute('data-action');
    } else {
        form.action = '';
    }
}
</script>
@endsection
