<div class="cart-page auth-page">
    <section class="shop-banner cart-banner" aria-labelledby="auth-page-title">
        <div class="cart-banner-art cart-banner-art-left" aria-hidden="true">
            <span class="cart-kid">🧒</span><span class="cart-bee">🐝</span>
        </div>
        <div class="shop-banner-copy">
            <h1 id="auth-page-title">{{ $title }}</h1>
            <nav aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a><span>›</span><span aria-current="page">{{ $title }}</span>
            </nav>
        </div>
        <div class="cart-banner-art cart-banner-art-right" aria-hidden="true">
            <span class="cart-bee">🐝</span><span class="cart-kid">👧</span>
        </div>
    </section>

    <section class="auth-content">
        <div class="auth-doodle auth-doodle-squiggle" aria-hidden="true">〰</div>
        <div class="auth-doodle auth-doodle-star" aria-hidden="true">★</div>
        <div class="auth-doodle auth-doodle-sun" aria-hidden="true">☀</div>
        <div class="auth-doodle auth-doodle-flower" aria-hidden="true">✿</div>

        <div class="auth-card">
            @if ($mode === 'login')
                <div class="auth-card-heading">
                    <span>Welcome back!</span>
                    <h2>Login Form</h2>
                    <p>Login to continue your playful journey.</p>
                </div>

                <form wire:submit="login" novalidate>
                    <div class="auth-field">
                        <label for="login-email">Email address</label>
                        <input id="login-email" type="email" wire:model.blur="email" autocomplete="email" placeholder="you@example.com" autofocus>
                        @error('email') <small>{{ $message }}</small> @enderror
                    </div>

                    <div class="auth-field" x-data="{ show: false }">
                        <label for="login-password">Password</label>
                        <div class="auth-password">
                            <input id="login-password" :type="show ? 'text' : 'password'" wire:model="password" autocomplete="current-password" placeholder="Enter your password">
                            <button type="button" @click="show = !show" :aria-label="show ? 'Hide password' : 'Show password'">
                                <span x-text="show ? 'Hide' : 'Show'"></span>
                            </button>
                        </div>
                        @error('password') <small>{{ $message }}</small> @enderror
                    </div>

                    <label class="auth-check">
                        <input type="checkbox" wire:model="remember">
                        <span>Remember me</span>
                    </label>

                    <button type="submit" class="auth-submit" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="login">Login</span>
                        <span wire:loading wire:target="login">Logging in…</span>
                    </button>
                </form>

                <p class="auth-switch">Don’t have an account? <a href="{{ route('register') }}">Register</a></p>
            @else
                <div class="auth-card-heading">
                    <span>Join the fun!</span>
                    <h2>Register Form</h2>
                    <p>Create an account for faster checkout.</p>
                </div>

                <form wire:submit="register" novalidate>
                    <div class="auth-field">
                        <label for="register-name">Full name</label>
                        <input id="register-name" type="text" wire:model.blur="name" autocomplete="name" placeholder="Enter your full name" autofocus>
                        @error('name') <small>{{ $message }}</small> @enderror
                    </div>

                    <div class="auth-field">
                        <label for="register-email">Email address</label>
                        <input id="register-email" type="email" wire:model.blur="email" autocomplete="email" placeholder="you@example.com">
                        @error('email') <small>{{ $message }}</small> @enderror
                    </div>

                    <div class="auth-field" x-data="{ show: false }">
                        <label for="register-password">Password</label>
                        <div class="auth-password">
                            <input id="register-password" :type="show ? 'text' : 'password'" wire:model="password" autocomplete="new-password" placeholder="At least 8 characters">
                            <button type="button" @click="show = !show" :aria-label="show ? 'Hide password' : 'Show password'">
                                <span x-text="show ? 'Hide' : 'Show'"></span>
                            </button>
                        </div>
                        @error('password') <small>{{ $message }}</small> @enderror
                    </div>

                    <div class="auth-field">
                        <label for="register-password-confirmation">Confirm password</label>
                        <input id="register-password-confirmation" type="password" wire:model="password_confirmation" autocomplete="new-password" placeholder="Enter your password again">
                    </div>

                    <label class="auth-check">
                        <input type="checkbox" wire:model="terms">
                        <span>I agree to the terms and privacy policy.</span>
                    </label>
                    @error('terms') <small class="auth-terms-error">{{ $message }}</small> @enderror

                    <button type="submit" class="auth-submit" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="register">Register</span>
                        <span wire:loading wire:target="register">Creating account…</span>
                    </button>
                </form>

                <p class="auth-switch">Already have an account? <a href="{{ route('login') }}">Login</a></p>
            @endif
        </div>
    </section>
</div>
