<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Ngo;
use App\Models\Complaint;
use App\Models\ChildCase;
use App\Models\Child;

class SystemFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_full_system_lifecycle_works_perfectly()
    {
        // 1. PUBLIC MODULE: Submit a new complaint
        $response = $this->post('/complaint', [
            'type'        => 'Factory / Industrial',
            'count'       => '3',
            'urgency'     => 'Urgent',
            'location'    => 'Sector 4, Noida',
            'city'        => 'Noida',
            'description' => 'I saw three children working in a hazardous glass factory under terrible conditions.',
            'reporter_name' => 'John Doe',
        ]);

        $response->assertStatus(302);
        
        $complaint = Complaint::first();
        $this->assertNotNull($complaint);
        $this->assertEquals('pending', $complaint->status);
        $this->assertStringContainsString('Factory / Industrial', $complaint->description);

        // Track the complaint
        $trackResponse = $this->get("/complaint/track?tracking_id={$complaint->tracking_id}");
        $trackResponse->assertStatus(200);
        $trackResponse->assertSee($complaint->tracking_id);
        $trackResponse->assertSee('PENDING');

        // Setup Users
        $admin = User::create([
            'name'     => 'Admin',
            'email'    => 'admin@example.com',
            'password' => bcrypt('password'),
            'role'     => 'admin',
        ]);

        $ngoOrg = Ngo::create([
            'name'           => 'Test NGO',
            'contact_person' => 'Jane Doe',
            'email'          => 'contact@testngo.org',
            'phone'          => '1234567890',
            'address'        => '123 Test St',
            'city'           => 'Test City',
            'state'          => 'Test State',
            'is_active'      => true,
        ]);

        $ngoUser = User::create([
            'name'     => 'NGO Worker',
            'email'    => 'ngo@example.com',
            'password' => bcrypt('password'),
            'role'     => 'ngo',
            'ngo_id'   => $ngoOrg->id,
        ]);

        // 2. ADMIN MODULE: Approve Complaint & Assign NGO
        $this->actingAs($admin);
        
        $dashboard = $this->get(route('admin.dashboard'));
        $dashboard->assertStatus(200);

        // Approve the complaint
        $approveRes = $this->post(route('admin.complaints.approve', $complaint), [
            'admin_notes' => 'Valid complaint, creating case.'
        ]);
        
        $complaint->refresh();
        $this->assertEquals('approved', $complaint->status);
        $this->assertNotNull($complaint->case_id);

        $case = ChildCase::find($complaint->case_id);
        $this->assertNotNull($case);
        $this->assertEquals('pending', $case->status);

        // Assign the case to NGO
        $assignRes = $this->post(route('admin.cases.assign-ngo', $case), [
            'ngo_id'           => $ngoOrg->id,
            'assigned_to_type' => 'ngo'
        ]);

        $case->refresh();
        $this->assertEquals($ngoOrg->id, $case->assigned_ngo_id);
        $this->assertEquals('under_investigation', $case->status);

        // 3. NGO MODULE: Update Progress & Register Child
        $this->actingAs($ngoUser);

        $ngoDash = $this->get(route('ngo.dashboard'));
        $ngoDash->assertStatus(200);
        $ngoDash->assertSee($case->case_number);

        // Progress Update
        $updateRes = $this->post(route('ngo.cases.update', $case), [
            'status' => 'rescued',
            'note'   => 'We successfully located the factory and rescued the children with police help.'
        ]);

        $case->refresh();
        $this->assertEquals('rescued', $case->status);
        $this->assertEquals(2, $case->updates()->count()); // 1 for assign, 1 for update

        // Register Child
        $childRes = $this->post(route('ngo.cases.add-child', $case), [
            'name'          => 'Unknown Boy 1',
            'age'           => 12,
            'gender'        => 'male',
            'rescue_city'   => 'Noida',
            'rescue_date'   => now()->format('Y-m-d'),
            'health_status' => 'Under Observation'
        ]);

        $this->assertDatabaseHas('children', [
            'case_id' => $case->id,
            'name'    => 'Unknown Boy 1',
        ]);

        // Submit a Story of Hope
        $storyRes = $this->post(route('ngo.stories.store', $case), [
            'content' => 'This is a brave story of Unknown Boy 1 being rescued from a hazardous environment.'
        ]);
        
        $this->assertDatabaseHas('stories', [
            'case_id' => $case->id,
            'status' => 'pending'
        ]);

        // 4. ADMIN MODULE: Review Story & Impact Dashboard
        $this->actingAs($admin);

        // Approve the story
        $story = \App\Models\Story::first();
        $this->post(route('admin.stories.approve', $story));
        
        $this->assertDatabaseHas('stories', [
            'id' => $story->id,
            'status' => 'approved'
        ]);

        // Verify Admin Analytics renders without error with the new data
        $analytics = $this->get(route('admin.analytics'));
        $analytics->assertStatus(200);

        // Verify Impact Dashboard
        $impact = $this->get(route('admin.impact'));
        $impact->assertStatus(200);
        $impact->assertSee('Total Children Rescued');

        // 5. PUBLIC MODULE: View Stories of Hope
        $this->post('/logout'); // Log out admin
        
        $publicStories = $this->get(route('stories.index'));
        $publicStories->assertStatus(200);
        $publicStories->assertSee('This is a brave story');
    }
}
