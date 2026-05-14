<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChildCase;
use App\Models\Complaint;
use App\Models\Child;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        // Cases by status
        $casesByStatus = ChildCase::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')->pluck('total', 'status');

        // Monthly complaints (last 12 months)
        $monthlyComplaints = Complaint::select(
            DB::raw("strftime('%Y-%m', created_at) as month"),
            DB::raw('count(*) as total')
        )->where('created_at', '>=', now()->subMonths(12))
         ->groupBy('month')->orderBy('month')->get();

        // Top cities with most cases
        $topCities = ChildCase::select('city', DB::raw('count(*) as total'))
            ->groupBy('city')->orderByDesc('total')->take(10)->get();

        // Monthly rescues
        $monthlyRescues = ChildCase::select(
            DB::raw("strftime('%Y-%m', rescued_at) as month"),
            DB::raw('count(*) as total')
        )->whereNotNull('rescued_at')
         ->where('rescued_at', '>=', now()->subMonths(12))
         ->groupBy('month')->orderBy('month')->get();

        // Children by age group
        $ageGroups = [
            '5-8'  => Child::whereBetween('age', [5, 8])->count(),
            '9-12' => Child::whereBetween('age', [9, 12])->count(),
            '13-15'=> Child::whereBetween('age', [13, 15])->count(),
            '16-17'=> Child::whereBetween('age', [16, 17])->count(),
        ];

        $totalChildren   = Child::count();
        $enrolledChildren= Child::where('school_enrolled', true)->count();

        return view('admin.analytics.index', compact(
            'casesByStatus', 'monthlyComplaints', 'topCities',
            'monthlyRescues', 'ageGroups', 'totalChildren', 'enrolledChildren'
        ));
    }
}
