<?php

namespace Tests\Feature;

use App\Livewire\AuthPage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AuthPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_and_register_pages_are_available(): void
    {
        $this->get('/login')->assertOk()->assertSee('Login Form');
        $this->get('/register')->assertOk()->assertSee('Register Form');
    }

    public function test_customer_can_register(): void
    {
        Livewire::test(AuthPage::class, ['mode' => 'register'])
            ->set('name', 'Ayesha Khan')
            ->set('email', 'ayesha@example.com')
            ->set('password', 'playtime123')
            ->set('password_confirmation', 'playtime123')
            ->set('terms', true)
            ->call('register')
            ->assertHasNoErrors()
            ->assertRedirect(route('home'));

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['email' => 'ayesha@example.com']);
    }

    public function test_customer_can_login(): void
    {
        $user = User::factory()->create(['password' => 'playtime123']);

        Livewire::test(AuthPage::class, ['mode' => 'login'])
            ->set('email', $user->email)
            ->set('password', 'playtime123')
            ->set('remember', true)
            ->call('login')
            ->assertHasNoErrors()
            ->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($user);
    }
}
