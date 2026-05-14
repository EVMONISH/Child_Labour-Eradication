@extends('layouts.app')
@section('title', 'My Contributions')
@section('content')

<style>
    .quote-box {
        background: var(--card);
        border-left: 4px solid var(--accent2);
        padding: 30px;
        border-radius: 0 var(--radius) var(--radius) 0;
        margin-top: 30px;
        position: relative;
    }
    .quote-icon {
        position: absolute;
        top: -15px;
        left: 20px;
        font-size: 40px;
        color: var(--accent2);
        opacity: 0.3;
        font-family: serif;
    }
    .quote-text {
        font-size: 16px;
        line-height: 1.8;
        color: var(--text);
        font-style: italic;
        margin-bottom: 16px;
        z-index: 1;
        position: relative;
    }
    .quote-author {
        font-weight: 600;
        color: var(--accent);
        font-size: 14px;
    }
    .quote-designation {
        font-size: 12px;
        color: var(--text3);
    }
    .gallery-img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: var(--radius2);
        margin-bottom: 12px;
    }
    .gallery-caption {
        font-size: 13px;
        color: var(--text2);
        text-align: center;
        font-weight: 500;
    }
    .certificate-container {
        border: 2px solid var(--border);
        padding: 10px;
        border-radius: var(--radius);
        background: var(--bg3);
        margin-bottom: 20px;
    }
    .certificate-img {
        width: 100%;
        height: auto;
        border-radius: var(--radius2);
        display: block;
    }
    .activity-card {
        padding: 24px;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .activity-icon {
        font-size: 32px;
        margin-bottom: 16px;
    }
    .activity-title {
        font-family: var(--sora);
        font-weight: 600;
        color: var(--text);
        margin-bottom: 12px;
        font-size: 16px;
    }
    .activity-stat {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        font-size: 13px;
    }
    .activity-desc {
        margin-top: auto;
        padding-top: 16px;
        border-top: 1px solid var(--border);
        font-size: 12px;
        color: var(--text3);
        line-height: 1.5;
    }
</style>

<div class="topbar">
    <div>
        <h1 class="page-title">My Contributions</h1>
        <p class="page-sub">Personal volunteer work & impact log</p>
    </div>
</div>

<!-- SECTION 1: Top Summary Stats -->
<div class="grid-4">
    <div class="stat-card blue">
        <div class="stat-val">45</div>
        <div class="stat-label">Total Days Volunteered</div>
    </div>
    <div class="stat-card green">
        <div class="stat-val">120+</div>
        <div class="stat-label">People Helped</div>
    </div>
    <div class="stat-card warn">
        <div class="stat-val">85</div>
        <div class="stat-label">Medical Aids Given</div>
    </div>
    <div class="stat-card red">
        <div class="stat-val">₹5,000</div>
        <div class="stat-label">Personal Donations Made</div>
    </div>
</div>

<!-- SECTION 2: Activity Breakdown -->
<div class="grid-4">
    <div class="card activity-card">
        <div class="activity-icon">🍽️</div>
        <div class="activity-title">Food Service</div>
        <div class="activity-stat"><span style="color:var(--text3)">Meals Served:</span> <strong style="color:var(--accent)">350+</strong></div>
        <div class="activity-stat"><span style="color:var(--text3)">Days Active:</span> <strong>30 Days</strong></div>
        <div class="activity-desc">Served nutritious meals to elderly residents daily</div>
    </div>
    <div class="card activity-card">
        <div class="activity-icon">🩹</div>
        <div class="activity-title">Medical Aid</div>
        <div class="activity-stat"><span style="color:var(--text3)">Wounds Treated:</span> <strong style="color:var(--accent)">45</strong></div>
        <div class="activity-stat"><span style="color:var(--text3)">Checkups Done:</span> <strong>85</strong></div>
        <div class="activity-desc">Provided basic first aid and health monitoring</div>
    </div>
    <div class="card activity-card">
        <div class="activity-icon">🚶</div>
        <div class="activity-title">Physical Activity</div>
        <div class="activity-stat"><span style="color:var(--text3)">Walking Sessions:</span> <strong style="color:var(--accent)">60+</strong></div>
        <div class="activity-stat"><span style="color:var(--text3)">Participants:</span> <strong>40</strong></div>
        <div class="activity-desc">Assisted elderly in daily walks and light exercise</div>
    </div>
    <div class="card activity-card">
        <div class="activity-icon">💰</div>
        <div class="activity-title">Personal Donation</div>
        <div class="activity-stat"><span style="color:var(--text3)">Food Donated:</span> <strong style="color:var(--accent)">150 kg</strong></div>
        <div class="activity-stat"><span style="color:var(--text3)">Amount Spent:</span> <strong>₹5,000</strong></div>
        <div class="activity-desc">Personally funded meals and essentials for residents</div>
    </div>
</div>

<!-- SECTION 3: Contribution Log Table -->
<div class="card" style="margin-bottom: 24px;">
    <div class="sec-head">
        <div class="sec-title">Daily Contribution Log</div>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Activity Type</th>
                    <th>Description</th>
                    <th>People Helped</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>14 May 2026</td>
                    <td><span class="badge badge-active">Food Service</span></td>
                    <td class="td-primary">Served breakfast and dinner</td>
                    <td>25</td>
                    <td>Special requests handled for diabetic patients</td>
                </tr>
                <tr>
                    <td>13 May 2026</td>
                    <td><span class="badge badge-progress">Medical Aid</span></td>
                    <td class="td-primary">Routine health checkup assistance</td>
                    <td>18</td>
                    <td>Assisted doctor with BP and sugar checks</td>
                </tr>
                <tr>
                    <td>10 May 2026</td>
                    <td><span class="badge badge-approved">Physical Activity</span></td>
                    <td class="td-primary">Evening park walk</td>
                    <td>12</td>
                    <td>Used wheelchairs for 3 residents</td>
                </tr>
                <tr>
                    <td>08 May 2026</td>
                    <td><span class="badge badge-rejected">Donation</span></td>
                    <td class="td-primary">Purchased essential medicines</td>
                    <td>5</td>
                    <td>Spent ₹1,200 out of pocket</td>
                </tr>
                <tr>
                    <td>05 May 2026</td>
                    <td><span class="badge badge-active">Food Service</span></td>
                    <td class="td-primary">Special festival lunch distribution</td>
                    <td>45</td>
                    <td>Coordinated with kitchen staff for timely prep</td>
                </tr>
                <tr>
                    <td>01 May 2026</td>
                    <td><span class="badge badge-progress">Medical Aid</span></td>
                    <td class="td-primary">Wound dressing</td>
                    <td>3</td>
                    <td>Provided first aid kits</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- SECTION 4: Certificate Section -->
<div class="card" style="margin-bottom: 24px;">
    <div class="sec-head">
        <div class="sec-title">Volunteer Certificate</div>
    </div>
    <div class="detail-grid" style="margin-bottom: 20px;">
        <div class="detail-key">Display Name</div><div class="detail-val" style="font-weight:600;">E.V. Monish</div>
        <div class="detail-key">Organization</div><div class="detail-val">The Windson Charitable Trust</div>
        <div class="detail-key">Duration</div><div class="detail-val">45 Days</div>
    </div>
    
    <div class="certificate-container">
        <img src="{{ asset('assets/images/volunteer_certificate.jpg') }}" alt="Volunteer Certificate" class="certificate-img">
    </div>
    <div style="text-align: center;">
        <button class="btn btn-primary">⬇ Download Certificate</button>
    </div>
</div>

<!-- SECTION 5: Photo Gallery -->
<div class="card" style="margin-bottom: 24px;">
    <div class="sec-head">
        <div class="sec-title">My Work in Action</div>
    </div>
    <div class="grid-3" style="margin-bottom: 0;">
        <div>
            <img src="https://images.unsplash.com/photo-1593113514051-512b9a7384a5?w=500&h=300&fit=crop" alt="Serving meals" class="gallery-img">
            <div class="gallery-caption">Serving meals to residents</div>
        </div>
        <div>
            <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=500&h=300&fit=crop" alt="Providing first aid" class="gallery-img">
            <div class="gallery-caption">Providing first aid</div>
        </div>
        <div>
            <img src="https://images.unsplash.com/photo-1511895426328-dc8714191300?w=500&h=300&fit=crop" alt="Morning walk" class="gallery-img">
            <div class="gallery-caption">Morning walk session</div>
        </div>
        <div>
            <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=500&h=300&fit=crop" alt="Food donation" class="gallery-img">
            <div class="gallery-caption">Food donation day</div>
        </div>
    </div>
</div>

<!-- SECTION 6: Personal Note -->
<div class="quote-box">
    <div class="quote-icon">"</div>
    <div class="quote-text">
        This experience of serving people in need for 45 days inspired me to build this system. Every human being deserves care, dignity and support — and technology can help make that possible.
    </div>
    <div class="quote-author">E.V. Monish</div>
    <div class="quote-designation">Student Volunteer</div>
</div>

@endsection
