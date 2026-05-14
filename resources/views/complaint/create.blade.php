@extends('layouts.app')
@section('title', 'Report Incident')
@section('content')
<div class="topbar">
  <div><div class="page-title">📝 Report Child Labour Incident</div><div class="page-sub">Your report will be reviewed within 48 hours</div></div>
</div>

<div style="max-width:680px">
  <div class="card">
    <div class="card-title">Incident Details</div>
    <form method="POST" action="{{ route('complaint.store') }}">
      @csrf
      <input type="hidden" name="city" value="Not Specified">
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Reporter Name <span style="color:var(--text3)">(Optional)</span></label>
          <input class="form-input" name="reporter_name" placeholder="Your name (optional)"/>
        </div>
        <div class="form-group">
          <label class="form-label">Contact Number <span style="color:var(--text3)">(Optional)</span></label>
          <input class="form-input" name="reporter_phone" placeholder="+91 XXXXX XXXXX"/>
        </div>
      </div>
      <div class="form-group">
        <label class="form-label">Incident Location *</label>
        <input class="form-input" name="location" placeholder="Village/Town, District, State" required/>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Type of Labour *</label>
          <select class="form-input" name="type" required>
            <option value="">Select type...</option>
            <option>Factory / Industrial</option>
            <option>Domestic Work</option>
            <option>Agriculture / Farm</option>
            <option>Construction Site</option>
            <option>Roadside / Shops</option>
            <option>Mining / Quarry</option>
            <option>Begging / Street</option>
            <option>Other</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Estimated No. of Children *</label>
          <input class="form-input" name="count" type="number" placeholder="e.g. 3" min="1" required/>
        </div>
      </div>
      <div class="form-group">
        <label class="form-label">Description of Incident *</label>
        <textarea class="form-input" name="description" placeholder="Describe what you observed — approximate ages, working conditions, any employer details..." required minlength="20"></textarea>
      </div>
      <div class="form-group">
        <label class="form-label">Urgency Level</label>
        <select class="form-input" name="urgency">
          <option>Normal — Review within 48 hours</option>
          <option>Urgent — Immediate danger / abuse</option>
        </select>
      </div>
      <div style="display:flex;gap:10px;margin-top:4px">
        <button type="submit" class="btn btn-primary">Submit Report →</button>
        <button type="reset" class="btn btn-ghost">Clear Form</button>
      </div>
    </form>
  </div>
</div>
@endsection
