<?php

namespace Tests\Feature;

use App\Livewire\CheckoutPage;
use Livewire\Livewire;
use Tests\TestCase;

class CheckoutPageTest extends TestCase
{
    public function test_checkout_page_is_available(): void
    {
        $this->get('/checkout')
            ->assertOk()
            ->assertSee('Delivery details')
            ->assertSee('Complete address')
            ->assertSee('$40.45');
    }

    public function test_required_checkout_fields_are_validated(): void
    {
        Livewire::test(CheckoutPage::class)
            ->call('placeOrder')
            ->assertHasErrors(['name', 'email', 'phone', 'address', 'terms']);
    }

    public function test_customer_can_place_an_order(): void
    {
        Livewire::test(CheckoutPage::class)
            ->set('name', 'Ayesha Khan')
            ->set('email', 'ayesha@example.com')
            ->set('phone', '+92 300 1234567')
            ->set('address', 'House 14, Street 5, Gulberg, Lahore, Punjab 54000')
            ->set('note', 'Please call before delivery.')
            ->set('terms', true)
            ->call('placeOrder')
            ->assertHasNoErrors()
            ->assertSet('orderPlaced', true)
            ->assertSee('Your order has been placed.');
    }
}
