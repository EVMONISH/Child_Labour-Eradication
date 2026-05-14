@extends('layouts.app')

@section('content')
<div class="topbar">
    <div>
        <h1 class="page-title">Stories of Hope</h1>
        <p class="page-sub">Real journeys from rescue to recovery</p>
    </div>
</div>

<div class="grid-4">
    <div class="stat-card blue">
        <div class="stat-val">{{ $stats['total_rescued'] }}</div>
        <div class="stat-label">Total Children Rescued</div>
    </div>
    <div class="stat-card green">
        <div class="stat-val">{{ $stats['in_school'] }}</div>
        <div class="stat-label">Now In School</div>
    </div>
    <div class="stat-card warn">
        <div class="stat-val">{{ $stats['reunited'] }}</div>
        <div class="stat-label">Reunited with Family</div>
    </div>
    <div class="stat-card blue">
        <div class="stat-val">{{ $stats['stories_pub'] }}</div>
        <div class="stat-label">Total Stories Published</div>
    </div>
</div>

@if($stories->count() > 0)
<div class="grid-3">
    @foreach($stories as $story)
    <div class="card" style="display:flex;flex-direction:column;justify-content:space-between;">
        <div>
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
                <span class="badge badge-resolved">{{ $story->case->getStatusLabelAttribute() }}</span>
                <span style="font-size:11px;color:var(--text3);">Rescue Date: {{ $story->child->rescue_date ? $story->child->rescue_date->format('M d, Y') : 'Unknown' }}</span>
            </div>
            <h3 class="card-title" style="margin-bottom:4px;">{{ $story->child->name }}, {{ $story->child->age }} yrs</h3>
            <p style="font-size:12px;color:var(--text3);margin-bottom:16px;">📍 {{ $story->child->rescue_city ?? $story->case->city }} | {{ $story->case->case_number }}</p>
            <p style="font-size:13px;color:var(--text2);line-height:1.6;font-style:italic;">
                "{!! nl2br(e($story->content)) !!}"
            </p>
        </div>
        <div style="margin-top:20px;border-top:1px solid var(--border);padding-top:12px;font-size:11px;color:var(--text3);">
            Shared by {{ $story->ngo->name }}
        </div>
    </div>
    @endforeach
</div>
@else
<div class="card" style="text-align:center;padding:40px;">
    <p style="font-size:15px;color:var(--text3);">No stories have been published yet. Check back soon for inspiring journeys of recovery.</p>
</div>
@endif

@endsection
