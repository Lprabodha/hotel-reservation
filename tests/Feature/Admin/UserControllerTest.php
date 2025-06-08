<?php
namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        Role::create(['name' => 'super-admin']);
        Role::create(['name' => 'customer']);
        
        $this->user = User::factory()->create();
        $this->user->assignRole('super-admin');
        $this->actingAs($this->user);
    }

    #[Test]
    public function it_can_access_users_index()
    {
        $response = $this->get(route('admin.users.index'));
        
        $this->assertNotEquals(404, $response->getStatusCode());
        $this->assertNotEquals(500, $response->getStatusCode());
    }

    #[Test]
    public function it_can_access_user_roles_route()
    {
        $response = $this->get(route('admin.users.role.index'));
        
        $this->assertNotEquals(404, $response->getStatusCode());
        $this->assertNotEquals(500, $response->getStatusCode());
    }

    #[Test]
    public function it_can_access_delete_user_route()
    {
        $testUser = User::factory()->create();
        
        $response = $this->post(route('admin.users.delete'), [
            'id' => $testUser->id,
        ]);

        $this->assertNotEquals(404, $response->getStatusCode());
        $this->assertNotEquals(500, $response->getStatusCode());
    }

    #[Test]
    public function it_can_access_user_profile_route()
    {
        $response = $this->get(route('admin.users.view.profile'));
        
        $this->assertNotEquals(404, $response->getStatusCode());
        $this->assertNotEquals(500, $response->getStatusCode());
    }

    #[Test]
    public function it_can_access_change_user_role_route()
    {
        $testUser = User::factory()->create();
        $role = Role::create(['name' => 'admin']);
        
        $response = $this->post(route('admin.users.role.change'), [
            'id' => $testUser->id,
            'role_id' => $role->id,
        ]);

        $this->assertNotEquals(404, $response->getStatusCode());
        $this->assertNotEquals(500, $response->getStatusCode());
    }
}