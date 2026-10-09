<?php

use App\Livewire\HomePage;
use App\Livewire\CartPage;
use App\Livewire\CheckoutPage;
use App\Livewire\ProductPage;
use App\Livewire\ShopPage;
use App\Livewire\AuthPage;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class)->name('home');
Route::get('/product/{slug?}', ProductPage::class)->name('product.show');
Route::get('/cart', CartPage::class)->name('cart');
Route::get('/checkout', CheckoutPage::class)->name('checkout');
Route::get('/shop', ShopPage::class)->name('shop');
Route::get('/login', AuthPage::class)->name('login')->defaults('mode', 'login');
Route::get('/register', AuthPage::class)->name('register')->defaults('mode', 'register');
