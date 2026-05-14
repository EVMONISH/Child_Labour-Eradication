<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Child;
use App\Models\ChildCase;
use Illuminate\Http\Request;

class ChildController extends Controller
{
    public function index(Request $request)
    {
        $query = Child::with('case')->latest();
        if ($request->city)            $query->where('rescue_city', 'like', "%{$request->city}%");
        if ($request->school_enrolled) $query->where('school_enrolled', $request->school_enrolled === 'yes');
        $children = $query->paginate(15);
        return view('admin.children.index', compact('children'));
    }

    public function show(Child $child)
    {
        $child->load('case.complaint');
        return view('admin.children.show', compact('child'));
    }

    public function create(ChildCase $case)
    {
        return view('admin.children.create', compact('case'));
    }

    public function store(Request $request, ChildCase $case)
    {
        $request->validate([
            'name'         => 'required',
            'age'          => 'required|integer|min:1|max:17',
            'gender'       => 'required',
            'rescue_date'  => 'required|date',
            'rescue_city'  => 'required',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('children', 'public');
        }

        Child::create([
            'case_id'          => $case->id,
            'name'             => $request->name,
            'age'              => $request->age,
            'gender'           => $request->gender,
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

        $case->update(['status' => 'rescued', 'rescued_at' => now()]);

        return redirect()->route('admin.cases.show', $case)->with('success', 'Child record added successfully!');
    }
}
