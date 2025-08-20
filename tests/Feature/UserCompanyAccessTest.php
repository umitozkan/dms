<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Dubbing;
use App\Models\Show;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCompanyAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Seed test data
        $this->seed(\Database\Seeders\CompanySeeder::class);
        $this->seed(\Database\Seeders\UserSeeder::class);
        
        // Create test language and studio for dubbing tests
        \App\Models\Language::create(['name' => 'English']);
        \App\Models\Studio::create(['name' => 'Test Studio']);
    }

    /** @test */
    public function admin_user_can_access_any_company()
    {
        $admin = User::where('role', 'admin')->first();
        $company1 = Company::find(1);
        $company2 = Company::find(2);

        // Test with company ID
        $this->assertTrue($admin->canAccessCompany(1));
        $this->assertTrue($admin->canAccessCompany(2));

        // Test with company model
        $this->assertTrue($admin->canAccessCompany($company1));
        $this->assertTrue($admin->canAccessCompany($company2));

        // Test with null
        $this->assertTrue($admin->canAccessCompany(null));
    }

    /** @test */
    public function non_admin_user_can_only_access_their_own_company()
    {
        $editor = User::where('email', 'editor@dogus.com')->first(); // company_id = 1
        $viewer = User::where('email', 'viewer@nowtv.com')->first(); // company_id = 2

        // Editor can access their own company
        $this->assertTrue($editor->canAccessCompany(1));
        $this->assertFalse($editor->canAccessCompany(2));
        $this->assertFalse($editor->canAccessCompany(3));

        // Viewer can access their own company
        $this->assertTrue($viewer->canAccessCompany(2));
        $this->assertFalse($viewer->canAccessCompany(1));
        $this->assertFalse($viewer->canAccessCompany(3));
    }

    /** @test */
    public function user_without_company_cannot_access_any_company()
    {
        // Create a user without company assignment
        $userWithoutCompany = User::create([
            'name' => 'No Company User',
            'email' => 'nocompany@test.com',
            'password' => bcrypt('password'),
            'role' => 'editor',
            'company_id' => null,
        ]);

        $this->assertFalse($userWithoutCompany->canAccessCompany(1));
        $this->assertFalse($userWithoutCompany->canAccessCompany(2));
        $this->assertFalse($userWithoutCompany->canAccessCompany(null));
        $this->assertFalse($userWithoutCompany->canAccessCompany(0));
    }

    /** @test */
    public function can_access_company_data_method_works_correctly()
    {
        $admin = User::where('role', 'admin')->first();
        $editor = User::where('email', 'editor@dogus.com')->first();

        $this->assertTrue($admin->canAccessCompanyData(1));
        $this->assertTrue($admin->canAccessCompanyData(2));

        $this->assertTrue($editor->canAccessCompanyData(1));
        $this->assertFalse($editor->canAccessCompanyData(2));
    }

    /** @test */
    public function get_accessible_company_ids_returns_correct_ids()
    {
        $admin = User::where('role', 'admin')->first();
        $editor = User::where('email', 'editor@dogus.com')->first();

        // Admin should get null (indicating access to all companies)
        $adminCompanyIds = $admin->getAccessibleCompanyIds();
        $this->assertNull($adminCompanyIds);

        // Editor should only get their company ID
        $editorCompanyIds = $editor->getAccessibleCompanyIds();
        $this->assertCount(1, $editorCompanyIds);
        $this->assertEquals([1], $editorCompanyIds);
    }

    /** @test */
    public function user_scope_for_user_company_filters_correctly()
    {
        $admin = User::where('role', 'admin')->first();
        $editor = User::where('email', 'editor@dogus.com')->first();

        // Admin should see all users
        $adminUsers = User::query()->forUserCompany($admin)->get();
        $this->assertCount(7, $adminUsers); // All 7 users from seeder

        // Editor should only see users from their company
        $editorUsers = User::query()->forUserCompany($editor)->get();
        $this->assertCount(2, $editorUsers); // Only users with company_id = 1
        $this->assertTrue($editorUsers->every(fn($user) => $user->company_id === 1));
    }

    /** @test */
    public function user_scope_accessible_by_user_works_correctly()
    {
        $admin = User::where('role', 'admin')->first();
        $editor = User::where('email', 'editor@dogus.com')->first();

        // Admin should see all users
        $adminUsers = User::query()->accessibleByUser($admin)->get();
        $this->assertCount(7, $adminUsers); // All 7 users from seeder

        // Editor should only see users from their company
        $editorUsers = User::query()->accessibleByUser($editor)->get();
        $this->assertCount(2, $editorUsers); // Only users with company_id = 1
        $this->assertTrue($editorUsers->every(fn($user) => $user->company_id === 1));
    }

    /** @test */
    public function company_scope_accessible_by_user_works_correctly()
    {
        $admin = User::where('role', 'admin')->first();
        $editor = User::where('email', 'editor@dogus.com')->first();

        // Admin should see all companies
        $adminCompanies = Company::query()->accessibleByUser($admin)->get();
        $this->assertCount(9, $adminCompanies);

        // Editor should only see their company
        $editorCompanies = Company::query()->accessibleByUser($editor)->get();
        $this->assertCount(1, $editorCompanies);
        $this->assertEquals(1, $editorCompanies->first()->id);
    }

    /** @test */
    public function company_is_accessible_by_user_method_works()
    {
        $admin = User::where('role', 'admin')->first();
        $editor = User::where('email', 'editor@dogus.com')->first();
        $company1 = Company::find(1);
        $company2 = Company::find(2);

        $this->assertTrue($company1->isAccessibleByUser($admin));
        $this->assertTrue($company2->isAccessibleByUser($admin));

        $this->assertTrue($company1->isAccessibleByUser($editor));
        $this->assertFalse($company2->isAccessibleByUser($editor));
    }

    /** @test */
    public function show_scope_accessible_by_user_filters_by_company()
    {
        // Create test shows
        $show1 = Show::create([
            'company_id' => 1,
            'channelId' => 'CH001',
            'name' => 'Test Show 1',
            'type' => 'series',
            'total_episode' => 10,
            'total_duration' => 600,
        ]);

        $show2 = Show::create([
            'company_id' => 2,
            'channelId' => 'CH002',
            'name' => 'Test Show 2',
            'type' => 'movie',
            'total_episode' => 1,
            'total_duration' => 120,
        ]);

        $admin = User::where('role', 'admin')->first();
        $editor = User::where('email', 'editor@dogus.com')->first();

        // Admin should see all shows
        $adminShows = Show::query()->accessibleByUser($admin)->get();
        $this->assertCount(2, $adminShows);

        // Editor should only see shows from their company
        $editorShows = Show::query()->accessibleByUser($editor)->get();
        $this->assertCount(1, $editorShows);
        $this->assertEquals($show1->id, $editorShows->first()->id);
    }

    /** @test */
    public function show_is_accessible_by_user_method_works()
    {
        $show1 = Show::create([
            'company_id' => 1,
            'channelId' => 'CH001',
            'name' => 'Test Show 1',
            'type' => 'series',
            'total_episode' => 10,
            'total_duration' => 600,
        ]);

        $show2 = Show::create([
            'company_id' => 2,
            'channelId' => 'CH002',
            'name' => 'Test Show 2',
            'type' => 'movie',
            'total_episode' => 1,
            'total_duration' => 120,
        ]);

        $admin = User::where('role', 'admin')->first();
        $editor = User::where('email', 'editor@dogus.com')->first();

        $this->assertTrue($show1->isAccessibleByUser($admin));
        $this->assertTrue($show2->isAccessibleByUser($admin));

        $this->assertTrue($show1->isAccessibleByUser($editor));
        $this->assertFalse($show2->isAccessibleByUser($editor));
    }

    /** @test */
    public function dubbing_scope_accessible_by_user_filters_through_show_relationship()
    {
        // Create test shows and dubbings
        $show1 = Show::create([
            'company_id' => 1,
            'channelId' => 'CH001',
            'name' => 'Test Show 1',
            'type' => 'series',
            'total_episode' => 10,
            'total_duration' => 600,
        ]);

        $show2 = Show::create([
            'company_id' => 2,
            'channelId' => 'CH002',
            'name' => 'Test Show 2',
            'type' => 'movie',
            'total_episode' => 1,
            'total_duration' => 120,
        ]);

        $dubbing1 = Dubbing::create([
            'show_id' => $show1->id,
            'language_id' => 1,
            'studio_id' => 1,
            'duration' => 120,
            'price' => 1000.00,
            'merzigo_cost' => 800.00,
            'received_episodes' => 5,
            'downloaded_episodes' => 3,
            'published_episodes' => 2,
            'status' => 'material_waiting',
        ]);

        $dubbing2 = Dubbing::create([
            'show_id' => $show2->id,
            'language_id' => 1,
            'studio_id' => 1,
            'duration' => 120,
            'price' => 1000.00,
            'merzigo_cost' => 800.00,
            'received_episodes' => 5,
            'downloaded_episodes' => 3,
            'published_episodes' => 2,
            'status' => 'material_waiting',
        ]);

        $admin = User::where('role', 'admin')->first();
        $editor = User::where('email', 'editor@dogus.com')->first();

        // Admin should see all dubbings
        $adminDubbings = Dubbing::query()->accessibleByUser($admin)->get();
        $this->assertCount(2, $adminDubbings);

        // Editor should only see dubbings from their company's shows
        $editorDubbings = Dubbing::query()->accessibleByUser($editor)->get();
        $this->assertCount(1, $editorDubbings);
        $this->assertEquals($dubbing1->id, $editorDubbings->first()->id);
    }

    /** @test */
    public function dubbing_is_accessible_by_user_method_works()
    {
        $show1 = Show::create([
            'company_id' => 1,
            'channelId' => 'CH001',
            'name' => 'Test Show 1',
            'type' => 'series',
            'total_episode' => 10,
            'total_duration' => 600,
        ]);

        $show2 = Show::create([
            'company_id' => 2,
            'channelId' => 'CH002',
            'name' => 'Test Show 2',
            'type' => 'movie',
            'total_episode' => 1,
            'total_duration' => 120,
        ]);

        $dubbing1 = Dubbing::create([
            'show_id' => $show1->id,
            'language_id' => 1,
            'studio_id' => 1,
            'duration' => 120,
            'price' => 1000.00,
            'merzigo_cost' => 800.00,
            'received_episodes' => 5,
            'downloaded_episodes' => 3,
            'published_episodes' => 2,
            'status' => 'material_waiting',
        ]);

        $dubbing2 = Dubbing::create([
            'show_id' => $show2->id,
            'language_id' => 1,
            'studio_id' => 1,
            'duration' => 120,
            'price' => 1000.00,
            'merzigo_cost' => 800.00,
            'received_episodes' => 5,
            'downloaded_episodes' => 3,
            'published_episodes' => 2,
            'status' => 'material_waiting',
        ]);

        $admin = User::where('role', 'admin')->first();
        $editor = User::where('email', 'editor@dogus.com')->first();

        $this->assertTrue($dubbing1->isAccessibleByUser($admin));
        $this->assertTrue($dubbing2->isAccessibleByUser($admin));

        $this->assertTrue($dubbing1->isAccessibleByUser($editor));
        $this->assertFalse($dubbing2->isAccessibleByUser($editor));
    }

    /** @test */
    public function dubbing_company_accessor_returns_company_through_show()
    {
        $show = Show::create([
            'company_id' => 1,
            'channelId' => 'CH001',
            'name' => 'Test Show',
            'type' => 'series',
            'total_episode' => 10,
            'total_duration' => 600,
        ]);

        $dubbing = Dubbing::create([
            'show_id' => $show->id,
            'language_id' => 1,
            'studio_id' => 1,
            'duration' => 120,
            'price' => 1000.00,
            'merzigo_cost' => 800.00,
            'received_episodes' => 5,
            'downloaded_episodes' => 3,
            'published_episodes' => 2,
            'status' => 'material_waiting',
        ]);

        $this->assertEquals($show->company, $dubbing->company);
        $this->assertEquals(1, $dubbing->company->id);
    }

    /** @test */
    public function edge_cases_are_handled_correctly()
    {
        // Test with invalid company ID
        $editor = User::where('email', 'editor@dogus.com')->first();
        $this->assertFalse($editor->canAccessCompany(999));

        // Test with string company ID
        $this->assertTrue($editor->canAccessCompany('1'));
        $this->assertFalse($editor->canAccessCompany('2'));

        // Test with zero company ID
        $this->assertFalse($editor->canAccessCompany(0));
        
        // Test with scientific notation (should be rejected)
        $this->assertFalse($editor->canAccessCompany('1e3'));
        $this->assertFalse($editor->canAccessCompany('1.5e2'));
    }

    /** @test */
    public function non_admin_user_without_company_cannot_access_company_zero()
    {
        // Create a user without company assignment
        $userWithoutCompany = User::create([
            'name' => 'No Company User',
            'email' => 'nocompany@test.com',
            'password' => bcrypt('password'),
            'role' => 'editor',
            'company_id' => null,
        ]);

        // Non-admin user with null company_id should not be able to access company 0
        $this->assertFalse($userWithoutCompany->canAccessCompany(0));
    }
}
