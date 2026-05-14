@extends('layouts.app')
@section('title', 'Children Registry')
@section('content')
<div class="topbar">
  <div><div class="page-title">👶 Children Registry</div><div class="page-sub">Database of rescued children</div></div>
</div>

<div class="table-wrap">
  <table>
    <thead><tr><th>ID</th><th>Name</th><th>Age</th><th>Gender</th><th>Rescue Location</th><th>Case Ref</th><th>Condition</th><th>Status</th></tr></thead>
    <tbody>
      @forelse($children as $c)
      <tr>
        <td class="td-primary" style="font-family:monospace;font-size:12px">CH-{{ str_pad($c->id, 3, '0', STR_PAD_LEFT) }}</td>
        <td class="td-primary">{{ $c->name }}</td>
        <td>{{ $c->age }} yrs</td>
        <td>{{ $c->gender }}</td>
        <td>{{ $c->rescue_city }}</td>
        <td style="font-family:monospace;font-size:12px">{{ $c->case->case_number ?? 'N/A' }}</td>
        <td>
          @php
            $condCls = match($c->health_status) {
              'Good' => 'approved',
              'Critical' => 'rejected',
              default => 'active'
            };
          @endphp
          <span class="badge badge-{{ $condCls }}">{{ $c->health_status ?? 'Unknown' }}</span>
        </td>
        <td>
          <span class="badge {{ $c->school_enrolled ? 'badge-resolved' : 'badge-active' }}">
            {{ $c->school_enrolled ? 'Rehabilitated' : 'In Shelter' }}
          </span>
        </td>
      </tr>
      @empty
      <tr><td colspan="8" style="text-align:center;padding:24px;color:var(--text3)">No children registered yet.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
<div style="margin-top:20px;">
  {{ $children->links() }}
</div>
@endsection
