<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Story;
use Illuminate\Http\Request;

class StoryAdminController extends Controller
{
    public function index()
    {
        $stories = Story::with(['child', 'case', 'ngo'])->latest()->paginate(15);
        return view('admin.stories.index', compact('stories'));
    }

    public function approve(Story $story)
    {
        $story->update([
            'status' => 'approved',
            'published_at' => now(),
        ]);
        return back()->with('success', 'Story approved and published.');
    }

    public function reject(Story $story)
    {
        $story->update([
            'status' => 'rejected',
            'published_at' => null,
        ]);
        return back()->with('success', 'Story rejected.');
    }
}
