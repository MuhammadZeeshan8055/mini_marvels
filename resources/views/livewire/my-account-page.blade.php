<div class="account-page" x-data="{ tab: 'dashboard' }">
    <section class="shop-banner cart-banner" aria-labelledby="account-page-title">
        <div class="cart-banner-art cart-banner-art-left" aria-hidden="true">
            <span class="cart-kid">🧒</span><span class="cart-bee">🐝</span>
        </div>
        <div class="shop-banner-copy">
            <h1 id="account-page-title">My Account</h1>
            <nav aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a><span>›</span><span aria-current="page">My Account</span>
            </nav>
        </div>
        <div class="cart-banner-art cart-banner-art-right" aria-hidden="true">
            <span class="cart-bee">🐝</span><span class="cart-kid">👧</span>
        </div>
    </section>

    <section class="account-content">
        <div class="container account-layout">
            <aside class="account-sidebar">
                <div class="account-customer">
                    <span class="account-avatar">{{ strtoupper(substr($name, 0, 1)) }}</span>
                    <div>
                        <small>Welcome back</small>
                        <strong>{{ $name }}</strong>
                    </div>
                </div>

                <nav class="account-nav" aria-label="Account navigation">
                    <button type="button" :class="{ 'is-active': tab === 'dashboard' }" @click="tab = 'dashboard'">Dashboard</button>
                    <button type="button" :class="{ 'is-active': tab === 'orders' }" @click="tab = 'orders'">My Orders</button>
                    <button type="button" :class="{ 'is-active': tab === 'addresses' }" @click="tab = 'addresses'">Addresses</button>
                    <button type="button" :class="{ 'is-active': tab === 'details' }" @click="tab = 'details'">Account Details</button>
                    <button type="button" class="account-logout" wire:click="logout">Logout</button>
                </nav>
            </aside>

            <div class="account-main">
                <section class="account-panel" x-show="tab === 'dashboard'">
                    <span class="account-eyebrow">Your playful place</span>
                    <h2>Hello, {{ explode(' ', trim($name))[0] }}!</h2>
                    <p>From your account dashboard you can view recent orders, manage delivery addresses, and update your account details.</p>

                    <div class="account-stats">
                        <button type="button" class="account-stat" @click="tab = 'orders'">
                            <span>0</span><strong>Orders</strong><small>View order history</small>
                        </button>
                        <button type="button" class="account-stat" @click="tab = 'addresses'">
                            <span>0</span><strong>Addresses</strong><small>Manage delivery details</small>
                        </button>
                        <button type="button" class="account-stat" @click="tab = 'details'">
                            <span>✓</span><strong>Profile</strong><small>Keep details current</small>
                        </button>
                    </div>
                </section>

                <section class="account-panel" x-show="tab === 'orders'" x-cloak>
                    <span class="account-eyebrow">Purchase history</span>
                    <h2>My Orders</h2>
                    <div class="account-empty">
                        <span aria-hidden="true">📦</span>
                        <h3>No orders yet</h3>
                        <p>When you place an order, its status and details will appear here.</p>
                        <a href="{{ route('shop') }}" class="account-button">Start Shopping</a>
                    </div>
                </section>

                <section class="account-panel" x-show="tab === 'addresses'" x-cloak>
                    <span class="account-eyebrow">Delivery details</span>
                    <h2>My Addresses</h2>
                    <div class="account-empty">
                        <span aria-hidden="true">🏠</span>
                        <h3>No saved address</h3>
                        <p>Your checkout address will be available here for future orders.</p>
                        <a href="{{ route('checkout') }}" class="account-button">Go To Checkout</a>
                    </div>
                </section>

                <section class="account-panel" x-show="tab === 'details'" x-cloak>
                    <span class="account-eyebrow">Personal information</span>
                    <h2>Account Details</h2>

                    @if (session('profile-status'))
                        <div class="account-notice" role="status">{{ session('profile-status') }}</div>
                    @endif

                    <form wire:submit="updateProfile" class="account-form">
                        <div class="auth-field">
                            <label for="account-name">Full name</label>
                            <input id="account-name" type="text" wire:model="name" autocomplete="name">
                            @error('name') <small>{{ $message }}</small> @enderror
                        </div>
                        <div class="auth-field">
                            <label for="account-email">Email address</label>
                            <input id="account-email" type="email" wire:model="email" autocomplete="email">
                            @error('email') <small>{{ $message }}</small> @enderror
                        </div>
                        <button type="submit" class="account-button" wire:loading.attr="disabled" wire:target="updateProfile">Save Details</button>
                    </form>

                    <hr class="account-divider">
                    <h3>Change Password</h3>

                    @if (session('password-status'))
                        <div class="account-notice" role="status">{{ session('password-status') }}</div>
                    @endif

                    <form wire:submit="updatePassword" class="account-form">
                        <div class="auth-field">
                            <label for="current-password">Current password</label>
                            <input id="current-password" type="password" wire:model="current_password" autocomplete="current-password">
                            @error('current_password') <small>{{ $message }}</small> @enderror
                        </div>
                        <div class="account-form-row">
                            <div class="auth-field">
                                <label for="new-password">New password</label>
                                <input id="new-password" type="password" wire:model="password" autocomplete="new-password">
                                @error('password') <small>{{ $message }}</small> @enderror
                            </div>
                            <div class="auth-field">
                                <label for="new-password-confirmation">Confirm password</label>
                                <input id="new-password-confirmation" type="password" wire:model="password_confirmation" autocomplete="new-password">
                            </div>
                        </div>
                        <button type="submit" class="account-button" wire:loading.attr="disabled" wire:target="updatePassword">Change Password</button>
                    </form>
                </section>
            </div>
        </div>
    </section>
</div>
