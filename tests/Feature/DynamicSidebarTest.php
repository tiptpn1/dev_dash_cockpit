<?php

namespace Tests\Feature;

use App\Models\CustomUser;
use App\Models\Feature;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class DynamicSidebarTest extends TestCase
{
    use DatabaseTransactions;

    public function test_has_feature_resolves_via_database_relations(): void
    {
        // 1. Clear any cached feature mappings
        Cache::forget('feature_parent_mapping');

        // 2. Create test user
        $user = CustomUser::create([
            'username' => 'testuser_sidebar',
            'name' => 'Test User Sidebar',
            'email' => 'testuser_sidebar@example.com',
            'password' => bcrypt('password'),
        ]);

        // 3. Create parent and child feature
        $parent = Feature::create([
            'slug' => 'test_parent',
            'name' => 'Test Parent',
            'is_sidebar' => true,
            'is_active' => true,
        ]);

        $child = Feature::create([
            'slug' => 'test_child',
            'name' => 'Test Child',
            'parent_id' => $parent->id,
            'is_sidebar' => true,
            'is_active' => true,
        ]);

        // 4. Assign child feature to user
        $user->features()->attach($child->id);

        // 5. Test hasFeature logic
        // User should have the child feature
        $this->assertTrue($user->hasFeature('test_child'));

        // User should also have the parent feature because they have the child
        $this->assertTrue($user->hasFeature('test_parent'));

        // User should not have non-existent feature
        $this->assertFalse($user->hasFeature('non_existent_feature'));
    }

    public function test_cache_is_cleared_on_feature_changes(): void
    {
        // Create parent
        $parent = Feature::create([
            'slug' => 'test_parent_cache',
            'name' => 'Test Parent Cache',
            'is_sidebar' => true,
            'is_active' => true,
        ]);

        // Trigger cache generation
        $user = new CustomUser();
        $user->hasFeature('test_parent_cache');

        // Assert cache is populated
        $this->assertTrue(Cache::has('feature_parent_mapping'));

        // Update parent feature to trigger model booted hook
        $parent->update(['name' => 'Updated Parent Name']);

        // Assert cache was successfully cleared
        $this->assertFalse(Cache::has('feature_parent_mapping'));
    }

    public function test_create_and_update_feature_via_management_routes(): void
    {
        // 1. Create a user with management_features access
        $user = CustomUser::create([
            'username' => 'test_admin_manager',
            'name' => 'Admin Manager',
            'email' => 'admin_manager@example.com',
            'password' => bcrypt('password'),
        ]);

        $mgmtFeature = Feature::firstOrCreate(
            ['slug' => 'management_features'],
            [
                'name' => 'Feature Management',
                'is_sidebar' => true,
                'is_active' => true,
            ]
        );

        $user->features()->attach($mgmtFeature->id);

        // 2. Perform GET /management/features/create
        $response = $this->actingAs($user, 'custom')->get(route('management.features.create'));
        $response->assertStatus(200);
        $response->assertSee('Parent Feature (Menu Induk)');

        // 3. Create a parent feature first to test select parenting
        $parentFeature = Feature::create([
            'slug' => 'sample_parent',
            'name' => 'Sample Parent',
            'is_sidebar' => true,
            'is_active' => true,
        ]);

        // 4. POST /management/features to store a new child feature
        $storeResponse = $this->actingAs($user, 'custom')->post(route('management.features.store'), [
            'slug' => 'sample_child',
            'name' => 'Sample Child',
            'parent_id' => $parentFeature->id,
            'url' => '/sample/child',
            'icon' => 'fa-solid fa-star',
            'sort_order' => 12,
            'is_sidebar' => 1,
            'is_active' => 1,
        ]);

        $storeResponse->assertRedirect(route('management.features.index'));

        // Assert database has the child feature with exact attributes
        $this->assertDatabaseHas('features', [
            'slug' => 'sample_child',
            'parent_id' => $parentFeature->id,
            'url' => '/sample/child',
            'icon' => 'fa-solid fa-star',
            'sort_order' => 12,
            'is_sidebar' => 1,
            'is_active' => 1,
        ]);

        $childFeature = Feature::where('slug', 'sample_child')->first();

        // 5. GET /management/features/{feature}/edit
        $editResponse = $this->actingAs($user, 'custom')->get(route('management.features.edit', $childFeature));
        $editResponse->assertStatus(200);
        $editResponse->assertSee('Sample Child');

        // 6. PUT /management/features/{feature} to update the feature
        $updateResponse = $this->actingAs($user, 'custom')->put(route('management.features.update', $childFeature), [
            'slug' => 'sample_child',
            'name' => 'Updated Sample Child',
            'parent_id' => null,
            'url' => 'https://external-site.com',
            'icon' => 'fa-solid fa-heart',
            'sort_order' => 45,
            'is_sidebar' => 0,
            'is_active' => 0,
        ]);

        $updateResponse->assertRedirect(route('management.features.index'));

        // Assert database contains the updated values
        $this->assertDatabaseHas('features', [
            'slug' => 'sample_child',
            'name' => 'Updated Sample Child',
            'parent_id' => null,
            'url' => 'https://external-site.com',
            'icon' => 'fa-solid fa-heart',
            'sort_order' => 45,
            'is_sidebar' => 0,
            'is_active' => 0,
        ]);
    }
}
