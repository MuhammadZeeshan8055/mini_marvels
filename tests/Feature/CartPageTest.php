<?php

namespace Tests\Feature;

use App\Livewire\CartPage;
use Livewire\Livewire;
use Tests\TestCase;

class CartPageTest extends TestCase
{
    public function test_cart_page_is_available(): void
    {
        $this->get('/cart')
            ->assertOk()
            ->assertSee('Light Weight Baby Stroller')
            ->assertSee('$40.45');
    }

    public function test_cart_interactions_update_totals(): void
    {
        Livewire::test(CartPage::class)
            ->call('changeQuantity', 1, 1)
            ->assertSee('$65.30')
            ->set('coupon', 'CUTIE10')
            ->call('applyCoupon')
            ->assertSee('Coupon applied')
            ->assertSee('$58.77')
            ->call('removeItem', 2)
            ->assertDontSee('Wooden Rocking Horse');
    }
}
