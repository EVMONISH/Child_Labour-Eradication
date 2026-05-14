<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ComplaintController extends Controller
{
    public function create()
    {
        return view('complaint.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|min:20',
            'location'    => 'required',
            'type'        => 'required',
            'count'       => 'required|numeric|min:1',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('complaints', 'public');
        }

        $fullDescription = "Type: {$request->type}\n";
        $fullDescription .= "Est. Children: {$request->count}\n";
        $fullDescription .= "Urgency: {$request->urgency}\n\n";
        $fullDescription .= $request->description;

        $complaint = Complaint::create([
            'tracking_id'    => 'CL-' . strtoupper(Str::random(8)),
            'reporter_name'  => $request->reporter_name,
            'reporter_phone' => $request->reporter_phone,
            'description'    => $fullDescription,
            'location'       => $request->location,
            'city'           => $request->city ?? 'Not Specified',
            'photo_path'     => $photoPath,
            'status'         => 'pending',
        ]);

        return redirect()->route('complaint.success', $complaint->tracking_id);
    }

    public function success($trackingId)
    {
        $complaint = Complaint::where('tracking_id', $trackingId)->firstOrFail();
        return view('complaint.success', compact('complaint'));
    }

    public function track(Request $request)
    {
        $complaint = null;
        if ($request->tracking_id) {
            $complaint = Complaint::where('tracking_id', $request->tracking_id)->first();
        }
        return view('complaint.track', compact('complaint'));
    }
}
