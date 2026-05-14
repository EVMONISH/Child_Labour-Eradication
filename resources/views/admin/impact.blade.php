@extends('layouts.app')

@section('content')
<style>
    /* Add specific styles for the Impact Dashboard charts */
    .progress-bar-container {
        width: 100%;
        background-color: var(--bg3);
        border-radius: var(--radius2);
        height: 24px;
        margin-bottom: 8px;
        position: relative;
        overflow: hidden;
    }
    .progress-bar {
        height: 100%;
        display: flex;
        align-items: center;
        padding-left: 10px;
        font-size: 11px;
        font-weight: 600;
        color: #fff;
        transition: width 0.5s ease;
    }
    .progress-bar.blue { background-color: var(--accent); }
    .progress-bar.green { background-color: var(--accent2); }
    .progress-bar.orange { background-color: var(--warn); }
    .progress-bar.red { background-color: var(--danger); }

    .trend-chart {
        display: flex;
        align-items: flex-end;
        gap: 12px;
        height: 150px;
        padding-top: 20px;
        border-bottom: 1px solid var(--border);
        margin-bottom: 8px;
    }
    .trend-bar-wrapper {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        align-items: center;
        height: 100%;
    }
    .trend-bar {
        width: 100%;
        max-width: 40px;
        background: linear-gradient(to top, var(--accent), var(--accent2));
        border-radius: 4px 4px 0 0;
        transition: height 0.5s ease;
        position: relative;
    }
    .trend-label {
        font-size: 11px;
        color: var(--text3);
        margin-top: 8px;
    }
    .trend-value {
        font-size: 10px;
        color: var(--text);
        position: absolute;
        top: -16px;
        width: 100%;
        text-align: center;
    }
</style>

<div class="topbar">
    <div>
        <h1 class="page-title">Impact Dashboard</h1>
        <p class="page-sub">Live system performance & rescue outcomes</p>
    </div>
</div>

<!-- SECTION 1: Top Stats Row -->
<div class="grid-4">
    <div class="stat-card blue">
        <div class="stat-val">{{ $stats['total_rescued'] }}</div>
        <div class="stat-label">Total Children Rescued</div>
    </div>
    <div class="stat-card green">
        <div class="stat-val">{{ $stats['enrolment_rate'] }}%</div>
        <div class="stat-label">School Enrolment Rate</div>
    </div>
    <div class="stat-card warn">
        <div class="stat-val">{{ $stats['reunion_rate'] }}%</div>
        <div class="stat-label">Family Reunion Rate</div>
    </div>
    <div class="stat-card red">
        <div class="stat-val">{{ $stats['case_resolution'] }}%</div>
        <div class="stat-label">Case Resolution Rate</div>
    </div>
</div>

<!-- SECTION 2: Rehabilitation Outcomes -->
<div class="card" style="margin-bottom:24px;">
    <h3 class="card-title">Rehabilitation Outcomes</h3>
    
    <div style="margin-bottom:15px;">
        <div style="display:flex; justify-content:space-between; font-size:12px; margin-bottom:4px; color:var(--text2);">
            <span>In School</span>
            <span>{{ $rehabOutcomes['in_school'] }}%</span>
        </div>
        <div class="progress-bar-container">
            <div class="progress-bar blue" style="width: {{ $rehabOutcomes['in_school'] }}%"></div>
        </div>
    </div>

    <div style="margin-bottom:15px;">
        <div style="display:flex; justify-content:space-between; font-size:12px; margin-bottom:4px; color:var(--text2);">
            <span>Reunited with Family</span>
            <span>{{ $rehabOutcomes['with_family'] }}%</span>
        </div>
        <div class="progress-bar-container">
            <div class="progress-bar green" style="width: {{ $rehabOutcomes['with_family'] }}%"></div>
        </div>
    </div>

    <div style="margin-bottom:15px;">
        <div style="display:flex; justify-content:space-between; font-size:12px; margin-bottom:4px; color:var(--text2);">
            <span>In Shelter</span>
            <span>{{ $rehabOutcomes['in_shelter'] }}%</span>
        </div>
        <div class="progress-bar-container">
            <div class="progress-bar orange" style="width: {{ $rehabOutcomes['in_shelter'] }}%"></div>
        </div>
    </div>

    <div style="margin-bottom:0;">
        <div style="display:flex; justify-content:space-between; font-size:12px; margin-bottom:4px; color:var(--text2);">
            <span>Received Medical Aid</span>
            <span>{{ $rehabOutcomes['medical_aid'] }}%</span>
        </div>
        <div class="progress-bar-container" style="margin-bottom:0;">
            <div class="progress-bar red" style="width: {{ $rehabOutcomes['medical_aid'] }}%"></div>
        </div>
    </div>
