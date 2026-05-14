@extends('layouts.app')

@section('content')
<div class="topbar">
    <div>
        <h1 class="page-title">Stories Approval</h1>
        <p class="page-sub">Review and approve success stories submitted by NGOs</p>
    </div>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Case & Child</th>
                    <th>NGO</th>
                    <th>Story Preview</th>
                    <th>Status</th>
                    <th>Submitted</th>
                    <th style="text-align:right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stories as $story)
                <tr>
                    <td>
                        <div class="td-primary">{{ $story->child->name ?? 'Unknown' }} ({{ $story->child->age ?? '?' }} yrs)</div>
                        <div style="font-size:11px;color:var(--text3);margin-top:4px;">{{ $story->case->case_number }}</div>
                    </td>
                    <td>{{ $story->ngo->name }}</td>
                    <td>
                        <div style="max-width:300px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" title="{{ $story->content }}">
                            {{ $story->content }}
                        </div>
                    </td>
                    <td>
                        @if($story->status === 'approved')
                            <span class="badge badge-approved">Approved</span>
                        @elseif($story->status === 'rejected')
                            <span class="badge badge-rejected">Rejected</span>
                        @else
                            <span class="badge badge-pending">Pending</span>
                        @endif
                    </td>
                    <td>{{ $story->created_at->format('M d, Y') }}</td>
                    <td style="text-align:right">
                        @if($story->status === 'pending')
                        <div style="display:flex;gap:8px;justify-content:flex-end;">
                            <form action="{{ route('admin.stories.approve', $story) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Approve</button>
                            </form>
                            <form action="{{ route('admin.stories.reject', $story) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                            </form>
                        </div>
                        @else
                            <span style="font-size:12px;color:var(--text3);">Action Taken</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:30px;">No stories found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:20px;">
        {{ $stories->links() }}
    </div>
</div>
@endsection
