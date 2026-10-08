<?php

use App\Livewire\HomePage;
use App\Livewire\ProductPage;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class)->name('home');
Route::get('/product/{slug?}', ProductPage::class)->name('product.show');
