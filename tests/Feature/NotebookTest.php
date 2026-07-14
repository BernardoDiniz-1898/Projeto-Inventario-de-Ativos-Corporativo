<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\Notebook;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotebookTest extends TestCase
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

    public function test_admin_can_view_notebooks_index(): void
    {
        $response = $this->actingAs($this->admin)->get('/notebooks');
        $response->assertStatus(200);
    }

    public function test_editor_can_view_notebooks_index(): void
    {
        $response = $this->actingAs($this->editor)->get('/notebooks');
        $response->assertStatus(200);
    }

    public function test_viewer_cannot_view_notebooks_index(): void
    {
        $response = $this->actingAs($this->viewer)->get('/notebooks');
        $response->assertStatus(403);
    }

    public function test_admin_can_create_notebook(): void
    {
        $employee = Employee::factory()->create();

        $response = $this->actingAs($this->admin)->post('/notebooks', [
            'marca' => 'Dell',
            'modelo' => 'Latitude 5540',
            'numero_serie' => 'SN-12345',
            'status' => 'disponivel',
            'funcionario_id' => $employee->id,
        ]);

        $response->assertRedirect('/notebooks');
        $this->assertDatabaseHas('notebooks', ['numero_serie' => 'SN-12345']);
    }

    public function test_editor_can_create_notebook(): void
    {
        $response = $this->actingAs($this->editor)->post('/notebooks', [
            'marca' => 'Lenovo',
            'modelo' => 'ThinkPad E14',
            'numero_serie' => 'SN-67890',
            'status' => 'disponivel',
        ]);

        $response->assertRedirect('/notebooks');
        $this->assertDatabaseHas('notebooks', ['numero_serie' => 'SN-67890']);
    }

    public function test_viewer_cannot_create_notebook(): void
    {
        $response = $this->actingAs($this->viewer)->post('/notebooks', [
            'marca' => 'HP',
            'modelo' => 'ProBook',
            'numero_serie' => 'SN-99999',
            'status' => 'disponivel',
        ]);

        $response->assertStatus(403);
    }

    public function test_admin_can_update_notebook(): void
    {
        $notebook = Notebook::factory()->create();

        $response = $this->actingAs($this->admin)->put("/notebooks/{$notebook->id}", [
            'marca' => 'Dell',
            'modelo' => 'Latitude 7440',
            'numero_serie' => $notebook->numero_serie,
            'status' => 'manutencao',
        ]);

        $response->assertRedirect('/notebooks');
        $this->assertDatabaseHas('notebooks', [
            'id' => $notebook->id,
            'status' => 'manutencao',
        ]);
    }

    public function test_admin_can_delete_notebook(): void
    {
        $notebook = Notebook::factory()->create();

        $response = $this->actingAs($this->admin)->delete("/notebooks/{$notebook->id}");
        $response->assertRedirect('/notebooks');
        $this->assertDatabaseMissing('notebooks', ['id' => $notebook->id]);
    }

    public function test_notebook_validation_requires_unique_serial(): void
    {
        Notebook::factory()->create(['numero_serie' => 'SN-EXISTING']);

        $response = $this->actingAs($this->admin)->post('/notebooks', [
            'marca' => 'Dell',
            'modelo' => 'Latitude',
            'numero_serie' => 'SN-EXISTING',
            'status' => 'disponivel',
        ]);

        $response->assertSessionHasErrors('numero_serie');
    }
}
