<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\Child;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    public function index()
    {
        $stories = Story::with(['child', 'case', 'ngo'])
            ->where('status', 'approved')
            ->latest('published_at')
            ->get();

        $stats = [
            'total_rescued' => Child::count(),
            'in_school'     => Child::where('school_enrolled', true)->count(),
            'reunited'      => Child::whereNotNull('guardian_relation')->orWhereNotNull('guardian_name')->count(),
            'stories_pub'   => Story::where('status', 'approved')->count(),
        ];

        return view('public.stories', compact('stories', 'stats'));
    }
}
