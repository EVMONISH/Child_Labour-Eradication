@extends('layouts.admin')
@section('title','Add Child Record')
@section('page-title','Add Child Record')
@section('content')
<div class="row g-4" style="max-width:800px">
    <div class="col-12">
        <div class="card">
            <div class="card-header fw-semibold"><i class="bi bi-person-plus-fill me-2 text-success"></i>Child Details for Case {{ $case->case_number }}</div>
            <div class="card-body">
                @if($errors->any())
                <div class="alert alert-danger"><i class="bi bi-exclamation-circle me-2"></i>{{ $errors->first() }}</div>
                @endif
                <form action="{{ route('admin.children.store', $case) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Full Name *</label><input type="text" name="name" class="form-control" required></div>
                        <div class="col-md-3"><label class="form-label">Age *</label><input type="number" name="age" class="form-control" min="1" max="17" required></div>
                        <div class="col-md-3"><label class="form-label">Gender *</label>
                            <select name="gender" class="form-select" required>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-6"><label class="form-label">Rescue Location</label><input type="text" name="rescue_location" class="form-control" value="{{ $case->location }}"></div>
                        <div class="col-md-3"><label class="form-label">Rescue City *</label><input type="text" name="rescue_city" class="form-control" value="{{ $case->city }}" required></div>
                        <div class="col-md-3"><label class="form-label">Rescue Date *</label><input type="date" name="rescue_date" class="form-control" value="{{ date('Y-m-d') }}" required></div>
                        <div class="col-md-6"><label class="form-label">School Name</label><input type="text" name="school_name" class="form-control" placeholder="School name if enrolled"></div>
                        <div class="col-md-6 d-flex align-items-end">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="school_enrolled" id="school_enrolled" value="1">
                                <label class="form-check-label" for="school_enrolled">School Enrolled</label>
                            </div>
                        </div>
                        <div class="col-md-4"><label class="form-label">Guardian Name</label><input type="text" name="guardian_name" class="form-control"></div>
                        <div class="col-md-4"><label class="form-label">Guardian Phone</label><input type="text" name="guardian_phone" class="form-control"></div>
                        <div class="col-md-4"><label class="form-label">Guardian Relation</label><input type="text" name="guardian_relation" class="form-control" placeholder="Parent, Uncle, etc."></div>
                        <div class="col-md-6"><label class="form-label">Health Status</label><textarea name="health_status" class="form-control" rows="2" placeholder="Physical/mental health notes"></textarea></div>
                        <div class="col-md-6"><label class="form-label">Additional Notes</label><textarea name="notes" class="form-control" rows="2"></textarea></div>
                        <div class="col-12"><label class="form-label">Child Photo (Optional)</label><input type="file" name="photo" class="form-control" accept="image/*"></div>
                        <div class="col-12 mt-2">
                            <button type="submit" class="btn btn-success fw-bold px-5"><i class="bi bi-check-circle-fill me-2"></i>Save Child Record</button>
                            <a href="{{ route('admin.cases.show', $case) }}" class="btn btn-outline-secondary ms-2">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
