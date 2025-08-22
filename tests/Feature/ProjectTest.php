<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_admin_can_create_project()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $member = User::factory()->create(['role' => 'member']);

        $payload = ['title' => 'New Project'];

        // member fails
        $this->actingAs($member, 'api')
            ->postJson('/api/projects', $payload)
            ->assertStatus(403);

        // admin success
        $this->actingAs($admin, 'api')
            ->postJson('/api/projects', $payload)
            ->assertStatus(201)
            ->assertJsonFragment(['title' => 'New Project']);
    }
}
