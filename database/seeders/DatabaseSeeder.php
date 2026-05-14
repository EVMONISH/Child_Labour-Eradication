<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Ngo;
use App\Models\Complaint;
use App\Models\ChildCase;
use App\Models\Child;
use App\Models\CaseUpdate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create NGO organization
        $ngo = Ngo::create([
            'name'           => 'Bachpan Bachao Foundation',
            'contact_person' => 'Priya Sharma',
            'email'          => 'contact@bachpan.org',
            'phone'          => '9876543210',
            'address'        => '12, Gandhi Nagar',
            'city'           => 'Mumbai',
            'state'          => 'Maharashtra',
            'is_active'      => true,
        ]);

        $ngo2 = Ngo::create([
            'name'           => 'Child Rights India',
            'contact_person' => 'Rakesh Kumar',
            'email'          => 'info@childrights.in',
            'phone'          => '9123456789',
            'address'        => '45, MG Road',
            'city'           => 'Delhi',
            'state'          => 'Delhi',
            'is_active'      => true,
        ]);

        // 2. Admin user
        User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@childlabour.org',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // 3. NGO user
        User::create([
            'name'     => 'NGO Officer',
            'email'    => 'ngo@help.org',
            'password' => Hash::make('password'),
            'role'     => 'ngo',
            'ngo_id'   => $ngo->id,
        ]);

        // 4. Demo complaints & cases
        $cities = ['Mumbai', 'Delhi', 'Chennai', 'Kolkata', 'Hyderabad', 'Bangalore', 'Pune', 'Ahmedabad'];
        $locations = [
            'Near Railway Station', 'Opposite Tea Shop', 'Market Area', 
            'Behind Bus Stand', 'Near School Gate', 'Factory Area',
        ];
        $descs = [
            'A 10-year-old boy seen carrying heavy loads at a local shop.',
            'Young child working as domestic help, appears to be around 9 years old.',
            'Children seen working in a small factory without proper safety measures.',
            'A girl aged about 12 working in a hotel kitchen from early morning.',
            'Three children working at a construction site, no adult supervision.',
        ];

        for ($i = 0; $i < 20; $i++) {
            $city = $cities[array_rand($cities)];
            $status = ['pending', 'approved', 'rejected'][array_rand(['pending', 'approved', 'rejected'])];

            $complaint = Complaint::create([
                'tracking_id'   => 'CL-' . strtoupper(Str::random(8)),
                'reporter_name' => $i % 3 === 0 ? null : 'Citizen ' . ($i + 1),
                'description'   => $descs[array_rand($descs)],
                'location'      => $locations[array_rand($locations)] . ', ' . $city,
                'city'          => $city,
                'status'        => $status,
                'created_at'    => now()->subDays(rand(1, 180)),
            ]);

            if ($status === 'approved' && $i < 12) {
                $caseStatus = ['pending', 'under_investigation', 'rescued', 'rehabilitated'][array_rand(['pending', 'under_investigation', 'rescued', 'rehabilitated'])];
                $assignedNgo = ($i % 2 === 0) ? $ngo->id : $ngo2->id;

                $case = ChildCase::create([
                    'case_number'      => 'CASE-' . strtoupper(Str::random(8)),
                    'complaint_id'     => $complaint->id,
                    'assigned_ngo_id'  => $assignedNgo,
                    'assigned_to_type' => 'ngo',
                    'status'           => $caseStatus,
                    'location'         => $complaint->location,
                    'city'             => $city,
                    'description'      => $complaint->description,
                    'rescued_at'       => in_array($caseStatus, ['rescued', 'rehabilitated']) ? now()->subDays(rand(1, 60)) : null,
                    'rehabilitated_at' => $caseStatus === 'rehabilitated' ? now()->subDays(rand(1, 30)) : null,
                    'created_at'       => $complaint->created_at,
                ]);

                $complaint->update(['case_id' => $case->id]);

                CaseUpdate::create([
                    'case_id'    => $case->id,
                    'updated_by' => 1,
                    'status'     => 'under_investigation',
                    'note'       => 'Case created and assigned to NGO for investigation.',
                    'created_at' => $complaint->created_at->addDays(1),
                ]);

                if (in_array($caseStatus, ['rescued', 'rehabilitated'])) {
                    Child::create([
                        'case_id'          => $case->id,
                        'name'             => ['Ravi', 'Priya', 'Ankit', 'Sunita', 'Mohan'][$i % 5] . ' ' . ['Kumar', 'Devi', 'Singh', 'Patel', 'Shah'][$i % 5],
                        'age'              => rand(7, 15),
                        'gender'           => $i % 2 === 0 ? 'male' : 'female',
                        'rescue_location'  => $complaint->location,
                        'rescue_city'      => $city,
                        'rescue_date'      => $case->rescued_at ?? now()->subDays(rand(1, 60)),
                        'school_name'      => $caseStatus === 'rehabilitated' ? 'Government Primary School, ' . $city : null,
                        'school_enrolled'  => $caseStatus === 'rehabilitated',
                        'guardian_name'    => 'Guardian ' . ($i + 1),
                        'guardian_phone'   => '98' . rand(10000000, 99999999),
                        'guardian_relation'=> ['Parent', 'Uncle', 'Grandparent'][$i % 3],
                        'health_status'    => 'Malnourished, receiving medical attention.',
                        'created_at'       => $case->rescued_at ?? now(),
                    ]);
                }
            }
        }
    }
}
