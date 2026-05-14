<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\ChildCase;
use App\Models\Ngo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ComplaintAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Complaint::latest();
        if ($request->status) $query->where('status', $request->status);
        if ($request->city)   $query->where('city', 'like', "%{$request->city}%");
        $complaints = $query->paginate(15);
        return view('admin.complaints.index', compact('complaints'));
    }

    public function show(Complaint $complaint)
    {
        return view('admin.complaints.show', compact('complaint'));
    }

    public function approve(Request $request, Complaint $complaint)
    {
        $request->validate(['admin_notes' => 'nullable|string']);
        $complaint->update(['status' => 'approved', 'admin_notes' => $request->admin_notes]);

        // Auto-create a case
        $case = ChildCase::create([
            'case_number'  => 'CASE-' . strtoupper(Str::random(8)),
            'complaint_id' => $complaint->id,
            'status'       => 'pending',
            'location'     => $complaint->location,
            'city'         => $complaint->city,
            'description'  => $complaint->description,
        ]);
        $complaint->update(['case_id' => $case->id]);

        return redirect()->route('admin.cases.show', $case)->with('success', 'Complaint approved and case created!');
    }

    public function reject(Request $request, Complaint $complaint)
    {
        $complaint->update(['status' => 'rejected', 'admin_notes' => $request->admin_notes]);
        return redirect()->route('admin.complaints.index')->with('success', 'Complaint rejected.');
    }
}
