<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_or_admin_can_update_task()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $owner = User::factory()->create(['role' => 'member']);
        $other = User::factory()->create(['role' => 'member']);

        $project = Project::create(['title' => 'P']);
        $task = Task::create([
            'project_id' => $project->id,
            'title' => 'T',
            'owner_id' => $owner->id
        ]);

        // other cannot update
        $this->actingAs($other, 'api')
            ->putJson("/api/tasks/{$task->id}", ['title' => 'New'])
            ->assertStatus(403);

        // owner can update
        $this->actingAs($owner, 'api')
            ->putJson("/api/tasks/{$task->id}", ['title' => 'By Owner'])
            ->assertStatus(200)
            ->assertJsonFragment(['title' => 'By Owner']);

        // admin can update
        $this->actingAs($admin, 'api')
            ->putJson("/api/tasks/{$task->id}", ['title' => 'By Admin'])
            ->assertStatus(200)
            ->assertJsonFragment(['title' => 'By Admin']);
    }
}
