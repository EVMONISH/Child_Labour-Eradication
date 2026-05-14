<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChildCase;
use App\Models\Child;
use App\Models\Complaint;
use App\Models\Ngo;
use Illuminate\Http\Request;

class ImpactController extends Controller
{
    public function index()
    {
        $totalChildren = Child::count();
        $totalCases = ChildCase::count();
        $resolvedCasesCount = ChildCase::where('status', 'rehabilitated')->count();
        
        $enrolmentRate = $totalChildren > 0 
            ? round((Child::where('school_enrolled', true)->count() / $totalChildren) * 100) 
            : 0;

        $reunionCount = Child::whereNotNull('guardian_relation')->orWhereNotNull('guardian_name')->count();
        $reunionRate = $totalChildren > 0 
            ? round(($reunionCount / $totalChildren) * 100) 
            : 0;

        $caseResolutionRate = $totalCases > 0 
            ? round(($resolvedCasesCount / $totalCases) * 100) 
            : 0;

        $stats = [
            'total_rescued'   => $totalChildren,
            'enrolment_rate'  => $enrolmentRate,
            'reunion_rate'    => $reunionRate,
            'case_resolution' => $caseResolutionRate,
        ];

        $rehabOutcomes = [
            'in_school' => $enrolmentRate,
            'with_family' => $reunionRate,
            'in_shelter' => 100 - ($enrolmentRate + $reunionRate) > 0 ? 100 - ($enrolmentRate + $reunionRate) : 0,
            'medical_aid' => $totalChildren > 0 ? round((Child::whereNotNull('health_status')->count() / $totalChildren) * 100) : 0,
        ];

        $currentMonth = now()->startOfMonth();
        $milestones = [
            'school_enrolments' => Child::where('school_enrolled', true)->where('created_at', '>=', $currentMonth)->count(),
            'cases_resolved'    => ChildCase::where('status', 'rehabilitated')->where('updated_at', '>=', $currentMonth)->count(),
            'active_ngos'       => Ngo::where('is_active', true)->count(),
            'family_reunions'   => Child::where(function($q) {
                $q->whereNotNull('guardian_relation')->orWhereNotNull('guardian_name');
            })->where('created_at', '>=', $currentMonth)->count(),
            'complaint_res_rate'=> Complaint::count() > 0 ? round((Complaint::where('status', 'approved')->count() / Complaint::count()) * 100) : 0,
        ];

        $casesByLocation = ChildCase::selectRaw('location, count(*) as total_cases, sum(case when status in ("rescued", "rehabilitated") then 1 else 0 end) as resolved_cases')
            ->groupBy('location')
            ->get()
            ->map(function($loc) {
                $loc->children_count = Child::whereHas('case', function($q) use ($loc) {
                    $q->where('location', $loc->location);
                })->count();
                return $loc;
            });

        $ngoPerformance = Ngo::withCount(['cases as assigned_cases'])
            ->withCount(['cases as resolved_cases' => function($q) {
                $q->where('status', 'rehabilitated');
            }])->get()->map(function($ngo) {
                $ngo->response_rate = $ngo->assigned_cases > 0 
                    ? round((ChildCase::where('assigned_ngo_id', $ngo->id)->where('status', '!=', 'pending')->count() / $ngo->assigned_cases) * 100) 
                    : 0;
                $ngo->children_rescued = Child::whereHas('case', function($q) use ($ngo) {
                    $q->where('assigned_ngo_id', $ngo->id);
                })->count();
                return $ngo;
            });

        // Monthly Complaints Trend (last 6 months)
        $complaintsTrend = collect();
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $complaintsTrend->push([
                'month' => $month->format('M'),
                'count' => Complaint::whereYear('created_at', $month->year)
                                    ->whereMonth('created_at', $month->month)
                                    ->count()
            ]);
        }

        return view('admin.impact', compact('stats', 'rehabOutcomes', 'milestones', 'casesByLocation', 'ngoPerformance', 'complaintsTrend'));
    }
}
