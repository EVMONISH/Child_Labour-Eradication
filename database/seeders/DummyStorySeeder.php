<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Story;
use App\Models\Child;
use App\Models\ChildCase;

class DummyStorySeeder extends Seeder
{
    public function run(): void
    {
        $children = Child::with('case')->get();
        
        $stories = [
            [
                'content' => "After months of hard work, we finally managed to rescue him from a dangerous factory environment. He is now safely reunited with his family and has started attending the local public school. Seeing his smile return has been the most rewarding experience for our entire team.",
            ],
            [
                'content' => "Found working long hours at a construction site, this brave child has now been completely rehabilitated. Through our education program, they have caught up on missed schooling and show an incredible aptitude for learning. The transformation from a fearful laborer to a confident student is truly inspiring.",
            ],
            [
                'content' => "It was a challenging case, but thanks to the swift action of the authorities and our shelter staff, we provided immediate medical care and counseling. Today, they are thriving in a safe environment, far away from the exploitation they once faced. We are incredibly proud of their resilience.",
            ]
        ];

        foreach ($children as $index => $child) {
            if ($index >= count($stories)) break;
            
            Story::create([
                'case_id' => $child->case_id,
                'child_id' => $child->id,
                'ngo_id' => $child->case->assigned_ngo_id ?? 1,
                'content' => $stories[$index]['content'],
                'status' => 'approved',
                'published_at' => now()->subDays(rand(1, 10))
            ]);
            
            // ensure the case is marked as rehabilitated
            if ($child->case) {
                $child->case->update(['status' => 'rehabilitated']);
            }
        }
    }
}
