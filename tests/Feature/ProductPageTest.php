<?php

namespace Tests\Feature;

use Tests\TestCase;

class ProductPageTest extends TestCase
{
    public function test_product_page_has_image_color_swatches(): void
    {
        $this->get('/product/wooden-rocking-horse')
            ->assertOk()
            ->assertSee('Choose a color')
            ->assertSee('Red')
            ->assertDontSee('&sat=-100', false)
            ->assertDontSee('&hue=95', false);
    }
}
