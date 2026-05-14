<?php

namespace App\Http\Controllers\Ngo;

use App\Http\Controllers\Controller;
use App\Models\ChildCase;
use App\Models\CaseUpdate;
use App\Models\Child;
use App\Models\Story;
use Illuminate\Http\Request;

class NgoCaseController extends Controller
{
    private function scopedCases()
    {
        $user = auth()->user();
        if ($user->isAdmin()) return ChildCase::query();
        return ChildCase::where('assigned_ngo_id', $user->ngo_id);
    }

    public function dashboard()
    {
        $user  = auth()->user();
        $cases = $this->scopedCases()->with(['complaint', 'child'])->latest()->paginate(10);

        $stats = [
            'total'        => $this->scopedCases()->count(),
            'investigation'=> $this->scopedCases()->where('status', 'under_investigation')->count(),
            'rescued'      => $this->scopedCases()->where('status', 'rescued')->count(),
            'rehabilitated'=> $this->scopedCases()->where('status', 'rehabilitated')->count(),
        ];

        $resolved_cases = $this->scopedCases()
            ->where('status', 'rehabilitated')
            ->whereHas('child')
            ->with('child')
            ->get();

        return view('ngo.dashboard', compact('cases', 'stats', 'user', 'resolved_cases'));
    }

    public function show(ChildCase $case)
    {
        $this->authorizeCase($case);
        $case->load(['complaint', 'child', 'updates.updater', 'ngo']);
        return view('ngo.cases.show', compact('case'));
    }

    public function updateProgress(Request $request, ChildCase $case)
    {
        $this->authorizeCase($case);
        $request->validate(['note' => 'required', 'status' => 'required']);

        $case->update(['status' => $request->status]);

        if ($request->status === 'rescued' && !$case->rescued_at) {
            $case->update(['rescued_at' => now()]);
        }
        if ($request->status === 'rehabilitated' && !$case->rehabilitated_at) {
            $case->update(['rehabilitated_at' => now()]);
        }

        $docPath = null;
        if ($request->hasFile('document')) {
            $docPath = $request->file('document')->store('case_docs', 'public');
        }

        CaseUpdate::create([
            'case_id'       => $case->id,
            'updated_by'    => auth()->id(),
            'status'        => $request->status,
            'note'          => $request->note,
            'document_path' => $docPath,
        ]);

        return redirect()->route('ngo.cases.show', $case)->with('success', 'Progress updated!');
    }

    public function addChild(Request $request, ChildCase $case)
    {
        $this->authorizeCase($case);
        $request->validate([
            'name'        => 'required',
            'age'         => 'required|integer|min:1|max:17',
            'rescue_date' => 'required|date',
            'rescue_city' => 'required',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('children', 'public');
        }

        Child::updateOrCreate(['case_id' => $case->id], [
            'case_id'          => $case->id,
            'name'             => $request->name,
            'age'              => $request->age,
            'gender'           => $request->gender ?? 'male',
            'rescue_location'  => $request->rescue_location ?? $case->location,
            'rescue_city'      => $request->rescue_city,
            'rescue_date'      => $request->rescue_date,
            'school_name'      => $request->school_name,
            'school_enrolled'  => $request->boolean('school_enrolled'),
            'guardian_name'    => $request->guardian_name,
            'guardian_phone'   => $request->guardian_phone,
            'guardian_relation'=> $request->guardian_relation,
            'health_status'    => $request->health_status,
            'notes'            => $request->notes,
            'photo_path'       => $photoPath,
        ]);

        return redirect()->route('ngo.cases.show', $case)->with('success', 'Child details saved!');
    }

    public function submitStory(Request $request, ChildCase $case)
    {
        $this->authorizeCase($case);
        $request->validate([
            'content' => 'required|string|min:20',
        ]);

        if (!$case->child) {
            return back()->with('error', 'A child profile must exist to submit a story.');
        }

        Story::create([
            'case_id' => $case->id,
            'child_id' => $case->child->id,
            'ngo_id' => $case->assigned_ngo_id,
            'content' => $request->content,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Story submitted successfully and is pending admin approval.');
    }

    public function contributions()
    {
        return view('ngo.contributions');
    }

    private function authorizeCase(ChildCase $case)
    {
        $user = auth()->user();
        if ($user->isAdmin()) return;
        if ($case->assigned_ngo_id !== $user->ngo_id) {
            abort(403);
        }
    }
}
