<?php

namespace Tests\Feature\Admin;

use App\Models\SystemLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRoleUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_update_another_users_role(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'customer']);

        $response = $this->actingAs($admin)
            ->patch(route('admin.users.role.update', $user), ['role' => 'owner']);

        $response->assertRedirect(route('admin.users.show', $user))
            ->assertSessionHas('success', 'Cập nhật vai trò tài khoản thành công.');

        $this->assertSame('owner', $user->fresh()->role);
        $this->assertDatabaseHas('system_logs', [
            'user_id' => $admin->id,
            'action' => 'update_user_role',
            'target_type' => User::class,
            'target_id' => $user->id,
        ]);

        $log = SystemLog::query()->where('action', 'update_user_role')->firstOrFail();
        $this->assertSame('customer', $log->data['previous_role']);
        $this->assertSame('owner', $log->data['new_role']);
    }

    public function test_admin_cannot_change_their_own_role(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)
            ->from(route('admin.users.show', $admin))
            ->patch(route('admin.users.role.update', $admin), ['role' => 'customer']);

        $response->assertRedirect(route('admin.users.show', $admin))
            ->assertSessionHas('error', 'Bạn không thể tự thay đổi vai trò của mình.');
        $this->assertSame('admin', $admin->fresh()->role);
    }

    public function test_admin_cannot_assign_an_unknown_role(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'customer']);

        $response = $this->actingAs($admin)
            ->from(route('admin.users.show', $user))
            ->patch(route('admin.users.role.update', $user), ['role' => 'superadmin']);

        $response->assertRedirect(route('admin.users.show', $user))
            ->assertSessionHasErrors('role');
        $this->assertSame('customer', $user->fresh()->role);
    }

    public function test_non_admin_cannot_update_a_users_role(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $user = User::factory()->create(['role' => 'owner']);

        $this->actingAs($customer)
            ->patch(route('admin.users.role.update', $user), ['role' => 'admin'])
            ->assertForbidden();

        $this->assertSame('owner', $user->fresh()->role);
    }
}
