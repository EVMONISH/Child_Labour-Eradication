<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChildCase;
use App\Models\CaseUpdate;
use App\Models\Ngo;
use Illuminate\Http\Request;

class CaseController extends Controller
{
    public function index(Request $request)
    {
        $query = ChildCase::with(['complaint', 'ngo'])->latest();
        if ($request->status) $query->where('status', $request->status);
        if ($request->city)   $query->where('city', 'like', "%{$request->city}%");
        $cases = $query->paginate(15);
        $ngos = Ngo::where('is_active', true)->get();
        return view('admin.cases.index', compact('cases', 'ngos'));
    }

    public function show(ChildCase $case)
    {
        $case->load(['complaint', 'ngo', 'child', 'updates.updater']);
        $ngos = Ngo::where('is_active', true)->get();
        return view('admin.cases.show', compact('case', 'ngos'));
    }

    public function assignNgo(Request $request, ChildCase $case)
    {
        $request->validate(['ngo_id' => 'required|exists:ngos,id', 'assigned_to_type' => 'required']);
        $case->update([
            'assigned_ngo_id'  => $request->ngo_id,
            'assigned_to_type' => $request->assigned_to_type,
            'status'           => 'under_investigation',
        ]);

        CaseUpdate::create([
            'case_id'    => $case->id,
            'updated_by' => auth()->id(),
            'status'     => 'under_investigation',
            'note'       => 'Case assigned to NGO: ' . $case->ngo->name,
        ]);

        return redirect()->route('admin.cases.show', $case)->with('success', 'Case assigned successfully!');
    }

    public function updateStatus(Request $request, ChildCase $case)
    {
        $request->validate(['status' => 'required', 'note' => 'required']);
        $old = $case->status;
        $case->update(['status' => $request->status]);

        if ($request->status === 'rescued' && !$case->rescued_at) {
            $case->update(['rescued_at' => now()]);
        }
        if ($request->status === 'rehabilitated' && !$case->rehabilitated_at) {
            $case->update(['rehabilitated_at' => now()]);
        }

        CaseUpdate::create([
            'case_id'    => $case->id,
            'updated_by' => auth()->id(),
            'status'     => $request->status,
            'note'       => $request->note,
        ]);

        return redirect()->route('admin.cases.show', $case)->with('success', 'Status updated!');
    }
}
