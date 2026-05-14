@extends('layouts.admin')
@section('title','Child Profile')
@section('page-title','Child Profile')
@section('content')
<div class="row g-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header fw-semibold"><i class="bi bi-person-fill me-2 text-success"></i>Child Details</div>
            <div class="card-body">
                @if($child->photo_path)
                <img src="{{ asset('storage/'.$child->photo_path) }}" class="rounded-3 mb-4" style="max-width:200px">
                @endif
                <div class="row g-3">
                    <div class="col-6"><div class="small text-muted">Full Name</div><div class="fw-bold fs-5">{{ $child->name }}</div></div>
                    <div class="col-6"><div class="small text-muted">Age</div><div>{{ $child->age }} years</div></div>
                    <div class="col-6"><div class="small text-muted">Gender</div><div>{{ ucfirst($child->gender) }}</div></div>
                    <div class="col-6"><div class="small text-muted">Rescue Date</div><div>{{ $child->rescue_date->format('d M Y') }}</div></div>
                    <div class="col-12"><div class="small text-muted">Rescue Location</div><div>{{ $child->rescue_location }}, {{ $child->rescue_city }}</div></div>
                    <div class="col-12"><div class="small text-muted">Health Status</div><div>{{ $child->health_status ?: '—' }}</div></div>
                    <div class="col-12"><div class="small text-muted">Notes</div><div>{{ $child->notes ?: '—' }}</div></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card mb-4">
            <div class="card-header fw-semibold"><i class="bi bi-mortarboard-fill me-2 text-warning"></i>Education</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12">
                        @if($child->school_enrolled)
                        <span class="badge badge-rehabilitated fs-6 mb-2">✅ School Enrolled</span>
                        <div class="fw-semibold">{{ $child->school_name }}</div>
                        @else
                        <span class="badge badge-rejected fs-6">Not Enrolled Yet</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header fw-semibold"><i class="bi bi-house-heart me-2" style="color:#a78bfa"></i>Guardian Info</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-6"><div class="small text-muted">Name</div><div>{{ $child->guardian_name ?: '—' }}</div></div>
                    <div class="col-6"><div class="small text-muted">Relation</div><div>{{ $child->guardian_relation ?: '—' }}</div></div>
                    <div class="col-12"><div class="small text-muted">Phone</div><div>{{ $child->guardian_phone ?: '—' }}</div></div>
                </div>
            </div>
        </div>
        @if($child->case)
        <div class="card">
            <div class="card-header fw-semibold"><i class="bi bi-folder2-open me-2"></i>Linked Case</div>
            <div class="card-body">
                <a href="{{ route('admin.cases.show', $child->case) }}" class="btn btn-primary w-100"><i class="bi bi-arrow-right-circle me-2"></i>View Case {{ $child->case->case_number }}</a>
            </div>
        </div>
        @endif
    </div>
</div>
<a href="{{ route('admin.children.index') }}" class="btn btn-outline-secondary mt-3"><i class="bi bi-arrow-left me-2"></i>Back</a>
@endsection
