<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeTest extends TestCase
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

    public function test_admin_can_view_employees_index(): void
    {
        $response = $this->actingAs($this->admin)->get('/employees');
        $response->assertStatus(200);
    }

    public function test_editor_can_view_employees_index(): void
    {
        $response = $this->actingAs($this->editor)->get('/employees');
        $response->assertStatus(200);
    }

    public function test_viewer_cannot_view_employees_index(): void
    {
        $response = $this->actingAs($this->viewer)->get('/employees');
        $response->assertStatus(403);
    }

    public function test_admin_can_create_employee(): void
    {
        $response = $this->actingAs($this->admin)->post('/employees', [
            'nome' => 'João Silva',
            'matricula' => 'MAT-00001',
            'status' => 'ativo',
        ]);

        $response->assertRedirect('/employees');
        $this->assertDatabaseHas('employees', ['nome' => 'João Silva']);
    }

    public function test_editor_can_create_employee(): void
    {
        $response = $this->actingAs($this->editor)->post('/employees', [
            'nome' => 'Maria Santos',
            'status' => 'ativo',
        ]);

        $response->assertRedirect('/employees');
        $this->assertDatabaseHas('employees', ['nome' => 'Maria Santos']);
    }

    public function test_viewer_cannot_create_employee(): void
    {
        $response = $this->actingAs($this->viewer)->post('/employees', [
            'nome' => 'Pedro Costa',
            'status' => 'ativo',
        ]);

        $response->assertStatus(403);
    }

    public function test_admin_can_update_employee(): void
    {
        $employee = Employee::factory()->create();

        $response = $this->actingAs($this->admin)->put("/employees/{$employee->id}", [
            'nome' => 'Nome Atualizado',
            'status' => 'ativo',
        ]);

        $response->assertRedirect('/employees');
        $this->assertDatabaseHas('employees', [
            'id' => $employee->id,
            'nome' => 'Nome Atualizado',
        ]);
    }

    public function test_admin_can_delete_employee(): void
    {
        $employee = Employee::factory()->create();

        $response = $this->actingAs($this->admin)->delete("/employees/{$employee->id}");
        $response->assertRedirect('/employees');
        $this->assertDatabaseMissing('employees', ['id' => $employee->id]);
    }

    public function test_employee_validation_requires_name(): void
    {
        $response = $this->actingAs($this->admin)->post('/employees', [
            'status' => 'ativo',
        ]);

        $response->assertSessionHasErrors('nome');
    }
}
