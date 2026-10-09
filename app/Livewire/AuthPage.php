<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class AuthPage extends Component
{
    public string $mode = 'login';

    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public bool $remember = false;

    public bool $terms = false;

    public function mount(string $mode = 'login'): void
    {
        $this->mode = $mode === 'register' ? 'register' : 'login';
    }

    public function login()
    {
        $credentials = $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $this->remember)) {
            $this->addError('email', 'These login details do not match our records.');
            return null;
        }

        session()->regenerate();

        return redirect()->route('home');
    }

    public function register()
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'terms' => ['accepted'],
        ], [
            'terms.accepted' => 'Please agree to the terms to create your account.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        Auth::login($user);
        session()->regenerate();

        return redirect()->route('home');
    }

    public function render()
    {
        $title = $this->mode === 'register' ? 'Register' : 'Login';

        return view('livewire.auth-page', compact('title'))->layout('layouts.app', [
            'title' => $title.' — Mini Marvels',
            'metaDescription' => $title.' to your Mini Marvels account.',
        ]);
    }
}
