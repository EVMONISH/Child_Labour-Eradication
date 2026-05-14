<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Story;
use App\Models\Child;
use App\Models\ChildCase;
use App\Models\Complaint;

class AddThirdStorySeeder extends Seeder
{
    public function run(): void
    {
        // Check if we already have 3 stories
        if (Story::count() >= 3) {
            return;
        }

        // Create a fake complaint
        $complaint = Complaint::create([
            'tracking_id' => 'TRK-' . strtoupper(uniqid()),
            'reporter_name' => 'Anonymous',
            'description' => 'Child found working in a local dhaba.',
            'location' => 'Highway Road',
            'city' => 'Delhi',
            'status' => 'approved',
        ]);

        // Create a fake case
        $case = ChildCase::create([
            'case_number' => 'CASE-' . rand(1000, 9999),
            'complaint_id' => $complaint->id,
            'assigned_ngo_id' => 1,
            'assigned_to_type' => 'ngo',
            'status' => 'rehabilitated',
            'location' => 'Highway Road',
            'city' => 'Delhi',
            'description' => 'Child found working in a local dhaba.',
            'rescued_at' => now()->subMonths(2),
            'rehabilitated_at' => now()->subDays(5),
        ]);

        // Create a fake child
        $child = Child::create([
            'case_id' => $case->id,
            'name' => 'Suresh',
            'age' => 12,
            'gender' => 'male',
            'rescue_location' => 'Highway Road',
            'rescue_city' => 'Delhi',
            'rescue_date' => now()->subMonths(2),
            'school_enrolled' => true,
            'school_name' => 'Govt School Delhi',
            'guardian_relation' => 'Mother',
        ]);

        // Create the 3rd story
        Story::create([
            'case_id' => $case->id,
            'child_id' => $child->id,
            'ngo_id' => 1,
            'content' => "Suresh was found working long hours at a roadside dhaba. After his rescue, he was given immediate care and counseling. Today, he is back with his mother and excelling in his new school. His dream is to become a teacher and help other children.",
            'status' => 'approved',
            'published_at' => now()->subDays(2),
        ]);
    }
}