</div>

<!-- SECTION 3: Two Column Layout -->
<div class="grid-2">
    <!-- LEFT COLUMN: Monthly Milestones -->
    <div class="card">
        <h3 class="card-title">Monthly Milestones</h3>
        <div class="update-log">
            <div class="update-log-head">
                <span class="update-log-text" style="font-weight:600;">School enrolments this month</span>
                <span class="badge badge-resolved">{{ $milestones['school_enrolments'] }}</span>
            </div>
        </div>
        <div class="update-log">
            <div class="update-log-head">
                <span class="update-log-text" style="font-weight:600;">Cases resolved this month</span>
                <span class="badge badge-approved">{{ $milestones['cases_resolved'] }}</span>
            </div>
        </div>
        <div class="update-log">
            <div class="update-log-head">
                <span class="update-log-text" style="font-weight:600;">Active NGOs</span>
                <span class="badge badge-active">{{ $milestones['active_ngos'] }}</span>
            </div>
        </div>
        <div class="update-log">
            <div class="update-log-head">
                <span class="update-log-text" style="font-weight:600;">Family reunions</span>
                <span class="badge badge-progress">{{ $milestones['family_reunions'] }}</span>
            </div>
        </div>
        <div class="update-log" style="margin-bottom:0;">
            <div class="update-log-head">
                <span class="update-log-text" style="font-weight:600;">Complaint resolution rate</span>
                <span class="badge badge-active">{{ $milestones['complaint_res_rate'] }}%</span>
            </div>
        </div>
    </div>

    <!-- RIGHT COLUMN: Cases by Location Table -->
    <div class="card">
        <h3 class="card-title">Cases by Location</h3>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Location</th>
                        <th>Total Cases</th>
                        <th>Children Rescued</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($casesByLocation as $loc)
                    <tr>
                        <td class="td-primary">{{ $loc->location }}</td>
                        <td>{{ $loc->total_cases }}</td>
                        <td>{{ $loc->children_count }}</td>
                        <td>
                            @if($loc->resolved_cases > 0 && $loc->resolved_cases == $loc->total_cases)
                                <span class="badge badge-resolved">Resolved</span>
                            @else
                                <span class="badge badge-active">Active</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align:center;color:var(--text3);padding:20px;">No location data available.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- SECTION 4: NGO Performance Table -->
<div class="card" style="margin-bottom:24px;">
    <h3 class="card-title">NGO Performance</h3>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>NGO Name</th>
                    <th>Cases Assigned</th>
                    <th>Cases Resolved</th>
                    <th>Children Rescued</th>
                    <th>Response Rate %</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ngoPerformance as $ngo)
                <tr>
                    <td class="td-primary">{{ $ngo->name }}</td>
                    <td>{{ $ngo->assigned_cases }}</td>
                    <td>{{ $ngo->resolved_cases }}</td>
                    <td>{{ $ngo->children_rescued }}</td>
                    <td>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <div class="progress-bar-container" style="height:6px; margin-bottom:0; width:80px; background:var(--bg3);">
                                <div class="progress-bar {{ $ngo->response_rate >= 80 ? 'green' : ($ngo->response_rate >= 50 ? 'orange' : 'red') }}" style="width: {{ $ngo->response_rate }}%"></div>
                            </div>
                            <span style="font-size:12px;font-weight:600;">{{ $ngo->response_rate }}%</span>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- SECTION 5: Monthly Complaints Trend -->
<div class="card">
    <h3 class="card-title">Monthly Complaints Trend</h3>
    <div class="trend-chart">
        @php
            $maxCount = $complaintsTrend->max('count');
            $maxCount = $maxCount > 0 ? $maxCount : 1; // Prevent division by zero
        @endphp
        @foreach($complaintsTrend as $data)
            @php
                $heightPercentage = ($data['count'] / $maxCount) * 100;
            @endphp
            <div class="trend-bar-wrapper">
                <div class="trend-bar" style="height: {{ $heightPercentage }}%;">
                    <div class="trend-value">{{ $data['count'] }}</div>
                </div>
                <div class="trend-label">{{ $data['month'] }}</div>
            </div>
        @endforeach
    </div>
</div>

@endsection
