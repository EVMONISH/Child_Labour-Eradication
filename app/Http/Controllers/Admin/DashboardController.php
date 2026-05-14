<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\ChildCase;
use App\Models\Child;
use App\Models\Ngo;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_complaints'   => Complaint::count(),
            'pending_complaints' => Complaint::where('status', 'pending')->count(),
            'total_cases'        => ChildCase::count(),
            'pending_cases'      => ChildCase::where('status', 'pending')->count(),
            'investigation'      => ChildCase::where('status', 'under_investigation')->count(),
            'rescued'            => ChildCase::where('status', 'rescued')->count(),
            'rehabilitated'      => ChildCase::where('status', 'rehabilitated')->count(),
            'total_children'     => Child::count(),
            'enrolled_children'  => Child::where('school_enrolled', true)->count(),
            'total_ngos'         => Ngo::count(),
        ];

        $recentComplaints = Complaint::latest()->take(5)->get();
        $recentCases      = ChildCase::with('ngo')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentComplaints', 'recentCases'));
    }
}
