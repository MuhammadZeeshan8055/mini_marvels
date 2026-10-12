<?php

namespace Tests\Feature;

use App\Livewire\ShopPage;
use Livewire\Livewire;
use Tests\TestCase;

class ShopPageTest extends TestCase
{
    public function test_shop_page_is_available(): void
    {
        $this->get('/shop')
            ->assertOk()
            ->assertSee('Toys for curious little minds')
            ->assertSee('Stuffed Deer Toy');
    }

    public function test_products_can_be_searched_and_filtered(): void
    {
        Livewire::test(ShopPage::class)
            ->set('search', 'rocking')
            ->assertSee('Wooden Rocking Horse')
            ->assertDontSee('Stuffed Deer Toy')
            ->call('resetFilters')
            ->set('category', 'Learning Toys')
            ->set('age', '10+ Years')
            ->assertSee('Junior Science Set')
            ->assertDontSee('Funny Teddy');
    }

    public function test_price_and_sort_controls_update_results(): void
    {
        Livewire::test(ShopPage::class)
            ->set('maxPrice', 20)
            ->assertSee('Wooden Rocking Horse')
            ->assertDontSee('Junior Science Set')
            ->call('resetFilters')
            ->set('sort', 'price-high')
            ->assertSeeInOrder(['Junior Science Set', 'Creative Art Kit', 'Classic Board Game']);
    }

    public function test_age_link_opens_shop_with_matching_products(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee(route('shop', ['age' => '5-7 Years']), false);

        Livewire::withQueryParams(['age' => '5-7 Years'])
            ->test(ShopPage::class)
            ->assertSet('age', '5-7 Years')
            ->assertSee('Push Ride On Car')
            ->assertSee('Classic Board Game')
            ->assertDontSee('Funny Teddy');
    }
}
