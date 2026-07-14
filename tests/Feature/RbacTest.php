<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RbacTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $editor;
    private User $viewer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->editor = User::factory()->create(['role' => 'editor']);
        $this->viewer = User::factory()->create(['role' => 'viewer']);
    }

    public function test_admin_can_access_admin_routes(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/users');
        $response->assertStatus(200);
    }

    public function test_editor_cannot_access_admin_routes(): void
    {
        $response = $this->actingAs($this->editor)->get('/admin/users');
        $response->assertStatus(403);
    }

    public function test_viewer_cannot_access_admin_routes(): void
    {
        $response = $this->actingAs($this->viewer)->get('/admin/users');
        $response->assertStatus(403);
    }

    public function test_admin_can_create_user(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/users', [
            'name' => 'Novo Usuario',
            'email' => 'novo@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'viewer',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', ['email' => 'novo@example.com']);
    }

    public function test_editor_cannot_create_user(): void
    {
        $response = $this->actingAs($this->editor)->post('/admin/users', [
            'name' => 'Novo Usuario',
            'email' => 'novo@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'viewer',
        ]);

        $response->assertStatus(403);
    }

    public function test_admin_cannot_delete_self(): void
    {
        $response = $this->actingAs($this->admin)->delete("/admin/users/{$this->admin->id}");
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $this->admin->id]);
    }

    public function test_admin_can_update_user_role(): void
    {
        $response = $this->actingAs($this->admin)->put("/admin/users/{$this->viewer->id}/role", [
            'role' => 'editor',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'id' => $this->viewer->id,
            'role' => 'editor',
        ]);
    }

    public function test_viewer_can_access_dashboard(): void
    {
        $response = $this->actingAs($this->viewer)->get('/dashboard');
        $response->assertStatus(200);
    }

    public function test_viewer_can_access_settings(): void
    {
        $response = $this->actingAs($this->viewer)->get('/settings');
        $response->assertStatus(200);
    }
}
