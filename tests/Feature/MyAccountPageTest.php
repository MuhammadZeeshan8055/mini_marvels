<?php

namespace Tests\Feature;

use App\Livewire\MyAccountPage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class MyAccountPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get('/my-account')->assertRedirect(route('login'));
    }

    public function test_customer_can_view_their_account(): void
    {
        $user = User::factory()->create(['name' => 'Ayesha Khan']);

        $this->actingAs($user)
            ->get('/my-account')
            ->assertOk()
            ->assertSee('Hello, Ayesha!')
            ->assertSee('Account Details');
    }

    public function test_customer_can_update_account_details(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(MyAccountPage::class)
            ->set('name', 'Ayesha Khan')
            ->set('email', 'ayesha@example.com')
            ->call('updateProfile')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Ayesha Khan',
            'email' => 'ayesha@example.com',
        ]);
    }

    public function test_customer_can_change_password_and_logout(): void
    {
        $user = User::factory()->create(['password' => 'old-password']);

        Livewire::actingAs($user)
            ->test(MyAccountPage::class)
            ->set('current_password', 'old-password')
            ->set('password', 'new-password')
            ->set('password_confirmation', 'new-password')
            ->call('updatePassword')
            ->assertHasNoErrors();

        $this->assertTrue(Hash::check('new-password', $user->fresh()->password));

        Livewire::actingAs($user)
            ->test(MyAccountPage::class)
            ->call('logout')
            ->assertRedirect(route('home'));

        $this->assertGuest();
    }
}
