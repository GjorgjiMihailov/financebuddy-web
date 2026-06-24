<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_is_redirected_to_admin_login(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
        $this->get('/admin/blog')->assertRedirect('/admin/login');
        $this->get('/admin/poraki')->assertRedirect('/admin/login');
    }

    public function test_admin_user_can_access_dashboard(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->get('/admin')->assertOk();
    }

    public function test_editor_user_can_access_dashboard(): void
    {
        $editor = User::factory()->create(['role' => 'editor']);

        $this->actingAs($editor)->get('/admin')->assertOk();
    }

    public function test_login_with_valid_credentials_redirects_to_dashboard(): void
    {
        $admin = User::factory()->create([
            'email'    => 'gjorgji@financebuddy.mk',
            'password' => bcrypt('secret123'),
            'role'     => 'admin',
        ]);

        $this->post('/admin/login', [
            'email'    => 'gjorgji@financebuddy.mk',
            'password' => 'secret123',
        ])->assertRedirect('/admin');
    }

    public function test_login_with_invalid_credentials_returns_error(): void
    {
        User::factory()->create([
            'email'    => 'gjorgji@financebuddy.mk',
            'password' => bcrypt('correct-password'),
            'role'     => 'admin',
        ]);

        $this->post('/admin/login', [
            'email'    => 'gjorgji@financebuddy.mk',
            'password' => 'wrong-password',
        ])->assertSessionHasErrors('email');
    }

    public function test_admin_can_logout(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->post('/admin/logout')
            ->assertRedirect('/admin/login');

        $this->assertGuest();
    }
}
