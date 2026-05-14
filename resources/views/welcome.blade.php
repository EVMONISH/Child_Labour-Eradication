@extends('layouts.app')
@section('title', 'Home')
@section('content')
<div class="landing-hero">
  <div class="hero-badge">🛡 Government of India Initiative</div>
  <h1 class="hero-title">Protect Every Child's<br><span>Right to Childhood</span></h1>
  <p class="hero-sub">Report child labour incidents anonymously. Track your complaint. Help us rescue and rehabilitate children across the country.</p>
  <div class="hero-btns">
    <a href="{{ route('complaint.create') }}" class="btn btn-primary" style="padding:12px 28px;font-size:14px">📝 Report an Incident</a>
    <a href="{{ route('complaint.track') }}" class="btn btn-ghost" style="padding:12px 28px;font-size:14px">🔍 Track My Complaint</a>
  </div>
</div>
<div class="grid-3">
  <div class="feature-card">
    <div class="feature-icon">🔒</div>
    <div class="feature-title">Anonymous Reporting</div>
    <div class="feature-desc">Submit complaints without revealing your identity. Your information is secure and confidential.</div>
  </div>
  <div class="feature-card">
    <div class="feature-icon">⚡</div>
    <div class="feature-title">Fast Response</div>
    <div class="feature-desc">Every complaint is reviewed within 48 hours. Urgent cases are escalated immediately to rescue teams.</div>
  </div>
  <div class="feature-card">
    <div class="feature-icon">🤝</div>
    <div class="feature-title">NGO Network</div>
    <div class="feature-desc">Over 120 registered NGOs ready to respond and provide rehabilitation support for rescued children.</div>
  </div>
</div>
<div class="grid-4">
  <div class="stat-card blue"><div class="stat-val">2,847</div><div class="stat-label">Total Complaints Filed</div></div>
  <div class="stat-card green"><div class="stat-val">1,593</div><div class="stat-label">Children Rescued</div></div>
  <div class="stat-card warn"><div class="stat-val">124</div><div class="stat-label">Active Cases</div></div>
  <div class="stat-card red"><div class="stat-val">97%</div><div class="stat-label">Case Resolution Rate</div></div>
</div>
@endsection
